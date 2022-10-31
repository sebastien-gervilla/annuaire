<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';
require_once __DIR__ . '/../utils/utils.php';

class AuthManager {

    #region GET

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'user'";
        $columns = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        $columnNames = [];
        foreach ($columns as $column) {
            if ($column['COLUMN_NAME'] !== '_id') {
                array_push($columnNames, $column['COLUMN_NAME']);
            }
        }
        return $columnNames;
    }

    public static function getAllUsersRequest() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT email, is_admin FROM user";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    #endregion

}