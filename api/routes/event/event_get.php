<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/EventController.php';

function useEventGetRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'events':
            return Router::get(function () { return EventController::getAll(); });

        case 'event':
            $id = Request::getParam('_id');
            return Router::get(function () use($id) { return EventController::getById($id); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}