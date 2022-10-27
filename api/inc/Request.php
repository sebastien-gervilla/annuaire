<?php

require_once __DIR__ . "/../config/settings.php";

class Request {

    public static function getUrl() {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getParam(string $param): string|null {
        return isset($_GET[$param]) ? $_GET[$param] : null;
    }

    public static function getBody() {
        $json = file_get_contents("php://input");
        return json_decode($json, true);
    }

    public static function getModel() {
        try {
            $endpoints = self::getEndpoints();
            return $endpoints[0];
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public static function getEndpoint() {
        try {
            $endpoints = self::getEndpoints();
            return (count($endpoints) < 2) ? '' : $endpoints[1];
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    private static function getEndpoints() {
        $url = $_SERVER['REQUEST_URI'];
        $baseURL = getSettings()['apiURL'];
        $routeUrl = str_replace($baseURL, '', $url);
        $endpoints = explode('/', $routeUrl);
        return $endpoints;
    }

    public static function getCookie(string $key) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    // CORS

    public static function allowCors(): void {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        }
    }
}