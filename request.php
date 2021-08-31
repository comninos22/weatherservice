<?php
class Request
{
    static function GetBody()
    {
        $body = file_get_contents("php://input");
        $object = json_decode($body, true);
        $sanitizedArray = recursive_sanitization($object);
        return $sanitizedArray;
    }
}
function recursive_sanitization($array)
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = filter_var(recursive_sanitization($value), FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $array[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }
    return $array;
}
