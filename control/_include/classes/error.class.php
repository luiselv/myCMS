<?php
class Redirector
{
    public static function redirectOnError($buffer)
    {
        $lastError = error_get_last();
        if(!is_null($lastError) && $lastError['type'] === E_ERROR) {
            /*header('HTTP/1.1 302 Moved Temporarily');
            header('Status: 302 Moved Temporarily');
            header('Location: error.php');
            exit();*/
			header('HTTP/1.1 503 Service Temporarily Unavailable');  
	        header('Status: 503 Service Temporarily Unavailable');
			return '{"jsonrpc" : "2.0", "error" : {"code": 001, "message": "Fatat error" }}';			
        }
        return $buffer;
    }
}
?>