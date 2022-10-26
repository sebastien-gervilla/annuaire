<?php

require_once './utils/TestHandler.php';
require_once './inc/user-test.php';

// User table should always have atleast one user

TestHandler::run("User table should have atleast one user.", function (callable $expect) {
    return $expect(isUserTableEmpty())->toBe(false);
});