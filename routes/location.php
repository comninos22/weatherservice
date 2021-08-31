<?php
function handleLocation($content)
{
    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            handleGetUserLocations($content);
            break;
        case "POST":
            handleNewLocation($content);
            break;
        case "DELETE":
            handleDeleteLocation($content);
            break;
    }
}


function handleNewLocation($content)
{
    $body = Request::GetBody();
    $db = DB::GetInstance();
    if (!isset($body["name"]) || !isset($body["coordX"]) || !isset($body["coordY"]) || !isset($body["fullAddress"])) {
        echo json_encode(["error" => "Invalid parameters"]);
    }
    $db->RegisterLocation($body["name"], $content["id"], $body["coordX"], $body["coordY"], $body["fullAddress"]);
    echo json_encode([""]);
}
function handleDeleteLocation($content)
{
    $body = Request::GetBody();
    $db = DB::GetInstance();
    if (!isset($body["id"])) {
        echo json_encode(["error" => "No location selected"]);
        die();
    }
    try {
        if ($db->DeleteLocation($body["id"], $content["id"]) == 1) {
            echo json_encode(["message" => "Location deleted succesfuly"]);
        } else {
            throw new Exception();
        }
    } catch (Exception $e) {
        echo json_encode(["error" => "Deletion not possible"]);
        echo $e->getMessage();
    }
}
function handleGetUserLocations($content)
{
    $db = DB::GetInstance();
    $userID = $content["id"];
    if (count($locations = $db->GetUserLocations($userID)) == 0) {
        echo json_encode(["message" => "No locations set"]);
    } else {
        echo json_encode(["locations" => $locations]);
    };
}
