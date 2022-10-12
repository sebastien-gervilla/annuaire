<?php

class Router {
    public static function get(callable $controllerCb) { return self::request($controllerCb); }

    public static function post(callable $controllerCb) { return self::request($controllerCb); }

    public static function put(callable $controllerCb) { return self::request($controllerCb); }

    public static function delete(callable $controllerCb) { return self::request($controllerCb); }

    private static function request(callable $controllerCb) { return $controllerCb(); }
}