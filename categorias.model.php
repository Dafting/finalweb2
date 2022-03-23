<?php

class CategoriasModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=dbBolsaDeEmpleoTandil;charset=utf8', 'admin', 'contraseñaMuyComplicada');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getCategorias() {
        $query = $this->db->prepare("SELECT * FROM categorias");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCategoria($idCategoria) {
        $query = $this->db->prepare("SELECT * FROM categorias WHERE id = ?");
        $query->execute(array($idCategoria));
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}