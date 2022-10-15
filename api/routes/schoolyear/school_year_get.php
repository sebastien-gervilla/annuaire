<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/SchoolYearController.php';

function useSchoolYearGetRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'schoolyears':
            return Router::get(function () { return SchoolYearController::getAll(); });

        case 'schoolyear':
            $id = $body['_id'];
            return Router::get(function () use($id) { return SchoolYearController::getById($id); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}