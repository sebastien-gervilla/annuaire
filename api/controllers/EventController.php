<?php

require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../models/Event.php";
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/EventManager.php";

class EventController {

    #region GET

    public static function getAll(): Response {
        try {
            $events = EventManager::getAllEvents();
            return new Response(200, true, "Evènements récupérés avec succès", $events);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }

    public static function getById(int $id): Response {
        try {
            $event = EventManager::getEvent($id);
            return new Response(200, true, "Evènement récupéré avec succès", $event);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }
    
    #endregion

    #region POST

    public static function createEvent(array $event): Response {
        try {
            $columns = EventManager::getColumnsNames();
            if (!formMatchesTable($event, $columns)) {
                return new Response(400, false, "Le formulaire ne correspond pas à la table.");
            }

            $exceptions = ["description"];
            if (!isFormFilled($event, $exceptions)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $event = trimArray($event);
            $NewEvent = new Event($event);
            $error = findModelValidationsError($NewEvent->getValidations());
            if ($error) return new Response(400, false, $error);

            EventManager::createEventRequest($event);
            return new Response(200, true, "Evènement créé avec succès.", $event);
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region PUT

    public static function modifyEvent(int $eventId, array $newEvent) {
        try {
            $event = EventManager::getevent($eventId);
            if (!$event) return new Response(400, false, "Evènement inexistant.");
            
            $columns = EventManager::getColumnsNames();
            if (!formMatchesTable($newEvent, $columns)) {
                return new Response(400, false, "Le formulaire ne correspond pas à la table.");
            }

            $exceptions = ["description"];
            if (!isFormFilled($newEvent, $exceptions)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $newEvent = trimArray($newEvent);
            $NewEvent = new Event($newEvent);
            $error = findModelValidationsError($NewEvent->getValidations());
            if ($error) return new Response(400, false, $error);

            EventManager::modifyEventRequest($eventId, $newEvent);
            return new Response(200, true, "Evènement modifié avec succès.", $newEvent);
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region DELETE

    public static function deleteEvent(int $eventId){
        try {
            $event = EventManager::getevent($eventId);
            if (!$event) return new Response(400, false, "Evènement inexistant.");

            EventManager::deleteEventRequest($eventId);
            return new Response(200, true, "Evènement supprimé avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

}