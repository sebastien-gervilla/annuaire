<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/ParticipationController.php';

function useParticipationDeleteRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'participation':
            $studentId = $body['studentId'];
            $eventId = $body['eventId'];
            return Router::delete(function () use($studentId, $eventId) { 
                return ParticipationController::deleteParticipation($studentId, $eventId); 
            });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}