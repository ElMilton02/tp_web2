<?php

require_once './app/models/DestinoModel.php';
require_once './app/views/DestinoView.php';
require_once './app/helpers/AuthHelper.php';
require_once './config.php';
require_once './app/controllers/ErrorController.php';

class DestinoController
{

    private $model;
    private $view;

    //verifia la autenticacion del usuario 
    public function __construct()
    {

        AuthHelper::verify();

        $this->model = new DestinoModel();
        $this->view = new DestinoView();
    }

    //obtiene destinos desde el modelo y las mustra
    public function showDestinos()
    {

        $destinos = $this->model->getDestinos();
        $href = $this->view->showDestinos($destinos);
    }

    //elimina un destino
    public function removeDestino($id)
    {
        if (empty($id)) {
            header('Location: ' . BASE_URL . 'destinos');
        } else {
            try {

                $this->model->deleteDestino($id);
                // Eliminación exitosa, redirige a la página de destinos
                header('Location: ' . BASE_URL . 'destinos');
            } catch (\Throwable $th) {
                $destino =  $this->model->getDestinoById($id);
                $controller = new ErrorController();
                $controller->showErrorDelete("El destino: **" . $destino->destino . "** contiene viajes, primero debe vaciar.", $this->model);
            }
        }
    }

    //añade un nuevo destino
    public function addDestino()
    {
        $destino = $_GET['destino'];
        if (empty($destino)) {
            $controller = new ErrorController();
            $controller->showErrorNonDataDestino('Datos Vacios',  $this->model);
        } else {
            $newDestino = $this->model->insertDestino($destino);
            if ($newDestino) {
                header('Location: ' . BASE_URL . 'destinos');
            } else {
                $controller = new ErrorController();
                $controller->showErrorInsert("Error al insertar el destino");
            }
        }
    }


    public function editDestino($id)
    {
        $destino = $this->model->getDestinoById($id);
        $this->view->showEditDestinoForm($destino, $id);
    }


    public function updateDestino($id)
    {
        $destino = $_GET['newDestino'];

        if (empty($destino) || empty($img)) {

            $controller = new ErrorController();
            $controller->showErrorNonDataDestino('Datos Vacios',  $this->model);
        } else {
            $this->model->modifyDestino($destino, $id, $img);
            header('Location: ' . BASE_URL . 'destinos');
        }
    }
}