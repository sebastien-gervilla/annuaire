<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/SpecializationController.php';

function useSpecializationPutRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'specialization':
            $specialization = $body;
            $id = $body['_id'];
            return Router::get(function () use($id, $specialization) { 
                return SpecializationController::modifySpecialization($id, $specialization); 
            });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}