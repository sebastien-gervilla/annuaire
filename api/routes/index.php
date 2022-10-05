<?php

require_once '../config/settings.php';
require_once './student/index.php';

function useRedirections()
{
    // $endpoints list, if endpoints.length < 2
    try {
        $method = $_SERVER['REQUEST_METHOD'];
        $endpoints = getRouteEndpoints($_SERVER['REQUEST_URI']);
        $endpointsList = explode('/', $endpoints);
        $model = $endpointsList[0];
        $endpoint = $endpointsList[1];
        $body = json_decode(file_get_contents("php://input"), true);
    } catch (Error $error) {
        echo "Request error : $error";
    }

    function redirect(string $model, string $method, string $endpoint, array $body)
    {
        switch ($model) {
            case 'students':
                return useStudentRoutes($method, $endpoint, $body);
            
            default:
                // Route not found
                break;
        }
    }

    $res = redirect($model, $method, $endpoint, $body);
    return json_encode($res, JSON_PRETTY_PRINT);
}

echo useRedirections();