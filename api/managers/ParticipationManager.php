<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class ParticipationManager {

    #region GET

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'participation'";
        $columns = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        $columnNames = [];
        foreach ($columns as $column) {
            if ($column['COLUMN_NAME'] !== '_id') {
                array_push($columnNames, $column['COLUMN_NAME']);
            }
        }
        return $columnNames;
    }

    public static function getAllParticipations() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `participation` ORDER BY `student_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getStudentParticipations(int $studentId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `participation` WHERE `student_id` = $studentId;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    #endregion

    #region POST

    public static function createParticipationRequest(Participation $Participation) {
        $dbh = DatabaseHandler::connect();
        $request = "INSERT INTO participation (student_id, event_id) 
        VALUES (:studentId, :eventId)";
        $sth = $dbh->prepare($request);
        $sth->execute($Participation->getModel());
    }

    #endregion

    #region DELETE

    public static function deleteParticipationRequest(Participation $Participation) {
        $dbh = DatabaseHandler::connect();
        $request = "DELETE FROM `participation` 
        WHERE `student_id` = :studentId AND `event_id` = :eventId";
        $sth = $dbh->prepare($request);
        $sth->execute($Participation->getModel());
    }

    #endregion
    
}