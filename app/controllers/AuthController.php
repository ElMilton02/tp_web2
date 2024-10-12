<?php

require_once './apps/models/LoginModel.php';
require_once './apps/views/LoginView.php';
require_once './apps/helpers/AuthHelper.php';
require_once './apps/controllers/ErrorController.php';

//define la clase AuthController
class AuthController
{
    //almacena una instancia de 'LoginView'
    private $view;
    //almacena una instancia de 'LoginModel'
    private $model;


    public function __construct()
    {
        //a la propiedad $model se le añade la isntancia loginmodel
        $this->model = new LoginModel();
        //a la propiedad $view se le añade la isntancia loginview
        $this->view = new LoginView();
    }

    //muestra la vista de inicio de sesion 
    public function showLogin()
    {
        $this->view->showLogin();
    }

    //metodo responsable de la autenticacion del usuario
    public function auth()
    {
        if (isset($_SESSION['USER_ID'])) {
            // El usuario ya está autenticado, redirige a la página principal
            header('Location: ' . BASE_URL . 'home');
            return;
        }

        //se obtienen los valores del usuario y la contraseña usando $_POST
        $user = $_POST['user'];
        $password = $_POST['password'];

        //se verifican si usuario o contraseña estan vacios
        if (empty($user) || empty($password)) {
            $controller = new ErrorController();
            $controller->showErrorNonData("Datos Vacíos");
            return;
        }

        //se obtiene la informacion del usuario de la base de datos
        $userDb = $this->model->getLogin($user);

        //verifica si hay conincidencia con la base de datos
        if ($userDb && password_verify($password, $userDb->clave_usuario)) {
            AuthHelper::login($userDb);
            // Usuario autenticado, redirige a la página principal
            header('Location: ' . BASE_URL);
        } else {
            $controller = new ErrorController();
            $controller->showErrorInvalidUser("Usuario inválido");
        }
    }

    //metodo que permite cerrar secion 
    public function logOut()
    {
        AuthHelper::logOut();

        die;
    }

    //muestra la vista de registro
    public function showSingup()
    {
        $this->view->showSingup();
    }

    //procesa el formulario de registro de usuarios
    public function upUser()
    {
        //obtiene los valores del nombre de usuario y contraseña del formulario
        $user = $_POST['nombre'];
        $password = $_POST['password'];

        //verifica si los campos estan vacios
        if (empty($user) || empty($password)) {
            $controller = new ErrorController();
            $controller->showErrorNonData("Datos vacíos");
            return;
        } else {
            // Genera el hash de la contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            //se insetta ele usuario en la base de datos
            $this->model->insertUser($user, $passwordHash);
            header('Location: ' . BASE_URL . 'login');
            die;
        }
    }
}
