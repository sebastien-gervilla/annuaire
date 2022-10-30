<?php

require_once __DIR__ . '/school_year_get.php';
require_once __DIR__ . '/school_year_post.php';
require_once __DIR__ . '/school_year_put.php';
require_once __DIR__ . '/school_year_delete.php';
require_once __DIR__ . '/../../inc/Response.php';

function useSchoolYearRoutes(string $method, string $endpoint, array|null $body): Response
{
    switch ($method) {
        case 'GET':
            return useSchoolYearGetRoutes($endpoint, $body);

        case 'POST':
            return useSchoolYearPostRoutes($endpoint, $body);

        case 'PUT':
            return useSchoolYearPutRoutes($endpoint, $body);

        case 'DELETE':
            return useSchoolYearDeleteRoutes($endpoint, $body);
    
        default:
            return new Response(400, false, "Method isn't supported.");
    }
}