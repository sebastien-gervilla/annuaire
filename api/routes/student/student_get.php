<?php

require_once __DIR__ . '/../Router.php';
require_once __DIR__ . '/../../inc/Response.php';
require_once __DIR__ .'/../../controllers/StudentController.php';

function useStudentGetRoutes(string $endpoint, array|null $body): Response
{
    switch ($endpoint) {
        case 'students':
            return Router::get(function () { return StudentController::getAll(); });

        case 'student':
            $id = $body['_id'];
            return Router::get(function () use($id) { return StudentController::getById($id); });
        
        default:
            return new Response(400, false, "Couldn't find url endpoint.");
    }
}