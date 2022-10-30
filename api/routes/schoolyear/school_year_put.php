<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/SchoolYearController.php';

function useSchoolYearPutRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'schoolyear':
            $schoolYear = $body;
            $id = $body['_id'];
            return Router::get(function () use($id, $schoolYear) { 
                return SchoolYearController::modifySchoolYear($id, $schoolYear); 
            });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}