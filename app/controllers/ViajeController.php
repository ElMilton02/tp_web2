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
        AuthHelper::verify();

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
        $this->model->deleteViaje($idViajes);
        header('Location: ' . BASE_URL . 'viajesByDestino/' . $idDestino);
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

    public function updateViajes( $idViajes)
    {
        $newFecha = $_POST['nuevaFecha'];
        $newHora =  $_POST['nuevaHora'];
        $viajeid = $idViajes;
       

        if (empty($newFecha) || empty($newHora )) {
        } else {
            $this->model->modifyViaje($newFecha, $newHora, $idViajes);
        
            // Obtener el viaje actualizado
            $viaje = $this->model->getViajeById($idViajes);
            
            // Obtener el ID del destino del viaje
            $destinoId = $viaje->id_destinos;
            
            // Redirigir a la página de viajes del destino específico
            header('Location: ' . BASE_URL . 'viajeByDestino/' . $destinoId);
        }
    }
}