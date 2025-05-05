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
}
