<?php

class PublicacionesModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=dbBolsaDeEmpleoTandil;charset=utf8', 'admin', 'contraseñaMuyComplicada');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPublicaciones() {
        $query = $this->db->prepare("SELECT * FROM publicaciones");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPublicacion($idPublicacion) {
        $query = $this->db->prepare("SELECT * FROM publicaciones WHERE id = ?");
        $query->execute(array($idPublicacion));
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPublicacionesFromUser($idUsuario) {
        $query = $this->db->prepare("SELECT * FROM publicaciones WHERE id_user = ?");
        $query->execute(array($idUsuario));
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function crearPublicacion($fecha, $activa, $descripcion, $idUsuario, $idCategoria) {
        $query = $this->db->prepare("INSERT INTO publicaciones (fecha, activa, descripcion, id_user, id_categoria) VALUES (?, ?, ?, ?, ?)");
        $result = $query->execute(array($fecha, $activa, $descripcion, $idUsuario, $idCategoria));
        return $result;
    }

    public function desactivarPublicacion($idPublicacion) {
        $query = $this->db->prepare("UPDATE publicaciones SET activa = 0 WHERE id = ?");
        $result = $query->execute(array($idPublicacion));
        return $result;
    }

    public function buscarPublicacion($categoria, $descripcion) {
        if ($categoria == 0) {
            $query = $this->db->prepare("SELECT * FROM publicaciones WHERE descripcion LIKE '%$descripcion%'");
            $query->execute(array($descripcion));
        } elseif ($descripcion == "") {
            $query = $this->db->prepare("SELECT * FROM publicaciones WHERE id_categoria = ?");
            $query->execute(array($categoria));
        } else {
            $query = $this->db->prepare("SELECT * FROM publicaciones WHERE id_categoria = ? AND descripcion LIKE '%$descripcion%'");
            $query->execute(array($categoria, $descripcion));
        }
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}