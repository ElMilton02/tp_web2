<?php

class ViajeView
{
    public function showViajesByDestinoId($listViajes, $destinoId, $nombreDestino, $error = null)
    {
        $rol = isset($_SESSION['USER_ROL']) ? $_SESSION['USER_ROL'] : null;
        require_once './templates/Viajes.phtml';
    }

    public function showEditViajeForm($idViajes, $error = null)
    {
        require_once './templates/editViaje.phtml';
    }
}