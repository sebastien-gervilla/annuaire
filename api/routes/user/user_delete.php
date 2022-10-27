<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/UserController.php';

function useUserDeleteRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'user':
            $id = $body['_id'];
            return Router::delete(function () use($id) { return UserController::deleteUser($id); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}