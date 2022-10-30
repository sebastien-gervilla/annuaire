<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/SchoolYearController.php';

function useSchoolYearPostRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'schoolyear':
            $schoolYear = $body;
            return Router::get(function () use($schoolYear) { 
                return SchoolYearController::createSchoolYear($schoolYear); 
            });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}