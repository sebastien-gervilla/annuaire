<?php

require_once './student/index.php';
require_once '../inc/Response.php';
require_once '../inc/request-utils.php';

allowCors();

function useRedirections() {

    function useRoutes(string $url, string $model, string $method, string $endpoint, array|null $body): Response
    {
        switch ($model) {
            case 'students':
                return useStudentRoutes($method, $endpoint, $body);
            
            default:
                return new Response(400, false, "Coudln't find url : $url");
        }
    }

    try {
        $fullUrl = getRequestUrl();
        $method = getRequestMethod();
        $endpoints = getUrlEndpoints();
        $endpoint = $endpoints['endpoint'];
        $model = $endpoints['model'];
        $body = getRequestBody();

        $res = useRoutes($fullUrl, $model, $method, $endpoint, $body);
    } catch (\Throwable $error) {
        $res = new Response(400, false, "Un problème est survenu, réessayez plus tard.", array(
            "error" => $error
        ));
    } finally {
        return $res->send();
    }
}

die(useRedirections()); // TODO : Status