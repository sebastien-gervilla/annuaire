<?php

require_once __DIR__ . '/user_get.php';
require_once __DIR__ . '/user_post.php';
require_once __DIR__ . '/user_put.php';
require_once __DIR__ . '/user_delete.php';
require_once __DIR__ . '/../../inc/Response.php';

function useUserRoutes(string $method, string $endpoint, array|null $body): Response
{
    switch ($method) {
        case 'GET':
            return useUserGetRoutes($endpoint, $body);

        case 'POST':
            return useUserPostRoutes($endpoint, $body);

        case 'PUT':
            return useUserPutRoutes($endpoint, $body);

        case 'DELETE':
            return useUserDeleteRoutes($endpoint, $body);
        
        default:
            return new Response(400, false, "Method isn't supported.");
    }
}