<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class EventManager {

    #region GET

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = 'annuaire_nws' AND TABLE_NAME = 'event'";
        $columns = $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
        $columnNames = [];
        foreach ($columns as $column) {
            if ($column['COLUMN_NAME'] !== '_id') {
                array_push($columnNames, $column['COLUMN_NAME']);
            }
        }
        return $columnNames;
    }

    public static function getAllEvents() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `event` ORDER BY `_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEvent(int $eventId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `event` WHERE `_id` = $eventId;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    #endregion

    #region POST

    public static function createEventRequest(array $event) {
        $dbh = DatabaseHandler::connect();
        $title = $event['title'];
        $type = $event['type'];
        $description = $event['description'];
        $request = "INSERT INTO event (title, type, description) 
        VALUES ('$title', '$type', '$description')";
        $dbh->exec($request);
    }

    #endregion
    
    #region PUT

    public static function modifyEventRequest(int $eventId, array $newEvent) {
        $dbh = DatabaseHandler::connect();
        $title = $newEvent['title'];
        $type = $newEvent['type'];
        $description = $newEvent['description'];
        $request = "UPDATE `event` 
        SET `title` = '$title', `type` = '$type', `description` = '$description' WHERE `_id` = '$eventId';";
        $dbh->exec($request);
    }

    #endregion

    #region DELETE

    public static function deleteEventRequest(int $eventId) {
        $dbh = DatabaseHandler::connect();
        $request = "DELETE FROM `event` WHERE `_id` = $eventId;";
        $dbh->exec($request);
    }

    #endregion

}