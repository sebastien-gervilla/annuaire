<?php

// You shouldn't modify this script unless you know what you're doing.

require_once __DIR__ . '/../api/controllers/AuthController.php';

echo "---------------------\n";
echo "Fill this user form :\n\n";

$email = readline("Email : ");
$pwd = readline("Password : ");

echo "\nCreating User...\n\n";

$res = AuthController::createUser(array(
    'email' => $email,
    'password' => $pwd
));

echo $res->getMessage() . "\n";
if ($res->getStatus() !== 200) {
    $body = $res->getBody();
    if (array_key_exists('error', $body))
        echo $body['error'];
}

echo "---------------------\n";