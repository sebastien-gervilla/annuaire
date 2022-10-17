<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/ParticipationController.php';

function useParticipationGetRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'participations':
            return Router::get(function () { return ParticipationController::getAll(); });

        case 'participation':
            $id = $body['_id'];
            return Router::get(function () use($id) { return ParticipationController::getById($id); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}