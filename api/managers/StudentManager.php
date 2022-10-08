<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class StudentManager {

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = 'annuaire_nws' AND TABLE_NAME = 'students'";
        $columns = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        $columnNames = [];
        foreach ($columns as $column) {
            if ($column['COLUMN_NAME'] !== '_id') {
                array_push($columnNames, $column['COLUMN_NAME']);
            }
        }
        return $columnNames;
    }

    #region GET

    public static function getAllStudents() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `students` ORDER BY `_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getStudent(int $studentId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `students` WHERE `_id` = $studentId;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    #endregion

    #region POST

    public static function createStudentRequest(array $student) {
        $dbh = DatabaseHandler::connect();
        $fname = $student['fname'];
        $lname = $student['lname'];
        $age = $student['age'];
        $gender = $student['gender'];
        $email = $student['email'];
        $phone = $student['phone'];
        $degree = $student['degree'];
        $request = "INSERT INTO students (fname, lname, age, gender, email, phone, degree) 
        VALUES ('$fname', '$lname', '$age', '$gender', '$email', '$phone', '$degree')";
        $dbh->exec($request);
    }

    #endregion
    
}