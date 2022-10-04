<?php

class Student {
    private $dbh;
    private $tableName;

    private $id;
    private $fname;
    private $lname;
    private $age;
    private $createdAt;

    public function __construct($db) {
        $this->dbh = $db;
    }
}