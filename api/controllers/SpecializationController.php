<?php

require_once __DIR__ . '/../utils/utils.php';
require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/SpecializationManager.php";

class SpecializationController {

    #region GET

    public static function getAll(): Response {
        try {
            $specializations = SpecializationManager::getAllspecializations();
            return new Response(200, true, "Spécialisations récupérés avec succès", $specializations);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }

    public static function getById(int $id): Response {
        try {
            $specialization = SpecializationManager::getspecialization($id);
            return new Response(200, true, "Spécialisation récupéré avec succès", $specialization);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }
    
    #endregion

}