<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/SpecializationController.php';

function useSpecializationGetRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'specializations':
            return Router::get(function () { return SpecializationController::getAll(); });

        case 'specialization':
            $id = Request::getParam('_id');
            return Router::get(function () use($id) { return SpecializationController::getById($id); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}