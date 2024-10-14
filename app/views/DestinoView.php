<?php

class DestinoView
{
    public function showDestinos($destinos, $error = null)
    {
        $rol = isset($_SESSION['USER_ROL']) ? $_SESSION['USER_ROL'] : null;
        require_once './templates/destinos.phtml';
        return $href;
    }

    public function showEditDestinoForm($destino, $id, $error = null)
    {
        require_once './templates/editDestino.phtml';
    }
}