<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class EventManager {

    #region GET

    public static function getColumnsNames() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'event'";
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

    public static function getSortedEvents(string $order) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `event` ORDER BY `_id` " . $order;
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEvent(int $eventId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `event` WHERE `_id` = $eventId;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    #endregion

    #region POST

    public static function createEventRequest(Event $Event) {
        $dbh = DatabaseHandler::connect();
        $request = "INSERT INTO `event` (title, `type`, `date`, `description`) 
        VALUES (:title, :type, :date, :description)";
        $sth = $dbh->prepare($request);
        $sth->execute($Event->getModel());
    }

    #endregion
    
    #region PUT

    public static function modifyEventRequest(Event $Event) {
        $dbh = DatabaseHandler::connect();
        $request = "UPDATE `event` 
        SET title = :title, `type` = :type, `date` = :date, `description` = :description WHERE _id = :_id";
        $sth = $dbh->prepare($request);
        $sth->execute($Event->getModel());
    }

    #endregion

    #region DELETE

    public static function deleteEventRequest(int $eventId) {
        $dbh = DatabaseHandler::connect();
        $request = "DELETE FROM `event` WHERE _id = :_id";
        $sth = $dbh->prepare($request);
        $sth->bindParam(':_id', $eventId);
        $sth->execute();
    }

    #endregion

}