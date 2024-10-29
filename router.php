<?php

session_start();

require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/DestinoController.php';
require_once 'app/controllers/ViajeController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/ErrorController.php';
require_once 'app/helpers/AuthHelper.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$action = 'home';

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);

function checkAdmin() {
    return isset($_SESSION['USER_ID']) && isset($_SESSION['USER_ROL']) && $_SESSION['USER_ROL'] == 1;
}

switch ($params[0]) { 
    // Rutas públicas accesibles sin autenticación
    case 'home':
        $controller = new HomeController();
        $controller->showHome();
        break;
    case 'destinos': 
        $controller = new DestinoController();
        $controller->showDestinos();
        break;
    case 'viajeByDestino': 
        $controller = new ViajeController();
        $controller->showViajesByDestinoId($params[1]);
        break;
    case 'login':
        $controller = new AuthController();
        $controller->showLogin();
        break;
    case 'singup': 
        $controller = new AuthController();
        $controller->showSingup();
        break;
    case 'registro': 
        $controller = new AuthController();
        $controller->upUser();
        break;
    case 'auth': 
        $controller = new AuthController();
        $controller->auth();
        break;
    case 'logOut': 
        if (isset($_SESSION['USER_ID'])) {
            $controller = new AuthController();
            $controller->logOut();
        } else {
            header('Location: ' . BASE_URL . 'login');
        }
        break;

    // Rutas que requieren autenticación como administrador
    case 'eliminarViaje':
        if (checkAdmin()) {
            $controller = new ViajeController();
            $controller->removeViajes($params[1], $params[2]);
        } else {
            header('Location: ' . BASE_URL . 'login');
        }
        break;
    case 'agregarViaje':
        if (checkAdmin()) {
            $controller = new ViajeController();
            $controller->addViaje($params[1]);
        } else {
            header('Location: ' . BASE_URL . 'login');
        }
        break;
    case 'actualizarViaje':
        if (checkAdmin()) {
            $controller = new ViajeController();
            $controller->updateViajes($params[1]);
        } else {
            header('Location: ' . BASE_URL . 'login');
        }
        break;
    case 'editarViaje':
        if (checkAdmin()) {
            $controller = new ViajeController();
            $controller->editViajes($params[1]);
        } else {
            header('Location: ' . BASE_URL . 'login');
        }
        break;
    case 'eliminarDestino':
        if (checkAdmin()) {
            $controller = new DestinoController();
            $controller->removeDestino($params[1]);
        } else {
            header('Location: ' . BASE_URL . 'login');
        }
        break;
    case 'agregarDestino':
        if (checkAdmin()) {
            $controller = new DestinoController();
            $controller->addDestino();
        } else {
            header('Location: ' . BASE_URL . 'login');
        }
        break;
    case 'actualizarDestino':
        if (checkAdmin()) {
            $controller = new DestinoController();
            $controller->updateDestino($params[1]);
        } else {
            header('Location: ' . BASE_URL . 'login');
        }
        break;
    case 'editDestino':
        if (checkAdmin()) {
            $controller = new DestinoController();
            $controller->editDestino($params[1]);
        } else {
            header('Location: ' . BASE_URL . 'login');
        }
        break;

    default:
        $controller = new ErrorController();
        $controller->showError404("pagina no encontrada");
        break;
}