<?php

require_once './app/models/ViajeModel.php';
require_once './app/views/ViajeView.php';
require_once './app/helpers/AuthHelper.php';
require_once './config.php';
require_once './app/controllers/ErrorController.php';

class ViajeController
{
    private $model;
    private $view;
    private $destinoModel;

    public function __construct()
    {
        $this->model = new ViajeModel();
        $this->view = new ViajeView();
        $this->destinoModel = new DestinoModel();
    }

    public function showViajesByDestinoId($destinoId)
    {
        $listViajes = $this->model->getViajesByDestino($destinoId);
        $nombreDestino = $this->destinoModel->getDestinoById($destinoId)->destino;
        $this->view->showViajesByDestinoId($listViajes, $destinoId, $nombreDestino);
    }

    public function removeViajes($idDestino, $idViajes)
    {
        AuthHelper::verifyAdmin();
        $viaje = $this->model->getViajeById($idViajes);
        if (!$viaje) {
            $controller = new ErrorController();
            $controller->showError404("Viaje no encontrado");
            return;
        }
        if ($viaje->id_destinos == $idDestino) {
            $this->model->deleteViaje($idViajes);
            header('Location: ' . BASE_URL . 'viajeByDestino/' . $idDestino);
        } else {
            $controller = new ErrorController();
            $controller->showError404("El viaje no pertenece al destino especificado");
        }
    }

    public function addViaje($destinoId)
    {
        AuthHelper::verifyAdmin();
        $fecha = $_POST['fecha_viaje'];
        $hora = $_POST['hora_viaje'];

        if (empty($fecha) || empty($hora) || empty($destinoId)) {
            $controller = new ErrorController();
            $controller->showErrorNonDataViajes("Datos incompletos", $this->model, $destinoId);
        } else {
            $this->model->insertViaje($fecha, $hora, $destinoId);
            header('Location: ' . BASE_URL . 'viajeByDestino/' . $destinoId);
        }
    }

    public function  editViajes($idViajes)
    {
        AuthHelper::verifyAdmin();
        $viaje = $this->model->getViajeById($idViajes);
        if (!$viaje) {
            $controller = new ErrorController();
            $controller->showError404("Viaje no encontrado");
            return;
        }
        $this->view->showEditViajeForm($idViajes);
    }

    public function updateViajes( $idViajes)
    {
        AuthHelper::verifyAdmin();
        $viaje = $this->model->getViajeById($idViajes);
        if (!$viaje) {
            $controller = new ErrorController();
            $controller->showError404("Viaje no encontrado");
            return;
        }

        $newFecha = $_POST['nuevaFecha'];
        $newHora = $_POST['nuevaHora'];
       
        if (empty($newFecha) || empty($newHora)) {
            $controller = new ErrorController();
            $controller->showErrorNonDataViajes("Datos incompletos", $this->model, $viaje->id_destinos);
        } else {
            $this->model->modifyViaje($newFecha, $newHora, $idViajes);
            header('Location: ' . BASE_URL . 'viajeByDestino/' . $viaje->id_destinos);
        }
    }
}