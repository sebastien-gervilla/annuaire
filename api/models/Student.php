<?php

class Student {
    private $dbh;
    private $tableName;

    // Model

    private int $id;

    private string $fname;

    private string $lname;

    private int $age;

    private string $createdAt;

    public function __construct($db) {
        $this->dbh = $db;
    }
}