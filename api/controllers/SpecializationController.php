<?php

require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../models/Specialization.php";
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/SpecializationManager.php";

class SpecializationController {

    #region GET

    public static function getAll(): Response {
        try {
            $specializations = SpecializationManager::getAllSpecializations();
            return new Response(200, true, "Spécialisations récupérées avec succès", $specializations);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }

    public static function getById(int $id): Response {
        try {
            $specialization = SpecializationManager::getSpecialization($id);
            return new Response(200, true, "Spécialisations récupérées avec succès", $specialization);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }
    
    #endregion

    #region POST

    public static function createSpecialization(array $specialization): Response {
        try {
            $columns = SpecializationManager::getColumnsNames();
            if (!formMatchesTable($specialization, $columns)) {
                return new Response(400, false, "Le formulaire ne correspond pas à la table.", $specialization);
            }

            if (!isFormFilled($specialization)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $specialization = trimArray($specialization);
            $NewSpecialization = new Specialization($specialization);
            $error = findModelValidationsError($NewSpecialization->getValidations());
            if ($error) return new Response(400, false, $error);

            SpecializationManager::createSpecializationRequest($NewSpecialization);
            return new Response(200, true, "Specialisation créée avec succès.", $specialization);
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region PUT

    public static function modifySpecialization(int $specializationId, array $newSpecialization) {
        try {
            $Specialization = SpecializationManager::getSpecialization($specializationId);
            if (!$Specialization) return new Response(400, false, "Specialisation inexistante.");
            
            $columns = SpecializationManager::getColumnsNames();
            if (!formMatchesTable($newSpecialization, $columns)) {
                return new Response(400, false, "Le formulaire ne correspond pas à la table.");
            }

            if (!isFormFilled($newSpecialization)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $newSpecialization = trimArray($newSpecialization);
            $NewSpecialization = new Specialization($newSpecialization);
            $error = findModelValidationsError($NewSpecialization->getValidations());
            if ($error) return new Response(400, false, $error);

            SpecializationManager::modifySpecializationRequest($NewSpecialization);
            return new Response(200, true, "Specialisation modifiée avec succès.", $newSpecialization);
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region DELETE

    public static function deleteSpecialization(int $specializationId){
        try {
            $Specialization = SpecializationManager::getSpecialization($specializationId);
            if (!$Specialization) return new Response(400, false, "Specialisation inexistante.");

            SpecializationManager::deleteSpecializationRequest($specializationId);
            return new Response(200, true, "Specialisation supprimée avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

}