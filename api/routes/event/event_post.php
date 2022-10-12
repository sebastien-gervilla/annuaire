<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/EventController.php';

function useEventPostRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'event':
            $event = $body;
            return Router::post(function () use($event) { return EventController::createEvent($event); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}