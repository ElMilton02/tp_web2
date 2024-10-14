<?php

require_once './apps/models/ViajeModel.php';
require_once './apps/views/ViajeView.php';
require_once './apps/helpers/AuthHelper.php';
require_once './config.php';
require_once './apps/controllers/ErrorController.php';

class ViajeController
{
    private $model;
    private $view;

    public function __construct()
    {
        AuthHelper::verify();

        $this->model = new ViajeModel();
        $this->view = new ViajeView();
    }

    public function showViajesByDestinoId($destinoId)
    {
        $listViajes = $this->model->getViajesByDestino($destinoId);
        $this->view->showViajesByDestinoId($listViajes, $destinoId);
    }

    public function removeViajes($idDestino, $idViajes)
    {
        $this->model->deleteViaje($idViajes);
        header('Location: ' . BASE_URL . 'viajesByDestino/' . $idDestino);
    }

    public function addViaje($destinoId)
    {
        $fecha_viaje = $_GET['fecha_viaje'];
        $hora_viaje = $_GET['hora_viaje'];
        $id_destino = $destinoId;

        if (empty($id_destino) || empty($fecha_viaje) || empty($hora_viaje)) {


            var_dump($id_destino, $fecha_viaje, $hora_viaje);
        } else {
            $this->model->insertViaje($id_destino, $fecha_viaje, $hora_viaje);
            header('Location: ' . BASE_URL . 'viajeByDestino/' . $id_destino);
        }
    }

    public function  editViajes($idViajes)
    {
        $this->view->showEditViajeForm($idViajes);
    }

    public function updateViajes($idViajes)
    {
        $newFecha = $_POST['nuevaFecha'];
        $newHora =  $_POST['nuevaHora'];

        if (empty($newFecha) || empty($newHora )) {
        } else {
            $this->model->modifyViaje($idViajes, $newFecha, $newHora );
            header('Location: ' . BASE_URL . 'viajes');
        }
    }
}