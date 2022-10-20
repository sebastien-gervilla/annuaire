<?php

require_once __DIR__ . '/../config/DatabaseHandler.php';

class PathwayManager {

    #region GET

    public static function getAllPathways() {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `pathway` ORDER BY `student_id`;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getStudentPathways(int $studentId) {
        $dbh = DatabaseHandler::connect();
        $request = "SELECT * FROM `pathway` WHERE `student_id` = $studentId;";
        return $dbh->query($request)->fetchAll(PDO::FETCH_ASSOC);
    }

    #endregion

    #region POST

    public static function createPathwayRequest(Pathway $Pathway) {
        $dbh = DatabaseHandler::connect();
        $request = "INSERT INTO pathway (student_id, specialization_id) 
        VALUES (:studentId, :specializationId)";
        $sth = $dbh->prepare($request);
        $sth->execute($Pathway->getModel());
    }

    #endregion

    #region DELETE

    public static function deletePathwayRequest(Pathway $Pathway) {
        $dbh = DatabaseHandler::connect();
        $request = "DELETE FROM pathway 
        WHERE student_id = :studentId AND specialization_id = :specializationId";
        $sth = $dbh->prepare($request);
        $sth->execute($Pathway->getModel());
    }

    #endregion

}