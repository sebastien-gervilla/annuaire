<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class PathwayManager {

    #region GET

    public static function getAllPathways() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `pathway` ORDER BY `student_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getStudentPathways(int $studentId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `pathway` WHERE `student_id` = $studentId;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    #endregion

    #region POST

    public static function createPathwayRequest(int $studentId, int $specializationId) {
        $dbh = DatabaseHandler::connect();
        $request = "INSERT INTO pathway (student_id, specialization_id) 
        VALUES ('$studentId', '$specializationId')";
        $dbh->exec($request);
    }

    #endregion

    #region DELETE

    public static function deletePathwayRequest(int $studentId, int $specializationId) {
        $dbh = DatabaseHandler::connect();
        $request = "DELETE FROM `pathway` 
        WHERE `student_id` = $studentId AND `specialization_id` = $specializationId;";
        $dbh->exec($request);
    }

    #endregion

}