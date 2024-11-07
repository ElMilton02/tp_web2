<?php

class AuthHelper
{
    public static function init()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($userDb)
    {
        AuthHelper::init();
        $_SESSION['USER_ROL'] = $userDb->rol;
        $_SESSION['USER_NAME'] = $userDb->nombre_usuario;
        $_SESSION['USER_ID'] = $userDb->id;
    }

    public static function logOut()
    {
        AuthHelper::init();
        session_destroy();
        header('Location: ' . BASE_URL . '');
        die;
    }

    public static function verify($page = null)
    {
        AuthHelper::init();
        if (!isset($_SESSION['USER_ID'])) {
            $controller = new ErrorController();
            $controller->showErrorNonUser('Para editar inicia sesión', $page);
            return false;
        }
        return true;
    }

    public static function verifyAdmin($page = null)
    {
        AuthHelper::init();
        if (!isset($_SESSION['USER_ID']) || !isset($_SESSION['USER_ROL']) || $_SESSION['USER_ROL'] !== 1) {
            $controller = new ErrorController();
            $controller->showErrorNonUser('Acceso denegado. Se requieren permisos de administrador', $page);
            return false;
        }
        return true;
    }
}