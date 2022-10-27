<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/UserController.php';

function useUserPutRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'user':
            $user = $body;
            $id = $body['_id'];
            return Router::put(function () use($id, $user) { 
                return UserController::modifyUser($id, $user); 
            });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}