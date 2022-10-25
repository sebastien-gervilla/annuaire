<?php

require_once __DIR__ . '/participation_get.php';
require_once __DIR__ . '/participation_post.php';
require_once __DIR__ . '/participation_delete.php';
require_once __DIR__ . '/../../inc/Response.php';

function useParticipationRoutes(string $method, string $endpoint, array|null $body): Response
{
    switch ($method) {
        case 'GET':
            return useParticipationGetRoutes($endpoint, $body);
            
        case 'POST':
            return useParticipationPostRoutes($endpoint, $body);

        case 'DELETE':
            return useParticipationDeleteRoutes($endpoint, $body);
        
        default:
            return new Response(400, false, "Method isn't supported.");
    }
}