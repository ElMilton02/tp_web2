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

switch ($params[0]) { 
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
        $controller = new AuthController();
        $controller->logOut();
        break;
    case 'eliminarViaje':
        $controller = new ViajeController();
        $controller->removeViajes($params[1], $params[2]);
        break;
    case 'agregarViaje':
        $controller = new ViajeController();
        $controller->addViaje($params[1]);
        break;
    case 'actualizarViaje':
        $controller = new ViajeController();
        $controller->updateViajes($params[1]);
        break;
    case 'editarViaje':
        $controller = new ViajeController();
        $controller->editViajes($params[1]);
        break;
    case 'eliminarDestino':
        $controller = new DestinoController();
        $controller->removeDestino($params[1]);
        break;
    case 'agregarDestino':
        $controller = new DestinoController();
        $controller->addDestino();
        break;
    case 'actualizarDestino':
        $controller = new DestinoController();
        $controller->updateDestino($params[1]);
        break;
    case 'editDestino':
        $controller = new DestinoController();
        $controller->editDestino($params[1]);
        break;
    default:
        $controller = new ErrorController();
        $controller->showError404("pagina no encontrada");
        break;
}