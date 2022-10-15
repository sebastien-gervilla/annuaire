<?php

require_once __DIR__ . '/../utils/utils.php';
require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/SchoolYearManager.php";

class SchoolYearController {

    #region GET

    public static function getAll(): Response {
        try {
            $schoolYears = SchoolYearManager::getAllSchoolYears();
            return new Response(200, true, "Années de formation récupérés avec succès", $schoolYears);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }

    public static function getById(int $id): Response {
        try {
            $schoolYear = SchoolYearManager::getSchoolYear($id);
            return new Response(200, true, "Année de formation récupéré avec succès", $schoolYear);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }
    
    #endregion

}