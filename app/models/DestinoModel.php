<?php

require_once './config.php';
require_once './app/models/Model.php';

class DestinoModel extends Model
{

    function getDestinos()
    {

        $query = $this->db->prepare('SELECT * FROM destinos');
        $query->execute();

      
        $destinos = $query->fetchAll(PDO::FETCH_OBJ);

        return $destinos;
    }

    function deleteDestino($idDestino)
    {
        $query = $this->db->prepare('DELETE FROM destinos WHERE id = ?');
        $query->execute([$idDestino]);
    }

    function insertDestino($destino)
    {
        $query = $this->db->prepare('INSERT INTO destinos (destino) VALUES(?)');
        $query->execute([$destino]);
        return $this->db->lastInsertId();
    }

    public function getDestinoById($id)
    {
        $query = $this->db->prepare('SELECT * FROM destinos WHERE id = ?');
        $query->execute([$id]);

        // Obtener la categoría como un objeto
        $destino = $query->fetch(PDO::FETCH_OBJ);

        return $destino;
    }

    public function modifyDestino($id, $destino, $img)
    {
        $query = $this->db->prepare('UPDATE Destinos SET destino = ?, img = ? WHERE id_destino = ?');
        $query->execute([$id, $destino, $img]);
    }
}
