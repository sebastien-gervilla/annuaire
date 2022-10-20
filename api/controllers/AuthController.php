<?php

require_once __DIR__ . '/../utils/utils.php';
require_once __DIR__ . '/../inc/Response.php';
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../inc/model-validations.php";
require_once __DIR__ . "/../managers/AuthManager.php";

class AuthController {

    #region GET

    public static function getAllUsers(): Response {
        try {
            $users = AuthManager::getAllUsersRequest();
            return new Response(200, true, "Utilisateurs récupérés avec succès", $users);
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }

    public static function isAuth(string|null $token): Response {
        try {
            if (!$token)
                return new Response(400, false, "Aucune session existante.", $token);

            $usersReq = self::getAllUsers();
            $users = $usersReq->getBody();
            foreach ($users as $user)
                if ($token == $user['password'])
                    return new Response(200, true, "Utilisateur connecté.");
                    
            return new Response(400, false, "Utilisateur non connecté.");
        } catch (\Throwable $error) {
            return new Response(400, false, "La requête à échouée : $error");
        }
    }
    
    #endregion

    #region POST

    public static function login(array $logs): Response {
        try {
            $columns = AuthManager::getColumnsNames();
            if (!formMatchesTable($logs, $columns))
                return new Response(400, false, "Le formulaire ne correspond pas à la table.", array(
                    "data" => $logs
                ));

            if (!isFormFilled($logs, []))
                return new Response(400, false, "Tous les champs requis ne sont pas remplis.");

            $User = new User($logs);
            $error = findModelValidationsError($User->getValidations());
            if ($error) return new Response(400, false, $error);

            $usersRes = self::getAllUsers();
            $users = $usersRes->getBody();
            $ids = $User->getModel();
            foreach ($users as $user) {
                if ($ids['email'] == $user['email']
                && password_verify($ids['password'], $user['password']))
                    return new Response(200, true, "Connection réussie.", array(
                        'token' => $user['password']
                    ));
            }

            return new Response(400, false, "Identifiants de connection incorrects.", $users);
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    public static function logout(string|null $token): Response {
        try {
            if (!$token)
                return new Response(400, false, "Aucune session existante.", $token);

            return new Response(200, true, "Déconnection réussie.");
        } catch (Error $error) {
            return new Response(400, false, "Une erreur est survenue, veuillez réessayer plus tard.", array(
                "error" => $error
            ));
        }
    }

    #endregion

}