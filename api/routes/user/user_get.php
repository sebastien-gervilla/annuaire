<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Request.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/UserController.php';

function useUserGetRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'users':
            return Router::get(function () { return UserController::getAll(); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}