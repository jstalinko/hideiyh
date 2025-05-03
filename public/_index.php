<?php
session_start();
error_reporting(0);
define('HIDEIYH_API_URL', 'http://localhost:8000/api/');

function h_check_apikey()
{
    if(file_exists(__DIR__.'/hideiyh-apikey.php'))
    {
        return true;
    } else {
        return false;
    }
}
function h_get_domain()
{
    $host = $_SERVER['HTTP_HOST'];
    return preg_replace('/^www\./', '', $host);
}
function h_http($method, $url, $data = null, $options = [])
{
    static $ch = null;
    
    // Reuse cURL handle for connection pooling
    if ($ch === null) {
        $ch = curl_init();
    } else {
        curl_reset($ch); // Reset instead of creating a new handle
    }
    
    // Default options
    $default_options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_USERAGENT => "hideiyh@php",

        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4, // Prefer IPv4 for faster DNS
        CURLOPT_TCP_FASTOPEN => true, // Use TCP Fast Open if available
        CURLOPT_TCP_NODELAY => true, // Disable Nagle's algorithm
        CURLOPT_FORBID_REUSE => false, // Allow connection reuse
        CURLOPT_FRESH_CONNECT => false, // Don't force new connection
        
        // Only enable SSL verification in production
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ];
    
    // Merge user options with defaults
    curl_setopt_array($ch, $default_options);
    
    // Apply custom options if provided
    if (!empty($options)) {
        curl_setopt_array($ch, $options);
    }
    
    // Handle POST data
    if ($data) {
        if (is_array($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
    }
    
    // Execute request and get timing information
    $response = curl_exec($ch);
    
    // No need to close the handle as we're reusing it
    // curl_close($ch) is intentionally omitted
    
    // Handle response
    if ($response === false) {
        return null;
    }
    
    return json_decode($response, true);
}
function h_check_ioncube()
{
    if (extension_loaded('ionCube Loader')) {
        return true;
    } else {
        return false;
    }
}
function h_check_php_version()
{
    if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
        return true;
    } else {
        return false;
    }
}
function h_show_error($message)
{
    echo '<html>
    <head>
        <title>Error</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh;">
        <div style="max-width: 500px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 30px; margin: 20px; width: 100%;">
            <div style="text-align: center; margin-bottom: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <h1 style="color: #dc3545; text-align: center; font-size: 24px; margin-top: 0;">Error</h1>
            <p style="color: #343a40; text-align: center; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">' . htmlspecialchars($message) . '</p>
            <p style="color: #6c757d; text-align: center; font-size: 14px; margin-bottom: 0;">Please contact support for assistance.</p>
            <div style="text-align: center; margin-top: 20px;">
                <button onclick="window.history.back();" style="background-color: #0d6efd; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 14px;">Go Back</button>
            </div>
        </div>
    </body>
    </html>';
    exit();
}
if(h_check_apikey())
{
    require_once __DIR__.'/hideiyh-apikey.php';
    if(h_get_domain() != $hideiyh_domain)
    {
        h_show_error("Domain mismatch. Please check your API key and domain.");
        exit();
    }
    if(!h_check_ioncube())
    {
        h_show_error("Ioncube loader not found. Please install Ioncube loader.");
        exit();
    }
    if(!h_check_php_version())
    {
        h_show_error("PHP version not supported. Please use PHP 8.2 ");
        exit();
    }
    // check apikey 
    $x = h_http('GET', HIDEIYH_API_URL.'link/'.$hideiyh_apikey);
    print_r($x);
    echo file_get_contents(HIDEIYH_API_URL.'link/'.$hideiyh_apikey);
    echo "apa";
    exit;
} else {
    // Process form submission
    if(isset($_POST['apikey']) && !empty($_POST['apikey'])) {
        $apikey = trim($_POST['apikey']);
        $file = fopen(__DIR__.'/hideiyh-apikey.php', 'w');
        fwrite($file, "<?php\n");
        fwrite($file,"\$hideiyh_domain = '" . htmlspecialchars(h_get_domain(), ENT_QUOTES) . "';\n");
        fwrite($file, "\$hideiyh_apikey = '" . htmlspecialchars($apikey, ENT_QUOTES) . "';\n");
        fwrite($file, "?>");
        fclose($file);
        echo "<script>alert('API Key saved successfully');</script>";
        echo "<script>window.location.href='index.php';</script>";
        exit();
    }
    
  // Display API key input form
echo "<!DOCTYPE html>";
echo "<html lang=\"en\">";
echo "<head>";
echo "    <meta charset=\"UTF-8\">";
echo "    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">";
echo "    <title>API Key Setup - HIDEIYH CLOAKING & SHORTLINK</title>";
echo "    <!-- Bootstrap CSS -->";
echo "    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css\" rel=\"stylesheet\">";
echo "</head>";
echo "<body class=\"bg-light\">";
echo "    <div class=\"container py-5\">";
echo "        <div class=\"row justify-content-center\">";
echo "            <div class=\"col-md-6\">";
echo "                <div class=\"card shadow\">";
echo "                    <div class=\"card-body p-4\">";
echo "                        <h3 class=\"card-title mb-3\">API Key Setup</h3>";
echo "                        ";
echo "                        <form method=\"post\" action=\"\">";
echo "                            <div class=\"mb-3\">";
echo "                                <label for=\"apikey\" class=\"form-label\">Enter your API Key</label>";
echo "                                <input type=\"text\" class=\"form-control\" id=\"apikey\" name=\"apikey\" required>";
echo "                            </div>";
echo "                            ";
echo "                            <button type=\"submit\" class=\"btn btn-success\">Save API Key</button>";
echo "                        </form>";
echo "                        ";
echo "                        <div class=\"alert alert-info mt-4\">";
echo "                            <strong>Note:</strong> You need to enter your API key to use this integration.";
echo "                           <b> You can find your API key in Links menu and click the \"API Key\" button.</b>";
echo "                        </div>";
echo "                    </div>";
echo "                </div>";
echo "            </div>";
echo "        </div>";
echo "    </div>";
echo "    ";
echo "    <!-- Bootstrap JS -->";
echo "    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js\"></script>";
echo "</body>";
echo "</html>";
exit();
}
?>