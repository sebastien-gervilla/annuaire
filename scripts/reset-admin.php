<?php

// You shouldn't modify this script unless you know what you're doing.

require_once __DIR__ . '/../api/controllers/UserController.php';

echo "---------------------\n";
echo "Fill this user form :\n\n";

$fname = readline("Prénom : ");
$lname = readline("Nom : ");
$email = readline("Email : ");
$pwd = readline("Password : ");

echo "\nCreating User...\n\n";

$res = UserController::resetAdmin(array(
    'fname' => $fname,
    'lname' => $lname,
    'email' => $email,
    'password' => $pwd
));

echo $res->getMessage() . "\n";
if ($res->getStatus() !== 200) {
    $body = $res->getBody();
    if ($body && array_key_exists('error', $body))
        echo $body['error'] + "\n";
}

echo "---------------------\n";