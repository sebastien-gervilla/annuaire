<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Request.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/AuthController.php';

function useAuthGetRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'isauth':
            $token = Request::getParam('token');
            return Router::get(function () use($token) { return AuthController::isAuth($token); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}