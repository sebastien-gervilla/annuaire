<?php

require_once __DIR__ . '/../utils/utils.php';
require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../models/Pathway.php";
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/PathwayManager.php";

class PathwayController {

    #region GET

    public static function getAll(): Response {
        try {
            $pathways = PathwayManager::getAllPathways();
            return new Response(200, true, "Filières récupérées avec succès", $pathways);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }

    public static function getById(int $id): Response {
        try {
            $pathway = PathwayManager::getStudentPathways($id);
            return new Response(200, true, "Filière récupérée avec succès", $pathway);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }
    
    #endregion

    #region POST

    public static function createPathways(array $pathways, int $studentId): Response {
        try {
            if (count($pathways) == 0) 
                return new Response(400, false, "Aucune filière sélectionnée.");

            $students = StudentManager::getAllStudents();
            $studentsId = filterArrayList($students, '_id');
            if (!in_array($studentId, $studentsId))
                return new Response(400, false, "Elève inexistant.");

            $specializations = SpecializationManager::getAllSpecializations();
            $specializationsId = filterArrayList($specializations, '_id');
            foreach ($pathways as $specializationId) {
                if (!in_array($specializationId, $specializationsId))
                    return new Response(400, false, "Spécialisation(s) inexistante(s).", array(
                        "data" => $pathways
                    ));
            }

            foreach ($pathways as $specializationId) {
                $NewPathway = new Pathway($studentId, $specializationId);
                $error = findModelValidationsError($NewPathway->getValidations());
                if ($error) return new Response(400, false, $error);

                PathwayManager::createPathwayRequest($NewPathway);
            }

            return new Response(200, true, "Filière(s) créée avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region PUT

    public static function modifyStudentPathways(array $newPathways, int $studentId): Response {
        try {
            if (count($newPathways) == 0) 
                return new Response(400, false, "Aucune filière sélectionnée.");

            $students = StudentManager::getAllStudents();
            $studentsId = filterArrayList($students, '_id');
            if (!in_array($studentId, $studentsId))
                return new Response(400, false, "Elève inexistant.");

            $specializations = SpecializationManager::getAllSpecializations();
            $specializationsId = filterArrayList($specializations, '_id');
            foreach ($newPathways as $specializationId) {
                if (!in_array($specializationId, $specializationsId))
                    return new Response(400, false, "Spécialisation(s) inexistante(s).", array(
                        "data" => $newPathways
                    ));
            }

            $oldPathways = PathwayManager::getStudentPathways($studentId);
            foreach ($oldPathways as $oldPathway) {
                $oldPathway = new Pathway(
                    $oldPathway['student_id'], 
                    $oldPathway['specialization_id']
                );
                PathwayManager::deletePathwayRequest($oldPathway);
            }

            foreach ($newPathways as $specializationId) {
                $NewPathway = new Pathway($studentId, $specializationId);
                $error = findModelValidationsError($NewPathway->getValidations());
                if ($error) return new Response(400, false, $error);

                PathwayManager::createPathwayRequest($NewPathway);
            }

            return new Response(200, true, "Filière(s) créée avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

}