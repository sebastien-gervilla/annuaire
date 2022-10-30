<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class SchoolYearManager {

    #region GET

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'school_year'";
        $columns = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        $columnNames = [];
        foreach ($columns as $column) {
            if ($column['COLUMN_NAME'] !== '_id') {
                array_push($columnNames, $column['COLUMN_NAME']);
            }
        }
        return $columnNames;
    }

    public static function getLastCreatedSchoolYearId(){
        $dbh = DatabaseHandler::connect();
        $request = "SELECT MAX(_id) as lastId FROM `school_year`;";
        $idArray = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        return $idArray[0]["lastId"];
    }

    public static function getAllSchoolYears() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `school_year` ORDER BY `_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSchoolYear(int $schoolYearId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `school_year` WHERE `_id` = $schoolYearId;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    #endregion

    #region POST

    public static function createSchoolYearRequest(SchoolYear $SchoolYear) {
        $dbh = DatabaseHandler::connect();
        $request = "INSERT INTO `school_year` (title) VALUES (:title)";
        $sth = $dbh->prepare($request);
        $sth->execute($SchoolYear->getModel());
    }

    #endregion
    
    #region PUT

    public static function modifySchoolYearRequest(SchoolYear $SchoolYear) {
        $dbh = DatabaseHandler::connect();
        $request = "UPDATE `school_year` 
        SET title = :title WHERE _id = :_id";
        $sth = $dbh->prepare($request);
        $sth->execute($SchoolYear->getModel());
    }

    #endregion

    #region DELETE

    public static function deleteSchoolYearRequest(int $schoolYearId) {
        $dbh = DatabaseHandler::connect();
        $request = "DELETE FROM `school_year` WHERE _id = :_id";
        $sth = $dbh->prepare($request);
        $sth->bindParam(':_id', $schoolYearId);
        $sth->execute();
    }

    #endregion

}