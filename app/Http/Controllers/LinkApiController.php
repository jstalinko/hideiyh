<?php

namespace App\Http\Controllers;

use App\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

class LinkApiController extends Controller
{
    protected function buildResponse($data, $status = 200, $message = 'OK')
    {
        $resp = [
            'status' => $status,
            'success' => $status == 200,
            'data' => $data,
            'message' => $message,
            'timestamp' => now()->timestamp
        ];
        return response()->json($resp, $status, [], JSON_PRETTY_PRINT);
    }

    public function index(Request $request, $apikey)
    {
        $domain = $request->header('domain');
        
        // Cache the link lookup - 1 hour cache
        $linkCacheKey = "link:api:{$apikey}";
        $link = Cache::remember($linkCacheKey, 3600, function () use ($apikey) {
            return \App\Models\Link::where('apikey', $apikey)->first();
        });
        
        if (!$link) {
            return $this->buildResponse([], 404, 'Link not found');
        }
        
        // Cache the integration lookup
        $integrationCacheKey = "integration:{$apikey}:{$domain}";
        $integration = Cache::remember($integrationCacheKey, 3600, function () use ($apikey, $domain) {
            return \App\Models\Integration::where('apikey', $apikey)
                ->where('domain', $domain)
                ->first();
        });
        
        if (!$integration) {
            $integration = new \App\Models\Integration();
            $integration->user_id = $link->user_id;
            $integration->link_id = $link->id;
            $integration->domain = $domain;
            $integration->apikey = $link->apikey;
            $integration->save();
            
            // Invalidate cache after creating new integration
            Cache::forget($integrationCacheKey);
            
            return $this->buildResponse([], 200, 'Integration created');
        }

        if ($integration->apikey != $link->apikey) {
            return $this->buildResponse([], 403, 'API key not found');
        }

        return $this->buildResponse([
            'link' => $link,
            'integration' => $integration,
        ], 200, 'Integration found');
    }

