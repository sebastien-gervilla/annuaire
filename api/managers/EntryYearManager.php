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

    public static function createEntryYearRequest(EntryYear $EntryYear) {
        $dbh = DatabaseHandler::connect();
        $request = "INSERT INTO entry_year (student_id, school_year_id) 
        VALUES (:studentId, :schoolYearId)";
        $sth = $dbh->prepare($request);
        $sth->execute($EntryYear->getModel());
    }

    #endregion

    #region DELETE

    public static function deleteEntryYearRequest(EntryYear $EntryYear) {
        $dbh = DatabaseHandler::connect();
        $request = "DELETE FROM entry_year 
        WHERE student_id = :studentId AND school_year_id = :schoolYearId";
        $sth = $dbh->prepare($request);
        $sth->execute($EntryYear->getModel());
    }

    #endregion

}