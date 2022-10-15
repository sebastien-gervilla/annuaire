<?php

require_once __DIR__ . '/school_year_get.php';
require_once __DIR__ . '/../../inc/Response.php';

function useSchoolYearRoutes(string $method, string $endpoint, array|null $body): Response
{
    switch ($method) {
        case 'GET':
            return useSchoolYearGetRoutes($endpoint, $body);
        
        default:
            return new Response(400, false, "Method isn't supported.");
    }
}