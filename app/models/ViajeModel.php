<?php

require_once './config.php';
require_once './app/models/Model.php';

class viajeModel extends Model
{

    function getViajesByDestino($href)
    {
        $query = $this->db->prepare('SELECT * FROM viajes WHERE id_destinos = ?');
        $query->execute([$href]);

        $viajes = $query->fetchAll(PDO::FETCH_OBJ);

        return $viajes;
    }

    function deleteViaje($idViaje)
    {
        $query = $this->db->prepare('DELETE FROM viajes WHERE id = ?');
        $query->execute([$idViaje]);
    }

    function insertViaje($fecha, $hora, $id_destinos)
    {  
        $query = $this->db->prepare('INSERT INTO viajes (fecha, hora, id_destinos) VALUES(?, ?, ?)');
        $query->execute([$fecha, $id_destinos, $hora]);
    
        return $this->db->lastInsertId();
    }

    public function modifyViaje($newFecha, $newDestino, $newHora)
    {  
        $query = $this->db->prepare('UPDATE viajes SET fecha = ?, id_destinos = ?, hora = ? WHERE id = ?');
        $query->execute([$newFecha, $newDestino, $newHora]);
    }
}