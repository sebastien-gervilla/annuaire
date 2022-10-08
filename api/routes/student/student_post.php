<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/StudentController.php';

function useStudentPostRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'student':
            $student = $body;
            return Router::get(function () use($student) { return StudentController::createStudent($student); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}