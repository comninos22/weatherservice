<?php
require("keys.php");
require("config.php");
require("helpers/encryptdecrypt.php");
require("helpers/validateToken.php");
require("routes/login.php");
require("routes/register.php");
require("routes/location.php");
require("routes/weather.php");
require("request.php");
require("persistence/database.php");
require("fetch/fetcher.php");
require("routes/test.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: text; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);



switch ($uri[3]) {
    case "login":
        handleLogin();
        break;
    case "register":
        handleRegister();
        break;
    case "location":
        $content = validateToken();
        print_r($content);
        handleLocation($content);
        break;
    case "profile":
        break;
    case "weather":
        $content = validateToken();
        print_r($content);
        handlePost();
        break;
    case "test":
        handleTest();
    default:
        break;
}
