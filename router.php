<?php

require_once 'config.php';
require_once './app/controllers/auth.controller.php';


define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$action = 'home';

if (!empty( $_GET['action'])) {
    $action = $_GET['action'];
}

#Aquí se divide la acción en partes separadas por '/'
#lo cual permite usar tanto la primera parte como las subsiguientes para métodos específicos
$params = explode('/', $action);

#Dependiendo de la acción solicitada (primer valor de $params), el código invoca el controlador correspondiente y ejecuta la acción.
#Por ejemplo, si la acción es 'listar', crea una instancia de VinotecaController y llama a su método showVinos()
switch ($params[0]) { 
    case 'home':
        $controller= new HomeController();
        $controller->showHome();
        break;
    
}
