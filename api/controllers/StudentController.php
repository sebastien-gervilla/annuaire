<?php

require_once __DIR__ . '/../utils/utils.php';
require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../models/Student.php";
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/StudentManager.php";
require_once __DIR__ . "/../controllers/PathwayController.php";
require_once __DIR__ . "/../controllers/EntryYearController.php";
require_once __DIR__ . "/../controllers/ParticipationController.php";

class StudentController {

    #region GET

    public static function getAll(): Response {
        try {
            $students = StudentManager::getAllStudents();
            return new Response(200, true, "Elèves récupérés avec succès", $students);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }

    public static function getById(int $id): Response {
        try {
            $student = StudentManager::getStudent($id);
            return new Response(200, true, "Elève récupéré avec succès", $student);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }
    
    #endregion

    #region POST

    public static function createStudent(array $student): Response {
        try {
            $splitted = splitArrayByKeys($student, ["pathways", "entry_years", "participations"]);
            $student = $splitted['first'];
            $pathways = $splitted['second']['pathways'];
            $entryYears = $splitted['second']['entry_years'];
            $participations = $splitted['second']['participations'];

            $columns = StudentManager::getColumnsNames();
            if (!formMatchesTable($student, $columns))
                return new Response(400, false, "Le formulaire ne correspond pas à la table.", array(
                    "data" => $student
                ));

            $exceptions = ["phone", "degree", "specialization"];
            if (!isFormFilled($student, $exceptions)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $student = trimArray($student);
            $NewStudent = new Student($student);
            $error = findModelValidationsError($NewStudent->getValidations());
            if ($error) return new Response(400, false, $error);

            $student = StudentManager::getStudentByEmail($student['email']);
            if ($student) return new Response(400, false, "Email déjà enregistrée.");

            StudentManager::createStudentRequest($NewStudent);
            $studentId = StudentManager::getLastCreatedStudentId();
            $body = array("data" => $student);
            $res = EntryYearController::createEntryYears($entryYears, $studentId);
            if ($res->getStatus() != 200) return $res;

            $res = PathwayController::createPathways($pathways, $studentId);
            if ($res->getStatus() != 200) return $res;

            $res = ParticipationController::createParticipations($participations, $studentId);
            if ($res->getStatus() != 200) $body += ["warning" => $res->getBody()];

            return new Response(200, true, "Elève créé avec succès.", $body);
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region PUT

    public static function modifyStudent(int $studentId, array $newStudent) {
        try {
            $student = StudentManager::getStudent($studentId);
            if (!$student) return new Response(400, false, "Elève inexistant.");

            $splitted = splitArrayByKeys($newStudent, ["pathways", "entry_years", "participations"]);
            $newStudent = $splitted['first'];
            $pathways = $splitted['second']['pathways'];
            $entryYears = $splitted['second']['entry_years'];
            $participations = $splitted['second']['participations'];
            
            $columns = StudentManager::getColumnsNames();
            if (!formMatchesTable($newStudent, $columns)) {
                return new Response(400, false, "Le formulaire ne correspond pas à la table.");
            }

            $exceptions = ["phone", "degree", "specialization"];
            if (!isFormFilled($newStudent, $exceptions)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $newStudent = trimArray($newStudent);
            $NewStudent = new Student($newStudent);
            $error = findModelValidationsError($NewStudent->getValidations());
            if ($error) return new Response(400, false, $error);

            StudentManager::modifyStudentRequest($NewStudent);

            $res = EntryYearController::modifyStudentEntryYears($entryYears, $studentId);
            if ($res->getStatus() != 200) return $res;

            $res = PathwayController::modifyStudentPathways($pathways, $studentId);
            if ($res->getStatus() != 200) return $res;

            $res = ParticipationController::modifyStudentParticipations($participations, $studentId);
            if ($res->getStatus() != 200) return $res;
            
            return new Response(200, true, "Elève modifié avec succès.", array("data" => $student));
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region DELETE

    public static function deleteStudent(int $studentId){
        try {
            $student = StudentManager::getStudent($studentId);
            if (!$student) return new Response(400, false, "Elève inexistant.");

            StudentManager::deleteStudentRequest($studentId);
            return new Response(200, true, "Elève supprimé avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

}