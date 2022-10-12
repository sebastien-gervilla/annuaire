<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/EventController.php';

function useEventDeleteRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'event':
            $id = $body['_id'];
            return Router::delete(function () use($id) { return EventController::deleteEvent($id); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}