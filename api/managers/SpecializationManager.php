<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class SpecializationManager {

    #region GET

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'specialization'";
        $columns = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        $columnNames = [];
        foreach ($columns as $column) {
            if ($column['COLUMN_NAME'] !== '_id') {
                array_push($columnNames, $column['COLUMN_NAME']);
            }
        }
        return $columnNames;
    }

    public static function getLastCreatedSpecializationId(){
        $dbh = DatabaseHandler::connect();
        $request = "SELECT MAX(_id) as lastId FROM `specialization`;";
        $idArray = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        return $idArray[0]["lastId"];
    }

    public static function getAllSpecializations() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `specialization` ORDER BY `_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSpecialization(int $specializationId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `specialization` WHERE `_id` = $specializationId;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    #endregion

}