<?php

require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../models/Student.php";
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/StudentManager.php";

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
            $columns = StudentManager::getColumnsNames();
            if (!formMatchesTable($student, $columns)) {
                return new Response(400, false, "Le formulaire ne correspond pas à la table.");
            }

            $exceptions = ["phone", "degree", "specialization"];
            if (!isFormFilled($student, $exceptions)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $student = trimArray($student);
            $NewStudent = new Student($student);
            $error = findModelValidationsError($NewStudent->getValidations());
            if ($error) return new Response(400, false, $error);

            StudentManager::createStudentRequest($student);
            return new Response(200, true, "Elève créé avec succès.", $student);
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

            StudentManager::modifyStudentRequest($studentId, $newStudent);
            return new Response(200, true, "Elève modifié avec succès.", $newStudent);
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