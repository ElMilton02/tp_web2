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

    public function removeViajes($destinoId, $idViajes)
    {
        $this->model->deleteViaje($idViajes);
        header('Location: ' . BASE_URL . 'viajesByDestino/' . $destinoId);
    }

    public function addViaje($destinoId)
    {
        $fecha = $_POST['fecha_viaje'];
        $hora = $_POST['hora_viaje'];
        $id_destinos = $destinoId;

        if (empty($fecha) || empty($hora) || empty($id_destinos)) {


            var_dump($id_destinos, $fecha, $hora);
        } else {
            $this->model->insertViaje($fecha, $hora, $id_destinos);
            header('Location: ' . BASE_URL . 'viajeByDestino/' . $id_destinos);
        }
    }

    public function  editViajes($idViajes)
    {
        $this->view->showEditViajeForm($idViajes);
    }

    public function updateViajes($idViajes)
    {
        $newFecha = $_POST['nuevaFecha'];
        $newHora = $_POST['nuevaHora'];

        if (!empty($newFecha) && !empty($newHora)) {
            $this->model->modifyViaje($newFecha, $newHora, $idViajes);  // Cambia el orden de los parámetros
            header('Location: ' . BASE_URL . 'viajes');
        } else {
      
        }
    }
}