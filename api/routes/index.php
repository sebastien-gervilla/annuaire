<?php

require_once './student/index.php';
require_once '../inc/request-utils.php';

allowCors();

function useRedirections() {
    try {
        $fullUrl = getRequestUrl();
        $method = getRequestMethod();
        $endpoints = getUrlEndpoints();
        $endpoint = $endpoints['endpoint'];
        $model = $endpoints['model'];
        $body = getRequestBody();
    } catch (Error $error) {
        echo "Request error : $error";
    }

    function redirect(string $url, string $model, string $method, string $endpoint, array|null $body)
    {
        switch ($model) {
            case 'students':
                return useStudentRoutes($method, $endpoint, $body);
            
            default:
                return "Couldn't find url : " . $url;
        }
    }

    $res = redirect($fullUrl, $model, $method, $endpoint, $body);
    $res = gettype($res) === "string" ? $res : json_encode($res);
    return $res;
}

die(useRedirections()); // TODO : Status