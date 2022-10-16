<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class EntryYearManager {

    #region GET

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = 'annuaire_nws' AND TABLE_NAME = 'entry_year'";
        $columns = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        $columnNames = [];
        foreach ($columns as $column) {
            if ($column['COLUMN_NAME'] !== '_id') {
                array_push($columnNames, $column['COLUMN_NAME']);
            }
        }
        return $columnNames;
    }

    public static function getAllEntryYears() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `entry_year` ORDER BY `_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEntryYear(int $entryYearId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `entry_year` WHERE `_id` = $entryYearId;";
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

}