<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/StudentController.php';

function useStudentPutRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'student':
            $student = $body;
            $id = $body['_id'];
            return Router::put(function () use($id, $student) { 
                return StudentController::modifyStudent($id, $student); 
            });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}