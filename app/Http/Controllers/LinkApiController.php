<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LinkApiController extends Controller
{
    protected function buildResponse($data, $status = 200,$message = 'OK')
    {
        $resp['status'] = $status;
        $resp['success'] = $status == 200 ? true : false;
        $resp['data'] = $data;
        $resp['message'] = $message;
        $resp['timestamp'] = now()->timestamp;
        return response()->json($resp, $status , [],JSON_PRETTY_PRINT);
    }
    public function index(Request $request, $apikey)
    {
        
        $domain = $request->header('domain');
        $link = \App\Models\Link::where('apikey', $apikey)->first();
        if (!$link) {
            return $this->buildResponse([], 404, 'Link not found');
        }
        $integration = \App\Models\Integration::where('apikey', $apikey)->where('domain',$domain)->first();
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
        $visitor_ip = $request->header('visitor_ip');
        $visitor_referer = $request->header('visitor_referer');
        $visitor_user_agent = $request->header('visitor_user_agent');
        // validate all var
        if($apikey_get != $apikey)
        {
            return $this->buildResponse([
                'redirect_url' => 'https://cdn-server.cloud',
            ],201,'Invalid API key');
        }
        if (!$domain || !$apikey || !$shortlink || !$visitor_ip || !$visitor_referer || !$visitor_user_agent) {
            return $this->buildResponse([
                'redirect_url' => 'https://cdn-server.cloud',
                'visitor_ip' => $visitor_ip,
                'visitor_referer' => $visitor_referer,
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

        return $this->buildResponse([
            'redirect_url' => 'https://google.com',
            'header' => $request->header(),
        ] , 200, 'Blocked Redirect');
    }
}
