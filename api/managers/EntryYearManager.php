<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class EntryYearManager {

    #region GET

    public static function getAllEntryYears() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `entry_year` ORDER BY `student_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getStudentEntryYears(int $studentId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `entry_year` WHERE `student_id` = $studentId;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    #endregion

    #region POST

    public static function createEntryYearRequest(int $studentId, int $schoolYearId) {
        $dbh = DatabaseHandler::connect();
        $request = "INSERT INTO entry_year (student_id, school_year_id) VALUES ('$studentId', '$schoolYearId')";
        $dbh->exec($request);
    }

    #endregion

    #region DELETE

    public static function deleteEntryYearRequest(int $studentId, int $schoolYearId) {
        $dbh = DatabaseHandler::connect();
        $request = "DELETE FROM `entry_year` 
        WHERE `student_id` = $studentId AND `school_year_id` = $schoolYearId;";
        $dbh->exec($request);
    }

    #endregion

}