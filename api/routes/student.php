<?php

require_once '../models/Student.php';
require_once './Router.php';
require_once '../controllers/StudentController.php';

// $reqMethod = $_SERVER['REQUEST_METHOD'];

function studentRoutes($endpoint, $method)
{
    switch ($method) {
        case 'GET':
            return Router::get($endpoint, "StudentController::" . $endpoint);
    
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

$response = json_encode(studentRoutes('students', 'GET'));
var_dump($_SERVER['REQUEST_URI']);
// echo $response;