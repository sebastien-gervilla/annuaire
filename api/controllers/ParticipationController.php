<?php

require_once __DIR__ . '/../utils/utils.php';
require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../models/Participation.php";
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/ParticipationManager.php";

class ParticipationController {

    #region GET

    public static function getAll(): Response {
        try {
            $participations = ParticipationManager::getAllParticipations();
            return new Response(200, true, "Participations récupérés avec succès", $participations);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }

    public static function getById(int $id): Response {
        try {
            $participation = ParticipationManager::getParticipation($id);
            return new Response(200, true, "Participation récupéré avec succès", $participation);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }
    
    #endregion

    #region POST

    public static function createParticipations(array $participations, int $studentId): Response {
        try {
            if (count($participations) == 0) 
                return new Response(400, false, "Aucun Evènement sélectionné.");

            $students = StudentManager::getAllStudents();
            $studentsId = filterArrayList($students, '_id');
            if (!in_array($studentId, $studentsId))
                return new Response(400, false, "Elève inexistant.");

            $events = EventManager::getAllEvents();
            $eventsId = filterArrayList($events, '_id');
            foreach ($participations as $eventId) {
                if (!in_array($eventId, $eventsId))
                    return new Response(400, false, "Evènement(s) inexistant.", array(
                        "data" => $participations
                    ));
            }

            foreach ($participations as $eventId) {
                $NewParticipation = new Participation($studentId, $eventId);
                $error = findModelValidationsError($NewParticipation->getValidations());
                if ($error) return new Response(400, false, $error);

                ParticipationManager::createParticipationRequest($studentId, $eventId);
            }

            return new Response(200, true, "Participation(s) créé avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region PUT

    public static function modifyParticipation(int $participationId, array $newParticipation) {
        // Remove all participations from student (by id);
        // Add all participations from student (by id);
    }

    #endregion

    #region DELETE

    public static function deleteParticipation(int $participationId){
        try {
            $participation = ParticipationManager::getparticipation($participationId);
            if (!$participation) return new Response(400, false, "Participation inexistant.");

            ParticipationManager::deleteparticipationRequest($participationId);
            return new Response(200, true, "Participation supprimé avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

}