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
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}