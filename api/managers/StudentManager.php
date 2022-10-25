<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';
require_once __DIR__ . '/../utils/utils.php';

class StudentManager {

    #region GET

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'student'";
        $columns = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        $columnNames = [];
        foreach ($columns as $column) {
            if ($column['COLUMN_NAME'] !== '_id') {
                array_push($columnNames, $column['COLUMN_NAME']);
            }
        }
        return $columnNames;
    }

    public static function getLastCreatedStudentId(){
        $dbh = DatabaseHandler::connect();
        $request = "SELECT MAX(_id) as lastId FROM `student`;";
        $idArray = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        return $idArray[0]["lastId"];
    }

    public static function getAllStudents() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT student.*, pathway.specialization_id as pathways, 
        entry_year.school_year_id as entry_years,
        participation.event_id as participations FROM `student`
        LEFT JOIN `pathway` ON pathway.student_id = student._id
        LEFT JOIN `entry_year` ON entry_year.student_id = student._id
        LEFT JOIN `participation` ON participation.student_id = student._id
        ORDER BY student._id;";
        $data = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        return groupRowsByKeys($data, ['pathways', 'entry_years', 'participations']);
    }

    public static function getStudent(int $studentId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT student.*, pathway.specialization_id as pathways, 
        entry_year.school_year_id as entry_years,
        participation.event_id as participations FROM `student`
        LEFT JOIN `pathway` ON pathway.student_id = student._id
        LEFT JOIN `entry_year` ON entry_year.student_id = student._id
        LEFT JOIN `participation` ON participation.student_id = student._id
        WHERE student._id = $studentId;";
        $data = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        $student = groupRowsByKeys($data, ['pathways', 'entry_years', 'participations']);
        return count($student) > 0 ? $student[0] : null;
    }

    public static function getStudentByEmail(string $email) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `student`
        WHERE student.email = :email";
        $sth = $dbh->prepare($request);
        $sth->execute(['email' => $email]);
        $student = $sth->fetchAll(PDO::FETCH_ASSOC);
        return count($student) > 0 ? $student[0] : null;
    }

    #endregion

    #region POST

    public static function createStudentRequest(Student $Student) {
        $dbh = DatabaseHandler::connect();
        $request = "INSERT INTO student (fname, lname, age, gender, email, phone, degree) 
        VALUES (:fname, :lname, :age, :gender, :email, :phone, :degree)";
        $sth = $dbh->prepare($request);
        $sth->execute($Student->getModel());
    }

    #endregion
    
    #region PUT

    public static function modifyStudentRequest(Student $Student) {
        $dbh = DatabaseHandler::connect();
        $request = "UPDATE student 
        SET fname = :fname, lname = :lname, age = :age, gender = :gender, email = :email, 
        phone = :phone, degree = :degree WHERE _id = :_id";
        $sth = $dbh->prepare($request);
        $sth->execute($Student->getModel());
    }

    #endregion

    #region DELETE

    public static function deleteStudentRequest(int $studentId) {
        $dbh = DatabaseHandler::connect();
        $request = "DELETE FROM student WHERE _id = :_id";
        $sth = $dbh->prepare($request);
        $sth->bindParam(':_id', $studentId);
        $sth->execute();
    }

    #endregion

}