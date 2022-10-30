<?php

require_once __DIR__ . '/specialization_get.php';
require_once __DIR__ . '/specialization_post.php';
require_once __DIR__ . '/specialization_put.php';
require_once __DIR__ . '/specialization_delete.php';
require_once __DIR__ . '/../../inc/Response.php';

function useSpecializationRoutes(string $method, string $endpoint, array|null $body): Response
{
    switch ($method) {
        case 'GET':
            return useSpecializationGetRoutes($endpoint, $body);

        case 'POST':
            return useSpecializationPostRoutes($endpoint, $body);

        case 'PUT':
            return useSpecializationPutRoutes($endpoint, $body);

        case 'DELETE':
            return useSpecializationDeleteRoutes($endpoint, $body);
        
        default:
            return new Response(400, false, "Method isn't supported.");
    }
}