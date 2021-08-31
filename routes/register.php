<?php
function handleRegister()
{
    $body = Request::GetBody();
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        echo json_encode(["error" => "invalid method"]);
        die();
    }
    if (!isset($body["email"]) || !isset($body["password"]) || !isset($body["name"])) {
        echo json_encode(["error" => "invalid request"]);
        die();
    }
    print_r($body);
    $email = $body["email"];
    $password = hash_hmac('sha256', $body["password"], $_SESSION["secret"]);
    $name = $body["name"];
    $db = DB::GetInstance();
    try {
        $db->RegisterUser($email, $password, $name);
        echo json_encode(["message" => "Congratulations " . $name . " you have succesfuly registered, please login"]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Something went wrong ".$e->getMessage()]);
        die();
    }
}