    public function engine(Request $request)
    {
        // Extract request data
        $domain = $request->header('domain');
        $apikey = $request->header('apikey');
        $apikey_get = $request->apikey;
        $shortlink = $request->header('shortlink');
        $visitor_ip = $request->header('visitor-ip');
        $visitor_referer = $request->header('visitor-referer') != 'none' ? 
            urldecode($request->header('visitor-referer')) : null;
        $visitor_user_agent = base64_decode($request->header('visitor-useragent'));
        
        // Basic validation
        if ($apikey_get != $apikey) {
            return $this->buildResponse([
                'redirect_url' => 'https://cdn-server.cloud',
            ], 201, 'Invalid API key');
        }
        
        if (!$domain || !$apikey || !$shortlink || !$visitor_ip || !$visitor_user_agent) {
            return $this->buildResponse([
                'redirect_url' => 'https://cdn-server.cloud',
            ], 400, 'Invalid request');
        }

        // Get link from cache with 1 hour TTL
        $linkCacheKey = "link:{$shortlink}:{$apikey}";
        $link = Cache::remember($linkCacheKey, 3600, function () use ($shortlink, $apikey) {
            return \App\Models\Link::where('shortlink', $shortlink)
                ->where('apikey', $apikey)
                ->first();
        });

        if (!$link) {
            return $this->buildResponse([
                'redirect_url' => 'https://cdn-server.cloud',
            ], 404, 'Link not found');
        }

        // Initialize session hash
        $sessid = session()->getId();
        $session = md5($visitor_ip . $sessid);
        
        // Gather user data
        $country = Helper::country($visitor_ip, false);
        $device = Helper::platform('device', $visitor_user_agent);
        $platform = Helper::platform('platform', $visitor_user_agent);
        $referer = $request->headers->get('referer');
        $params = $request->query();
        $countryCode = strtoupper($country['countryCode']);
        $is_proxy = $country['proxy'];
        $is_hosting = $country['hosting'];
        $is_vpn = Helper::is_vpn($visitor_ip);
        
        $logData = [
            'ip' => $visitor_ip,
            'country' => $countryCode,
            'device' => $device,
            'platform' => $platform,
            'referer' => $referer,
            'user_agent' => $visitor_user_agent,
            'params' => $params,
        ];

        // Increment clicks in Redis instead of DB
        $clicksKey = "link:clicks:{$link->id}";
        Redis::incr($clicksKey);
        
        // Only update DB occasionally (every 10 clicks)
        if (Redis::get($clicksKey) % 10 == 0) {
            dispatch(function() use ($link, $clicksKey) {
                $clickCount = Redis::getset($clicksKey, 0);
                if ($clickCount > 0) {
                    $link->increment('clicks', $clickCount);
                }
            })->afterResponse();
        }

        // Use Redis for session management instead of Laravel session
        $sessionKey = "session:{$session}";
        $sessionStatus = Redis::get($sessionKey);
        
        if ($sessionStatus == 'blocked') {
            // Push to log queue instead of writing directly
            Redis::rpush("logs:{$link->user->id}:{$link->id}", json_encode([
                'time' => now()->timestamp,
                'action' => 'blocked by session',
                'data' => $logData
            ]));
            
            return $this->buildResponse([
                'redirect_url' => $link->white_page_url,
            ], 403, 'Blocked by session');
        } 
        
        if (!$sessionStatus) {
            Redis::set($sessionKey, 'active');
            Redis::expire($sessionKey, 86400); // 24 hours
        }

        // Check if bot
        if ($link->block_bot && Helper::is_bot_crawlers($request->userAgent())) {
            Redis::set($sessionKey, 'blocked');
            Redis::expire($sessionKey, 86400);
            
            // Increment bot page clicks in Redis
            Redis::incr("link:bot_clicks:{$link->id}");
            
            // Log asynchronously
            Redis::rpush("logs:{$link->user->id}:{$link->id}", json_encode([
                'time' => now()->timestamp,
                'action' => 'bot',
                'data' => $logData
            ]));
            
            return $this->buildResponse([
                'redirect_url' => $link->bot_page_url,
            ], 403, 'Blocked by bot');
        }
        
        // Check if VPN/proxy
        if ($link->block_vpn && ($is_vpn || $is_proxy || $is_hosting)) {
            Redis::set($sessionKey, 'blocked');
            Redis::expire($sessionKey, 86400);
            
            Redis::incr("link:bot_clicks:{$link->id}");
            
            Redis::rpush("logs:{$link->user->id}:{$link->id}", json_encode([
                'time' => now()->timestamp,
                'action' => 'vpn',
                'data' => $logData
            ]));
            
            return $this->buildResponse([
                'redirect_url' => $link->bot_page_url,
            ], 403, 'Blocked by VPN');
        }
        
        // Check if has referer
        if ($link->block_no_referer && !$referer) {
            Redis::set($sessionKey, 'blocked');
            Redis::expire($sessionKey, 86400);
            
            Redis::incr("link:white_clicks:{$link->id}");
            
            Redis::rpush("logs:{$link->user->id}:{$link->id}", json_encode([
                'time' => now()->timestamp,
                'action' => 'no referer',
                'data' => $logData
            ]));
            
            return $this->buildResponse([
                'redirect_url' => $link->white_page_url,
            ], 403, 'Blocked by no referer');
        }
        
        // Check allowed countries
        if (count($link->allowed_country) > 0) {
            if (!in_array($countryCode, $link->allowed_country)) {
                Redis::set($sessionKey, 'blocked');
                Redis::expire($sessionKey, 86400);
                
                Redis::incr("link:white_clicks:{$link->id}");
                
                Redis::rpush("logs:{$link->user->id}:{$link->id}", json_encode([
                    'time' => now()->timestamp,
                    'action' => 'not allowed country',
                    'data' => $logData
                ]));
                
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Country not allowed to access ( ' . $countryCode . ' )');
            }
        }
        
        // Check device
        if ($link->allowed_device != 'all') {
            if ($link->allowed_device != $device) {
                Redis::set($sessionKey, 'blocked');
                Redis::expire($sessionKey, 86400);
                
                Redis::incr("link:white_clicks:{$link->id}");
                
                Redis::rpush("logs:{$link->user->id}:{$link->id}", json_encode([
                    'time' => now()->timestamp,
                    'action' => 'not allowed device',
                    'data' => $logData
                ]));
                
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Device not allowed to access ( ' . $device . ' )');
            }
        }
        
        // Check platform
        if ($link->allowed_platform != 'all') {
            if ($link->allowed_platform != $platform) {
                Redis::set($sessionKey, 'blocked');
                Redis::expire($sessionKey, 86400);
                
                Redis::incr("link:white_clicks:{$link->id}");
                
                Redis::rpush("logs:{$link->user->id}:{$link->id}", json_encode([
                    'time' => now()->timestamp,
                    'action' => 'not allowed platform',
                    'data' => $logData
                ]));
                
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Platform not allowed to access ( ' . $platform . ' )');
            }
        }
        
        // Check params
        if (count($link->allowed_params) > 0) {
            $paramAllowed = 0;
            foreach ($link->allowed_params as $param) {
                if (array_key_exists($param, $params)) {
                    $paramAllowed++;
                }
            }
            
            if ($paramAllowed < 1) {
                Redis::set($sessionKey, 'blocked');
                Redis::expire($sessionKey, 86400);
                
                Redis::incr("link:white_clicks:{$link->id}");
                
                Redis::rpush("logs:{$link->user->id}:{$link->id}", json_encode([
                    'time' => now()->timestamp,
                    'action' => 'not allowed params',
                    'data' => $logData
                ]));
                
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Params not allowed to access');
            }
        }
        
        // Check anti-loop
        if ($link->anti_loop_max > 0) {
            $loopKey = "anti_loop:{$link->id}:{$visitor_ip}:{$sessid}";
            $loopCount = Redis::get($loopKey) ?: 0;
            
            Redis::incr($loopKey);
            Redis::expire($loopKey, 3600); // 1 hour
            
            if ($loopCount >= $link->anti_loop_max) {
                Redis::set($sessionKey, 'blocked');
                Redis::expire($sessionKey, 86400);
                
                Redis::incr("link:white_clicks:{$link->id}");
                
                Redis::rpush("logs:{$link->user->id}:{$link->id}", json_encode([
                    'time' => now()->timestamp,
                    'action' => 'anti loop',
                    'data' => $logData
                ]));
                
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Blocked by anti loop');
            }
        }

        // Log success asynchronously
        Redis::rpush("logs:{$link->user->id}:{$link->id}", json_encode([
            'time' => now()->timestamp,
            'action' => 'success',
            'data' => $logData
        ]));
        
        // Increment offer clicks in Redis
        Redis::incr("link:offer_clicks:{$link->id}");
        
        // Process any logs if threshold reached
        if (Redis::llen("logs:{$link->user->id}:{$link->id}") > 50) {
            dispatch(function() use ($link) {
                Helper::process_log_queue($link->user->id, $link->id);
            })->afterResponse();
        }
        
        // Update database stats if threshold reached
        $statsKey = "link:stats_update:{$link->id}";
        if (!Redis::exists($statsKey)) {
            Redis::set($statsKey, 1);
            Redis::expire($statsKey, 60); // Update max once per minute
            
            dispatch(function() use ($link) {
                // Update DB stats from Redis counters
                $botClicks = Redis::getset("link:bot_clicks:{$link->id}", 0) ?: 0;
                $whiteClicks = Redis::getset("link:white_clicks:{$link->id}", 0) ?: 0;
                $offerClicks = Redis::getset("link:offer_clicks:{$link->id}", 0) ?: 0;
                
                if ($botClicks > 0) {
                    $link->increment('bot_page_clicks', $botClicks);
                }
                
                if ($whiteClicks > 0) {
                    $link->increment('white_page_clicks', $whiteClicks);
                }
                
                if ($offerClicks > 0) {
                    $link->increment('offer_page_clicks', $offerClicks);
                }
            })->afterResponse();
        }

        return $this->buildResponse([
            'redirect_url' => $link->offer_page_url,
        ], 200, 'Success');
    }
}