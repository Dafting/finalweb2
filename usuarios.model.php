<?php

class UsuariosModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=dbBolsaDeEmpleoTandil;charset=utf8', 'admin', 'contraseñaMuyComplicada');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getUsuarios() {
        $query = $this->db->prepare("SELECT * FROM usuarios");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUsuario($idUsuario) {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $query->execute(array($idUsuario));
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}