<?php

require_once __DIR__ . '/../config/settings.php';

function getRequestUrl() {
    return $_SERVER['REQUEST_URI'];
}

function getApiUrl() {
    $url = $_SERVER['REQUEST_URI'];
    $baseURL = getSettings()['apiURL'];
    return str_replace($baseURL, '', $url);
}

function getUrlEndpoints() {
    $routeUrl = getApiUrl();
    $endpoints = explode('/', $routeUrl);
    try {
        $model = $endpoints[0];
        $endpoint = count($endpoints) < 2 ? '' : $endpoints[1];
    } catch (\Throwable $error) {
        throw $error;
    }

    return array(
        "model" => $model,
        "endpoint" => $endpoint
    );
}

function getRequestBody() {
    $body = file_get_contents("php://input");
    return json_decode($body, true);
}

function getRequestMethod() {
    try {
        $method = $_SERVER['REQUEST_METHOD'];
        $methods = ['GET', 'POST', 'PUT', 'DELETE'];
        if (!in_array($method, $methods))
            trigger_error("Invalid method", E_USER_ERROR);
        return $method;
    } catch (\Throwable $error) {
        throw $error;
    }
}

function allowCors() {
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    }
}