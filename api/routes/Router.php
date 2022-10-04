<?php

class Router {
    public static function get(string $endpoint, callable $controllerCb)
    {
        // if (substr($_SERVER['REQUEST_URI'], 0, strlen($endpoint)) != $endpoint) {
        //     return;
        // }

        return $controllerCb();
    }
}