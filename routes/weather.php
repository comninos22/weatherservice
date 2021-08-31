<?php
function handleWeather($token)
{
    $db = DB::GetInstance();
    $locations = $db->GetUserLocations($token["id"]);
    $weatherOfLocations = array();

    foreach ($locations as $location) {
        $api = "https://api.openweathermap.org/data/2.5/weather?id=524901&appid=17d7c3b92401b64e09bf9f8916b65d66&q={$location['fullAddress']}&units=metric";
        $api = "https://idontknow-a6776-default-rtdb.europe-west1.firebasedatabase.app/posts.json";
        $data = Fetcher::GET($api);
        array_push($weatherOfLocations, ["name" => $location['fullAddress'], ["forecast" => json_decode($data)]]);
    }

    echo json_encode($weatherOfLocations);
}
function handleGet()
{
    $api = "https://idontknow-a6776-default-rtdb.europe-west1.firebasedatabase.app/posts.json";
    $data = Fetcher::GET($api);
    print_r($data);
}
function handlePost()
{
    $api = "https://idontknow-a6776-default-rtdb.europe-west1.firebasedatabase.app/posts.json";
    $data = Fetcher::POST($api, Request::GetBody());
}
