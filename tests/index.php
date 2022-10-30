<?php

require_once './utils/TestHandler.php';
require_once './inc/admin-test.php';

// User table should always have atleast one user

TestHandler::run("User table should have atleast one admin.", function (callable $expect) {
    return $expect(hasAdmin())->toBe(true);
});