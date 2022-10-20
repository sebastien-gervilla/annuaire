<?php

require_once __DIR__ . '/../utils/utils.php';
require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../models/EntryYear.php";
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/EntryYearManager.php";

class EntryYearController {

    #region GET

    public static function getAll(): Response {
        try {
            $entryYears = EntryYearManager::getAllEntryYears();
            return new Response(200, true, "Années d'entrées récupérés avec succès", $entryYears);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }

    public static function getById(int $id): Response {
        try {
            $entryYear = EntryYearManager::getStudentEntryYears($id);
            return new Response(200, true, "Années d'entrée récupérée avec succès", $entryYear);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }
    
    #endregion

    #region POST

    public static function createEntryYears(array $entryYears, int $studentId): Response {
        try {
            if (count($entryYears) == 0) 
                return new Response(400, false, "Aucune année d'entrée sélectionnée.");

            $students = StudentManager::getAllStudents();
            $studentsId = filterArrayList($students, '_id');
            if (!in_array($studentId, $studentsId))
                return new Response(400, false, "Elève inexistant.");

            $schoolYears = SchoolYearManager::getAllSchoolYears();
            $schoolYearsId = filterArrayList($schoolYears, '_id');
            foreach ($entryYears as $schoolYearId) {
                if (!in_array($schoolYearId, $schoolYearsId))
                    return new Response(400, false, "Année(s) d'entrée(s) inexistante(s).", array(
                        "data" => $entryYears
                    ));
            }

            foreach ($entryYears as $schoolYearId) {
                $NewEntryYear = new EntryYear($studentId, $schoolYearId);
                $error = findModelValidationsError($NewEntryYear->getValidations());
                if ($error) return new Response(400, false, $error);

                EntryYearManager::createEntryYearRequest($NewEntryYear);
            }

            return new Response(200, true, "Année(s) d'entrée(s) créée avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region PUT

    public static function modifyStudentEntryYears(array $newEntryYears, int $studentId): Response {
        try {
            if (count($newEntryYears) == 0) 
                return new Response(400, false, "Aucune année d'entrée sélectionnée.");

            $students = StudentManager::getAllStudents();
            $studentsId = filterArrayList($students, '_id');
            if (!in_array($studentId, $studentsId))
                return new Response(400, false, "Elève inexistant.");

            $schoolYears = SchoolYearManager::getAllSchoolYears();
            $schoolYearsId = filterArrayList($schoolYears, '_id');
            foreach ($newEntryYears as $schoolYearId) {
                if (!in_array($schoolYearId, $schoolYearsId))
                    return new Response(400, false, "Année(s) de formation inexistante(s).", array(
                        "data" => $newEntryYears
                    ));
            }

            $oldEntryYears = EntryYearManager::getStudentEntryYears($studentId);
            foreach ($oldEntryYears as $oldEntryYear) {
                $oldEntryYear = new EntryYear(
                    $oldEntryYear['student_id'], 
                    $oldEntryYear['school_year_id']
                );
                EntryYearManager::deleteEntryYearRequest($oldEntryYear);
            }

            foreach ($newEntryYears as $entryYearId) {
                $NewEntryYear = new EntryYear($studentId, $entryYearId);
                $error = findModelValidationsError($NewEntryYear->getValidations());
                if ($error) return new Response(400, false, $error);

                EntryYearManager::createEntryYearRequest($NewEntryYear);
            }

            return new Response(200, true, "Années d'entrées modifiées avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

}