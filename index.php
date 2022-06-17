<?php
class HttpCodeHandler {
    public static $code;
    public static $message;

    // constructor
    public function __construct($code, $message) {
        $this->code = 404;
        $this->message = "Not Found";
    }
    public static function getCode($url) { 
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);
        return $httpCode;
    }

    public static function setLog($mesage, $logDir) {

        // check if directory exists
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $log_file_data = $logDir.'/log_' . date('d-M-Y') . '.log';

        file_put_contents($log_file_data, $mesage . "\n", FILE_APPEND);
    }

    public static function check($url){
        $httpCode = self::getCode($url);
        if($httpCode == 404){
            $mesage = "Url (".$url.") not found - ".date('h:m:i d-M-Y');
            $dir = 'logs';
            self::setLog($mesage, $dir);
        }else{
            return $httpCode;
        }
    }
}

$url = "http://menu-app.test/get-slider1";
HttpCodeHandler::check($url);






?>