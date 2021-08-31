<?php
class Fetcher
{

    public static function GET($url,$payload)
    {
        global $GET_CONFIG;
        $args = $GET_CONFIG + [CURLOPT_POSTFIELDS => json_encode($payload)];
        return CURLer::Call($url, $args);
    }
    public static function POST($url, $payload)
    {
        global $POST_CONFIG;
        $args = $POST_CONFIG + [CURLOPT_POSTFIELDS => json_encode($payload)];
        return CURLer::Call($url, $args);
    }
    public static function DELETE($url, $payload)
    {
        global $DELETE_CONFIG;
        $args = $DELETE_CONFIG + [CURLOPT_POSTFIELDS => json_encode($payload)];
        return CURLer::Call($url, $args);
    }
    public static function PATCH($url, $payload)
    {
        global $PATCH_CONFIG ;
        $args = $PATCH_CONFIG + [CURLOPT_POSTFIELDS => json_encode($payload)];
        return CURLer::Call($url, $args);
    }
}
class CURLer
{
    private static $err, $errmsg, $header;

    static function Call($url, $args)
    {
        $handle = curl_init($url);
        curl_setopt_array($handle, $args);;
        if (!($data = curl_exec($handle))) {
            self::$err     = curl_errno($handle);
            self::$errmsg  = curl_error($handle);
            self::$header  = curl_getinfo($handle);
            self::displayError();
            return false;
        }
        curl_close($handle);
        return $data;
    }
    private static function displayError()
    {
        echo "\nError: " . self::$errmsg . " with status: " . self::$err;
    }
}
