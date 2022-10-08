<?php

require_once __DIR__ . '/student_get.php';
require_once __DIR__ . '/student_post.php';
require_once __DIR__ . '/../../inc/Response.php';

function useStudentRoutes(string $method, string $endpoint, array|null $body): Response
{
    switch ($method) {
        case 'GET':
            return useStudentGetRoutes($endpoint, $body);
    
        case 'POST':
            return useStudentPostRoutes($endpoint, $body);
    
        case 'PUT':
            # code...
            break;
    
        case 'DELETE':
            # code...
            break;
        
        default:
            return new Response(400, false, "Method isn't supported.");
    }
}