<?php

class Router {
    public static function get(callable $controllerCb) {
        // if (substr($_SERVER['REQUEST_URI'], 0, strlen($endpoint)) != $endpoint) {
        //     return;
        // }

        return $controllerCb();
    }
}