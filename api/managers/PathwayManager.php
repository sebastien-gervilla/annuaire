<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class PathwayManager {

    #region GET

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = 'annuaire_nws' AND TABLE_NAME = 'pathway'";
        $columns = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        $columnNames = [];
        foreach ($columns as $column) {
            if ($column['COLUMN_NAME'] !== '_id') {
                array_push($columnNames, $column['COLUMN_NAME']);
            }
        }
        return $columnNames;
    }

    public static function getAllPathways() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `pathway` ORDER BY `_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPathway(int $pathwayId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `pathway` WHERE `_id` = $pathwayId;";
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

}