<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/EventController.php';

function useEventPutRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'event':
            $event = $body;
            $id = $body['_id'];
            return Router::put(function () use($id, $event) { 
                return EventController::modifyEvent($id, $event); 
            });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}