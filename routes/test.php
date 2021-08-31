<?php
function handleTest()
{
    $body = Request::GetBody();

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            $url = "https://idontknow-a6776-default-rtdb.europe-west1.firebasedatabase.app/posts.json";
            print_r(Fetcher::GET($url));
            break;
        case "POST":
            $url = "https://idontknow-a6776-default-rtdb.europe-west1.firebasedatabase.app/posts.json";
            print_r(Fetcher::POST($url, $body["input"]));
            break;
        case "DELETE":
            $url = "https://idontknow-a6776-default-rtdb.europe-west1.firebasedatabase.app/posts/{$body['name']}.json";
            print_r(Fetcher::DELETE($url));
            break;
        case "PATCH":
            $url = "https://idontknow-a6776-default-rtdb.europe-west1.firebasedatabase.app/posts/{$body['name']}.json";
            print_r(Fetcher::PATCH($url, $body["inputPatch"]));
            break;
        default:
            break;
    }
}
