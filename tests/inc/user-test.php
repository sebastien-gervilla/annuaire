<?php

require_once __DIR__ . '/../utils/CurlHandler.php';

function isUserTableEmpty(): bool {
    $url = "http://localhost:80/annuaire/api/auth/users";
    $response = CurlHandler::get($url);
    if (!$response || !is_array($response)) return false;
    if (!array_key_exists('body', $response)) return false;
    if (!is_array($response['body'])) return false;
    return count($response['body']) < 1;
}
