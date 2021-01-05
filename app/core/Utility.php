<?php
class Utility 
{
    public static function validateEmail($email)
    {   
        return (bool) preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email);
    }

    public static function loggerAll($dataArray)
    {
        if (file_exists(LoggerConfig::$logPath) && is_writable(LoggerConfig::$logPath))
        {
            $fp         = fopen(LoggerConfig::$logPath, "a");
            $logMessage = date("Y-m-d H:i:s") . " | " . implode(" | ", $dataArray);
            fwrite($fp, $logMessage . "\r\n\r\n");
            fclose($fp);
        }
    }
}