<?php

require_once __DIR__ . '/event_get.php';
require_once __DIR__ . '/event_post.php';
require_once __DIR__ . '/event_put.php';
require_once __DIR__ . '/event_delete.php';
require_once __DIR__ . '/../../inc/Response.php';

function useEventRoutes(string $method, string $endpoint, array|null $body): Response
{
    switch ($method) {
        case 'GET':
            return useEventGetRoutes($endpoint, $body);
    
        case 'POST':
            return useEventPostRoutes($endpoint, $body);
    
        case 'PUT':
            return useEventPutRoutes($endpoint, $body);
    
        case 'DELETE':
            return useEventDeleteRoutes($endpoint, $body);
        
        default:
            return new Response(400, false, "Method isn't supported.");
    }
}