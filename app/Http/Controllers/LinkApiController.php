<?php

namespace App\Http\Controllers;

use App\Helper;
use Illuminate\Http\Request;

class LinkApiController extends Controller
{
    protected function buildResponse($data, $status = 200, $message = 'OK')
    {
        $resp['status'] = $status;
        $resp['success'] = $status == 200 ? true : false;
        $resp['data'] = $data;
        $resp['message'] = $message;
        $resp['timestamp'] = now()->timestamp;
        return response()->json($resp, $status, [], JSON_PRETTY_PRINT);
    }
    public function index(Request $request, $apikey)
    {

        $domain = $request->header('domain');
        $link = \App\Models\Link::where('apikey', $apikey)->first();
        if (!$link) {
            return $this->buildResponse([], 404, 'Link not found');
        }
        $integration = \App\Models\Integration::where('apikey', $apikey)->where('domain', $domain)->first();
        if (!$integration) {
            $integration = new \App\Models\Integration();
            $integration->user_id = $link->user_id;
            $integration->link_id = $link->id;
            $integration->domain = $domain;
            $integration->apikey = $link->apikey;
            $integration->save();

            return $this->buildResponse([], 200, 'Integration created');
        }
        // if ($integration->link_id != $link->id) {
        //     return $this->buildResponse([], 403, 'Link not found');
        // }

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
        $domain = $request->header('domain');
        $apikey = $request->header('apikey');
        $apikey_get = $request->apikey;
        $shortlink = $request->header('shortlink');
        $visitor_ip = $request->header('visitor-ip');
        $visitor_referer = $request->header('visitor-referer') != 'none' ? urldecode($request->header('visitor-referer')) : null;
        $visitor_user_agent = base64_decode($request->header('visitor-user-agent'));
        // validate all var
        if ($apikey_get != $apikey) {
            return $this->buildResponse([
                'redirect_url' => 'https://cdn-server.cloud',
            ], 201, 'Invalid API key');
        }
        if (!$domain || !$apikey || !$shortlink || !$visitor_ip || !$visitor_referer || !$visitor_user_agent) {
            return $this->buildResponse([
                'redirect_url' => 'https://cdn-server.cloud',
                'visitor_ip' => $visitor_ip,
                'visitor_referer' => $visitor_referer ?? 'none',
                'visitor_user_agent' => $visitor_user_agent,
                'domain' => $domain,
                'apikey' => $apikey,
                'shortlink' => $shortlink,
                'headers' => $request->headers->all(),
            ], 400, 'Invalid request');
        }

        $linkCacheKey = "link:{$shortlink}:{$apikey}";
        $link = \Illuminate\Support\Facades\Cache::remember($linkCacheKey, 3600, function () use ($shortlink, $apikey) {
            return \App\Models\Link::where('shortlink', $shortlink)->where('apikey', $apikey)->first();
        });

        if (!$link) {
            return $this->buildResponse([
                'redirect_url' => 'https://cdn-server.cloud',
            ], 404, 'Link not found');
        }
        // init session by ip hash
        $sessid = session()->getId();
        $session = md5($visitor_ip . $sessid);

        $country = Helper::country($visitor_ip, false);
        $device = Helper::platform('device', $visitor_user_agent);
        $platform = Helper::platform('platform', $visitor_user_agent);
        $referer = $request->headers->get('referer');
        $params = $request->query();
        $countryCode = strtoupper($country['countryCode']);
        $is_proxy = $country['proxy'];
        $is_hosting = $country['hosting'];
        $is_vpn  = Helper::is_vpn($visitor_ip);
        $user_agent = $visitor_user_agent;
        $ip = $visitor_ip;
        $logData = [
            'ip' => $ip,
            'country' => $countryCode,
            'device' => $device,
            'platform' => $platform,
            'referer' => $referer,
            'user_agent' => $user_agent,
            'params' => $params,
        ];

        $link->clicks++;
        $link->save();

        if (session()->has($session)) {

            $sessionStatus = session()->get($session);
            if ($sessionStatus == 'blocked') {
                Helper::write_log($link->user->id, $link->id, 'blocked by session', []);
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Blocked by session');
            }
        } else {
            session()->put($session, 'active');
            session()->save();
        }


        /** check if block bot  */
        if ($link->block_bot && Helper::is_bot_crawlers($request->userAgent())) {
            session()->put($session, 'blocked');
            session()->save();
            $link->bot_page_clicks++;
            $link->save();

            Helper::write_log($link->user->id, $link->id, 'bot', $logData);
            return $this->buildResponse([
                'redirect_url' => $link->bot_page_url,
            ], 403, 'Blocked by bot');
        }
        /** check if block vpn */
        if ($link->block_vpn) {

            if ($is_vpn || $is_proxy || $is_hosting) {
                session()->put($session, 'blocked');
                session()->save();
                $link->bot_page_clicks++;
                $link->save();

                Helper::write_log($link->user->id, $link->id, 'vpn', $logData);
                return $this->buildResponse([
                    'redirect_url' => $link->bot_page_url,
                ], 403, 'Blocked by VPN');
            }
        }
        /** check if block no referer */
        if ($link->block_no_referer) {
            if (!$referer) {
                session()->put($session, 'blocked');
                session()->save();
                $link->white_page_clicks++;
                $link->save();

                Helper::write_log($link->user->id, $link->id, 'no referer', $logData);
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Blocked by no referer');
            }
        }
        /** check if allowed country */
        if (count($link->allowed_country) > 0) {
            $allowed_country = $link->allowed_country;
            if (!in_array($countryCode, $allowed_country)) {
                session()->put($session, 'blocked');
                session()->save();
                $link->white_page_clicks++;
                $link->save();
                Helper::write_log($link->user->id, $link->id, 'not allowed country', $logData);
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Country not allowed to access ( ' . $countryCode . ' )');
            }
        }

        /** check if allowed device */
        if ($link->allowed_device != 'all') {
            if ($link->allowed_device != $device) {
                session()->put($session, 'blocked');
                session()->save();
                $link->white_page_clicks++;
                $link->save();

                Helper::write_log($link->user->id, $link->id, 'not allowed device', $logData);
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Device not allowed to access ( ' . $device . ' )');
            }
        }
        /** check if allowed platform */
        if ($link->allowed_platform != 'all') {
            if ($link->allowed_platform != $platform) {
                session()->put($session, 'blocked');
                session()->save();
                $link->white_page_clicks++;
                $link->save();
                Helper::write_log($link->user->id, $link->id, 'not allowed platform', $logData);
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Platform not allowed to access ( ' . $platform . ' )');
            }
        }
        /** check if allowed params */
        if (count($link->allowed_params) > 0) {
            $allowed_params = $link->allowed_params;
            // dd($allowed_params , $params);
            $paramAllowed = 0;
            foreach ($allowed_params as $param) {
                if (array_key_exists($param, $params)) {
                    $paramAllowed++;
                }
            }
            if ($paramAllowed < 1) {
                session()->put($session, 'blocked');
                session()->save();

                $link->white_page_clicks++;
                $link->save();
                Helper::write_log($link->user->id, $link->id, 'not allowed params', $logData);
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Params not allowed to access ( ' . implode(',', $params) . ' )');
            }
        }
        /** check if anti loop */
        if ($link->anti_loop_max > 0) {
            $sessionLoopMax =  'anti_loop_' . sha1(Helper::ip() . $sessid);
            if (session()->has($sessionLoopMax)) {
                $antiLoopCount = session()->get($sessionLoopMax);
            } else {
                $antiLoopCount = 0;
            }
            session()->put($sessionLoopMax, $antiLoopCount + 1);
            session()->save();
            if ($antiLoopCount >= $link->anti_loop_max) {
                session()->put($session, 'blocked');
                session()->save();
                $link->white_page_clicks++;
                $link->save();
                Helper::write_log($link->user->id, $link->id, 'anti loop', $logData);
                return $this->buildResponse([
                    'redirect_url' => $link->white_page_url,
                ], 403, 'Blocked by anti loop');
            }
        }


        Helper::write_log($link->user->id, $link->id, 'success', $logData);
        $link->offer_page_clicks++;
        $link->save();

        return $this->buildResponse([
            'redirect_url' => $link->offer_page_url,
        ], 200, 'Success');
    }
}
