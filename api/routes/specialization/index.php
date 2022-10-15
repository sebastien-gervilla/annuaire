<?php

require_once __DIR__ . '/specialization_get.php';
require_once __DIR__ . '/../../inc/Response.php';

function useSpecializationRoutes(string $method, string $endpoint, array|null $body): Response
{
    switch ($method) {
        case 'GET':
            return useSpecializationGetRoutes($endpoint, $body);
        
        default:
            return new Response(400, false, "Method isn't supported.");
    }
}