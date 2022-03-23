<?php

include_once("model/usuarios.model.php");
include_once("view/usuarios.view.php"); // Archivo supuesto, no existe.

class AuthController{
    private $usuariosModel;
    private $usuariosView;

    public function __construct() {
        $this->usuariosModel = new UsuariosModel();
        $this->usuariosView = new UsuariosView();
    }

    public function verificarSesion() {
        session_start();
        if (!isset($_SESSION['id'])) {
            $this->usuariosView->mostrarMensaje("Debes iniciar sesión para acceder a esta página");
            header("Location: login.php");
        }
    }

    public function verificarAdmin() {
        session_start();
        if ($_SESSION['isAdmin'] == false) {
            $this->usuariosView->mostrarMensaje("Debes ser admin para acceder a esta página");
            header("Location: index.php");
        }
    }
}