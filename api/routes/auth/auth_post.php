<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/AuthController.php';

function useAuthPostRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'login':
            $logs = $body;
            return Router::post(function () use($logs) { return AuthController::login($logs); });

        case 'logout':
            if (isset($body['token'])) $token = str_replace($body['token'], '', 'token=');
            return Router::get(function () use($token) { return AuthController::logout($token); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}