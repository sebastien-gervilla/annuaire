<?php

require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../models/SchoolYear.php";
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/SchoolYearManager.php";

class SchoolYearController {

    #region GET

    public static function getAll(): Response {
        try {
            $schoolYears = SchoolYearManager::getAllSchoolYears();
            return new Response(200, true, "Années de formation récupérées avec succès", $schoolYears);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }

    public static function getById(int $id): Response {
        try {
            $schoolYear = SchoolYearManager::getSchoolYear($id);
            return new Response(200, true, "Année de formation récupérée avec succès", $schoolYear);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }
    
    #endregion

    #region POST

    public static function createSchoolYear(array $schoolYear): Response {
        try {
            $columns = SchoolYearManager::getColumnsNames();
            if (!formMatchesTable($schoolYear, $columns)) {
                return new Response(400, false, "Le formulaire ne correspond pas à la table.", $schoolYear);
            }

            if (!isFormFilled($schoolYear)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $schoolYear = trimArray($schoolYear);
            $NewSchoolYear = new SchoolYear($schoolYear);
            $error = findModelValidationsError($NewSchoolYear->getValidations());
            if ($error) return new Response(400, false, $error);

            SchoolYearManager::createSchoolYearRequest($NewSchoolYear);
            return new Response(200, true, "Année de formation créée avec succès.", $schoolYear);
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region PUT

    public static function modifySchoolYear(int $schoolYearId, array $newSchoolYear) {
        try {
            $SchoolYear = SchoolYearManager::getSchoolYear($schoolYearId);
            if (!$SchoolYear) return new Response(400, false, "Année de formation inexistante.");
            
            $columns = SchoolYearManager::getColumnsNames();
            if (!formMatchesTable($newSchoolYear, $columns)) {
                return new Response(400, false, "Le formulaire ne correspond pas à la table.");
            }

            if (!isFormFilled($newSchoolYear)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $newSchoolYear = trimArray($newSchoolYear);
            $NewSchoolYear = new SchoolYear($newSchoolYear);
            $error = findModelValidationsError($NewSchoolYear->getValidations());
            if ($error) return new Response(400, false, $error);

            SchoolYearManager::modifySchoolYearRequest($NewSchoolYear);
            return new Response(200, true, "Année de formation modifiée avec succès.", $newSchoolYear);
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region DELETE

    public static function deleteSchoolYear(int $schoolYearId){
        try {
            $SchoolYear = SchoolYearManager::getSchoolYear($schoolYearId);
            if (!$SchoolYear) return new Response(400, false, "Année de formation inexistante.");

            SchoolYearManager::deleteSchoolYearRequest($schoolYearId);
            return new Response(200, true, "Année de formation supprimée avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

}