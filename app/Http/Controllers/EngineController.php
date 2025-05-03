<?php

namespace App\Http\Controllers;

use App\Helper;
use Illuminate\Http\Request;

class EngineController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $slug = $request->slug;
        $link = \App\Models\Link::where('shortlink', $slug)->first();
        if(!$link) return response()->json(['message' => 'Link not found'], 404);

        // init session by ip hash
        $sessid = session()->getId();
        $session = md5(Helper::ip() . $sessid);

        

        /**
         * get country and more information about visitors
         */
        $country = Helper::country(Helper::ip() , false);
        $device = Helper::platform('device' , $request->userAgent());
        $platform = Helper::platform('platform' , $request->userAgent());
        $referer = $request->headers->get('referer');
        $params = $request->query();
        $countryCode = strtoupper($country['countryCode']);
        $is_proxy = $country['proxy'];
        $is_hosting = $country['hosting'];
        $is_vpn  = Helper::is_vpn(Helper::ip());
        $user_agent = $request->userAgent();
        $ip = Helper::ip();
        $logData = [
            'ip' => $ip,
            'country' => $countryCode,
            'device' => $device,
            'platform' => $platform,
            'referer' => $referer,
            'user_agent' => $user_agent,
            'params' => $params,
        ];
       

        if(session()->has($session)) {

            $sessionStatus = session()->get($session);
            if($sessionStatus == 'blocked') {
                Helper::write_log($link->user->id , $link->id, 'blocked by session', [] );
                return Helper::render_white($link->white_page_url, $link->render_white_page_method);
            }
        } else {
            session()->put($session, 'active');
            session()->save();
        }

        /** check if block bot  */
        if($link->block_bot && Helper::is_bot_crawlers($request->userAgent())) {
            session()->put($session,'blocked');
            session()->save();
            Helper::write_log($link->user->id , $link->id, 'bot', $logData );
            return Helper::render_bot($link->bot_page_url, $link->render_bot_page_method);
        }
        /** check if block vpn */
        if($link->block_vpn) {
           
            if($is_vpn || $is_proxy || $is_hosting) {
                session()->put($session,'blocked');
                session()->save();
                Helper::write_log($link->user->id , $link->id, 'vpn', $logData );
                return Helper::render_bot($link->bot_page_url, $link->render_bot_page_method);
            }
        }
        /** check if block no referer */
        if($link->block_no_referer) {
            if(!$referer) {
                session()->put($session,'blocked');
                session()->save();
                Helper::write_log($link->user->id , $link->id, 'no referer', $logData );
                return Helper::render_white($link->white_page_url, $link->render_white_page_method);
            }
        }
        /** check if allowed country */
        if(count($link->allowed_country) > 0) {
            $allowed_country = $link->allowed_country;
            if(!in_array($countryCode, $allowed_country)) {
                session()->put($session,'blocked');
                session()->save();
                Helper::write_log($link->user->id , $link->id, 'not allowed country', $logData );
                return Helper::render_white($link->white_page_url, $link->render_white_page_method);
            }
        }

        /** check if allowed device */
        if($link->allowed_device != 'all') {
            if($link->allowed_device != $device) {
                session()->put($session,'blocked');
                session()->save();
                Helper::write_log($link->user->id , $link->id, 'not allowed device', $logData );
                return Helper::render_white($link->white_page_url, $link->render_white_page_method);
            }
        }
        /** check if allowed platform */
        if($link->allowed_platform != 'all') {
            if($link->allowed_platform != $platform) {
                session()->put($session,'blocked');
                session()->save();
                Helper::write_log($link->user->id , $link->id, 'not allowed platform', $logData );
                return Helper::render_white($link->white_page_url, $link->render_white_page_method);
            }
        }
        /** check if allowed params */
        if(count($link->allowed_params) > 0) {
            $allowed_params = $link->allowed_params;
           // dd($allowed_params , $params);
           $paramAllowed = 0;
            foreach($allowed_params as $param) {
                if(array_key_exists($param, $params)) {
                    $paramAllowed++;
                }
            }
            if($paramAllowed < 1)
            {
                session()->put($session,'blocked');
                session()->save();
                Helper::write_log($link->user->id , $link->id, 'not allowed params', $logData );
                return Helper::render_white($link->white_page_url, $link->render_white_page_method);
            }
        }
        /** check if anti loop */
        if($link->anti_loop_max > 0) {
            $sessionLoopMax =  'anti_loop_'.sha1(Helper::ip() . $sessid);
            if(session()->has($sessionLoopMax)) {
                $antiLoopCount = session()->get($sessionLoopMax);
            } else {
                $antiLoopCount = 0;
            }
            session()->put($sessionLoopMax, $antiLoopCount + 1);
            session()->save();
            if($antiLoopCount >= $link->anti_loop_max) {
                session()->put($session,'blocked');
                session()->save();
                Helper::write_log($link->user->id , $link->id, 'anti loop', $logData );
                return Helper::render_white($link->white_page_url, $link->render_white_page_method);
            }
        }
        
    
        Helper::write_log($link->user->id , $link->id, 'success', $logData );
        $link->clicks++;
        $link->save();

        return Helper::render_offer($link->offer_page_url, false, $link->render_offer_page_method);
        
    }
}
