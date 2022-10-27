<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/UserController.php';

function useUserPostRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'user':
            $logs = $body;
            return Router::post(function () use($logs) { return UserController::createUser($logs); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}