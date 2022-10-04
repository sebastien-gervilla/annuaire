<?php

require_once '../Router.php';
require_once '../../controllers/StudentController.php';

function studentGet($endpoint)
{
    switch ($endpoint) {
        case 'students':
            Router::get($endpoint, 'StudentController::');
            break;
        
        default:
            # code...
            break;
    }
}