<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/ParticipationController.php';

function useParticipationPostRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'participations':
            $studentId = $body['studentId'];
            $participations = $body['participations'];
            return Router::post(function () use($participations, $studentId) { 
                return ParticipationController::createParticipations($participations, $studentId); 
            });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}