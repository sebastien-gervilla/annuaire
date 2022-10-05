<?php

require_once __DIR__ . '/student_get.php';

function useStudentRoutes(string $method, string $endpoint, array|null $body)
{
    switch ($method) {
        case 'GET':
            return useStudentGetRoutes($endpoint, $body);
    
        case 'POST':
            # code...
            break;
    
        case 'PUT':
            # code...
            break;
    
        case 'DELETE':
            # code...
            break;
        
        default:
            return array(
                "success" => false,
                "data" => null
            );
    }
}