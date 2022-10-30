<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/SpecializationController.php';

function useSpecializationPostRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'specialization':
            $specialization = $body;
            return Router::get(function () use($specialization) { 
                return SpecializationController::createSpecialization($specialization); 
            });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}