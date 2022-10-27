<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';
require_once __DIR__ . '/../utils/utils.php';

class UserManager {

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

    public static function getAllUsers() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `user`
        ORDER BY user._id;";
        $users = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public static function getUser(int $userId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `user`
        WHERE user._id = $userId;";
        $user = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        return count($user) > 0 ? $user[0] : null;
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
        $request = "INSERT INTO user (fname, lname, email, password) 
        VALUES (:fname, :lname, :email, :password)";
        $sth = $dbh->prepare($request);
        $sth->execute($User->getModel());
    }

    public static function createAdminRequest(User $User) {
        $dbh = DatabaseHandler::connect();
        $request = "INSERT INTO user (fname, lname, email, password, is_admin) 
        VALUES (:fname, :lname, :email, :password, 1)";
        $sth = $dbh->prepare($request);
        $sth->execute($User->getModel());
    }

    #endregion
    
    #region PUT

    public static function modifyUserRequest(User $User, int $userId) {
        $dbh = DatabaseHandler::connect();
        $request = "UPDATE user 
        SET fname = :fname, lname = :lname, 
        email = :email, password = :password
        WHERE _id = $userId";
        $sth = $dbh->prepare($request);
        $sth->execute($User->getModel());
    }

    #endregion

    #region DELETE

    public static function deleteUserRequest(int $userId) {
        $dbh = DatabaseHandler::connect();
        $request = "DELETE FROM user WHERE _id = :_id";
        $sth = $dbh->prepare($request);
        $sth->bindParam(':_id', $userId);
        $sth->execute();
    }

    #endregion

}