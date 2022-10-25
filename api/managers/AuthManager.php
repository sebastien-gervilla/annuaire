<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';
require_once __DIR__ . '/../utils/utils.php';

class AuthManager {

    #region GET

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = 'annuaire_nws' AND TABLE_NAME = 'user'";
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
        $request = "SELECT * FROM user ORDER BY `_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getUserByEmail(string $email) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `user`
        WHERE user.email = :email";
        $sth = $dbh->prepare($request);
        $sth->execute(['email' => $email]);
        $user = $sth->fetchAll(PDO::FETCH_ASSOC);
        return count($user) > 0 ? $user[0] : null;
    }

    #endregion

    #region POST

    public static function createUserRequest(User $User) {
        $dbh = DatabaseHandler::connect();
        $request = "INSERT INTO user (email, password) 
        VALUES (:email, :password)";
        $sth = $dbh->prepare($request);
        $sth->execute($User->getModel());
    }

    #endregion

}