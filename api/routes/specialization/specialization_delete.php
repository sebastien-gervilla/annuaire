<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/SpecializationController.php';

function useSpecializationDeleteRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'specialization':
            $id = $body['_id'];
            return Router::get(function () use($id) { 
                return SpecializationController::deleteSpecialization($id); 
            });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}