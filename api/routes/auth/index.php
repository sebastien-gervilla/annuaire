<?php

require_once __DIR__ . '/auth_get.php';
require_once __DIR__ . '/auth_post.php';
require_once __DIR__ . '/../../inc/Response.php';

function useAuthRoutes(string $method, string $endpoint, array|null $body): Response
{
    switch ($method) {
        case 'GET':
            return useAuthGetRoutes($endpoint, $body);

        case 'POST':
            return useAuthPostRoutes($endpoint, $body);
        
        default:
            return new Response(400, false, "Method isn't supported.");
    }
}