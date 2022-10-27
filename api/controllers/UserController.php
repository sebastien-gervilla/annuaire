<?php

require_once __DIR__ . '/../utils/utils.php';
require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../models/user.php";
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/UserManager.php";

class UserController {

    #region GET

    public static function getAll(): Response {
        try {
            $users = UserManager::getAllusers();
            return new Response(200, true, "Utilisateurs récupérés avec succès", $users);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }

    public static function getById(int $id): Response {
        try {
            $user = UserManager::getUser($id);
            return new Response(200, true, "Utilisateur récupéré avec succès", $user);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }
    
    #endregion

    #region POST

    public static function createUser(array $user): Response {
        try {
            $columns = UserManager::getColumnsNames();
            if (!formMatchesTable($user, $columns))
                return new Response(400, false, "Le formulaire ne correspond pas à la table.", array(
                    "data" => $user
                ));

            if (!isFormFilled($user)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $user = trimArray($user);
            $NewUser = new User($user);
            $error = findModelValidationsError($NewUser->getValidations());
            if ($error) return new Response(400, false, $error);

            $checkedUser = UserManager::getUserByEmail($user['email']);
            if ($checkedUser) return new Response(400, false, "Email déjà enregistrée.");

            $NewUser->hashPassword();
            UserManager::createUserRequest($NewUser);
            $body = array("data" => $NewUser->getModel());

            return new Response(200, true, "Utilisateur créé avec succès.", $body);
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    public static function resetAdmin(array $user): Response {
        try {
            $columns = UserManager::getColumnsNames();
            if (!formMatchesTable($user, $columns))
                return new Response(400, false, "Le formulaire ne correspond pas à la table.", array(
                    "data" => $user
                ));

            if (!isFormFilled($user)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $user = trimArray($user);
            $NewUser = new User($user);
            $error = findModelValidationsError($NewUser->getValidations());
            if ($error) return new Response(400, false, $error);

            $checkedUser = UserManager::getUserByEmail($user['email']);
            if (!$checkedUser['is_admin'] && $checkedUser) 
                return new Response(400, false, "Email déjà enregistrée.");

            $admins = UserManager::getAllAdmins();
            foreach ($admins as $admin) {
                UserManager::deleteUserRequest($admin['_id']);
            }

            $NewUser->hashPassword();
            UserManager::createAdminRequest($NewUser);
            $body = array("data" => $NewUser->getModel());

            return new Response(200, true, "Utilisateur créé avec succès.", $body);
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

    #region PUT

    public static function modifyUser(int $userId, array $newUser) {
        try {
            $user = UserManager::getUser($userId);
            if (!$user) return new Response(400, false, "Utilisateur inexistant.");
            
            $columns = UserManager::getColumnsNames();
            if (!formMatchesTable($newUser, $columns)) {
                return new Response(400, false, "Le formulaire ne correspond pas à la table.");
            }

            if (!isFormFilled($newUser)) {
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");
            }

            $newUser = trimArray($newUser);
            $NewUser = new User($newUser);
            $error = findModelValidationsError($NewUser->getValidations());
            if ($error) return new Response(400, false, $error);

            $checkedUser = UserManager::getUserByEmail($newUser['email']);
            if ($checkedUser && $checkedUser['_id'] !== $userId) 
                return new Response(400, false, "Email déjà enregistrée.", $checkedUser);

            if ($user['password'] != $newUser['password'])
                $NewUser->hashPassword();
            UserManager::modifyUserRequest($NewUser, $userId);
            
            return new Response(200, true, "Utilisateur modifié avec succès.", array("data" => $user));
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "data" => $checkedUser
            ));
        }
    }

    #endregion

    #region DELETE

    public static function deleteUser(int $userId) {
        try {
            $user = UserManager::getUser($userId);
            if (!$user) return new Response(400, false, "Utilisateur inexistant.");

            if ($user['is_admin']) 
                return new Response(400, false, "Impossible de supprimer un Super Admin");

            UserManager::deleteUserRequest($userId);
            return new Response(200, true, "Utilisateur supprimé avec succès.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

}