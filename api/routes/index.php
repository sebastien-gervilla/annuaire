<?php

require_once './specialization/index.php';
require_once './participation/index.php';
require_once './schoolyear/index.php';
require_once './student/index.php';
require_once './event/index.php';
require_once './user/index.php';
require_once './auth/index.php';
require_once '../inc/Response.php';
require_once '../inc/Request.php';

function useRedirections() {

    Request::allowCors();

    function useRoutes(string $url, string $model, string $method, string $endpoint, array|null $body): Response
    {
        if ($model != 'auth' && !isAuth())
            return new Response(400, false, 'Utilisateur non connecté');

        switch ($model) {
            case 'auth':
                return useAuthRoutes($method, $endpoint, $body);

            case 'user':
                return useUserRoutes($method, $endpoint, $body);

            case 'student':
                return useStudentRoutes($method, $endpoint, $body);

            case 'event':
                return useEventRoutes($method, $endpoint, $body);

            case 'specialization':
                return useSpecializationRoutes($method, $endpoint, $body);

            case 'schoolyear':
                return useSchoolYearRoutes($method, $endpoint, $body);

            case 'participation':
                return useParticipationRoutes($method, $endpoint, $body);
            
            default:
                return new Response(400, false, "Coudln't find url : $url");
        }
    }

    function isAuth() {
        $token = Request::getCookie('token');
        if (!$token) return false;

        $res = useAuthRoutes('GET', 'isauth');
        return $res->getStatus() == 200;
    }

    try {
        $res = useRoutes(
            Request::getUrl(), 
            Request::getModel(),
            Request::getMethod(), 
            Request::getEndpoint(), 
            Request::getBody()
        );
    } catch (\Throwable $error) {
        $res = new Response(400, false, "Un problème est survenu, réessayez plus tard.", array(
            "error" => $error
        ));
    } finally {
        return $res->send();
    }
}

die(useRedirections());