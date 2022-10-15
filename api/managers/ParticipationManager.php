<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class ParticipationManager {

    #region GET

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = 'annuaire_nws' AND TABLE_NAME = 'participation'";
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
        $request = "SELECT * FROM `participation` ORDER BY `_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getParticipation(int $participationId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `participation` WHERE `_id` = $participationId;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    #endregion

    #region POST

    public static function createParticipationRequest(int $studentId, int $eventId) {
        $dbh = DatabaseHandler::connect();
        $request = "INSERT INTO participation (student_id, event_id) VALUES ('$studentId', '$eventId')";
        $dbh->exec($request);
    }

    #endregion
    
    #region PUT

    public static function modifyParticipationRequest(int $participationId, array $newParticipation) {
        $dbh = DatabaseHandler::connect();
        $title = $newParticipation['title'];
        $type = $newParticipation['type'];
        $description = $newParticipation['description'];
        $request = "UPDATE `participation` 
        SET `title` = '$title', `type` = '$type', `description` = '$description' WHERE `_id` = '$participationId';";
        $dbh->exec($request);
    }

    #endregion

    #region DELETE

    public static function deleteParticipationRequest(int $participationId) {
        $dbh = DatabaseHandler::connect();
        $request = "DELETE FROM `participation` WHERE `_id` = $participationId;";
        $dbh->exec($request);
    }

    #endregion

}