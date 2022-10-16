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
            $participation = ParticipationManager::getStudentParticipations($id);
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

    public static function modifyStudentParticipations(array $newParticipations, int $studentId): Response {
        try {
            $students = StudentManager::getAllStudents();
            $studentsId = filterArrayList($students, '_id');
            if (!in_array($studentId, $studentsId))
                return new Response(400, false, "Elève inexistant.");

            $events = EventManager::getAllEvents();
            $eventsId = filterArrayList($events, '_id');
            foreach ($newParticipations as $eventId) {
                if (!in_array($eventId, $eventsId))
                    return new Response(400, false, "Evènement(s) inexistante(s).", array(
                        "data" => $newParticipations
                    ));
            }

            $oldParticipations = ParticipationManager::getStudentParticipations($studentId);
            $oldParticipationsIds = filterArrayList($oldParticipations, 'event_id');
            foreach ($oldParticipationsIds as $eventId)
                ParticipationManager::deleteParticipationRequest($studentId, $eventId);

            foreach ($newParticipations as $eventId) {
                $NewParticipation = new Participation($studentId, $eventId);
                $error = findModelValidationsError($NewParticipation->getValidations());
                if ($error) return new Response(400, false, $error);

                ParticipationManager::createParticipationRequest($studentId, $eventId);
            }

            return new Response(200, true, "Evènement(s) créée avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

}