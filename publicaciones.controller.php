<?php

include_once("model/publicaciones.model.php");
include_once("model/usuarios.model.php");
include_once("model/categorias.model.php");
include_once("model/visitas.model.php");
include_once("view/publicaciones.view.php");
include_once("controller/auth.controller.php");

class PublicacionesController{
    private $publicacionesModel;
    private $usuariosModel;
    private $categoriasModel;
    private $visitasModel;
    private $publicacionesView;
    private $authController;

    #PUBLICACION (id: int, fecha: date, activa: boolean, descripcion: string,  id_user: int, id_categoria: int) // id_user es el profesional asociado
    #CATEGORIA(id: int, nombre: string, destacada: boolean)
    #VISITA(id: int, fecha: date, id_publicacion: int, id_user: int)
    #USER(id: int, email: string, telefono: string, password: string, premium: boolean)

    public function __construct() {
        $this->publicacionesModel = new PublicacionesModel();
        $this->usuariosModel = new UsuariosModel();
        $this->categoriasModel = new CategoriasModel();
        $this->visitasModel = new VisitasModel();
        $this->publicacionesView = new PublicacionesView();
        $this->authController = new AuthController();
    }

    function mostrarPublicacion($idPublicacion) {
        $this->authController->verificarSesion(); // Verifica que el usuario este logueado, si no lo redirige al login.
        $publicacion = $this->publicacionesModel->getPublicacion($idPublicacion);
        $usuario = $this->usuariosModel->getUsuario($publicacion[0]->IdUsuario);
        $categoria = $this->categoriasModel->getCategoria($publicacion[0]->IdCategoria);
        $this->publicacionesView->mostrarPublicacion($publicacion, $usuario, $categoria);
    }

    function mostrarTodasLasPublicaciones() {
        $publicaciones = $this->publicacionesModel->getPublicaciones();
        $usuarios = $this->usuariosModel->getUsuarios();
        $categorias = $this->categoriasModel->getCategorias();
        $this->publicacionesView->mostrarTodasLasPublicaciones($publicaciones, $usuarios, $categorias, $visitas);
    }

    function crearPublicacion() {
        $this->authController->verificarSesion(); // Verifica que el usuario este logueado, si no lo redirige al login.
        $publicaciones = $this->publicacionesModel->getPublicacionesFromUser($_SESSION['id']); 
        if (count($publicaciones) < 5 || $_SESSION['premium'] == true) {
            $fechaHoy = date("Y-m-d");
            $activa = true;
            $descripcion = $_REQUEST["descripcion"];
            $idCategoria = $_REQUEST["categoria"];
    
            if ($this->publicacionesModel->crearPublicacion($fechaHoy, $activa, $descripcion, $_SESSION['id'], $idCategoria)) {
                $this->publicacionesView->mostrarMensaje("Publicación creada con éxito");
            } else {
                $this->publicacionesView->mostrarMensaje("Error al crear la publicación");
            }
        } else {
            $this->publicacionesView->mostrarMensaje("No puedes crear más de 5 publicaciones");
        }
    }

    function buscarPublicacion() {
        $this->authController->verificarSesion(); // Verifica que el usuario este logueado, si no lo redirige al login.
        if(isset($_REQUEST['categoria']) || isset($_REQUEST['descripcion'])) { // Si se seleccionó una categoria o una descripcion
            $idCategoria = (isset($_REQUEST['categoria']) ? $_REQUEST['categoria'] : 0);
            $descripcion = (isset($_REQUEST['descripcion']) ? $_REQUEST['descripcion'] : "");
            $this->publicacionesModel->buscarPublicacion($idCategoria, $descripcion); // Busca las publicaciones que coincidan con los filtros, si no hay filtros, no devuelve nada.
        }
    }
    
    function desactivarPublicacion($idPublicacion) {
        $this->authController->verificarAdmin(); // Verifica que el usuario esté loguedo y sea administrador, si no devuelve un error 403.
        $publicacion = $this->publicacionesModel->getPublicacion($idPublicacion);
        $usuario = $this->usuariosModel->getUsuario($publicacion[0]->IdUsuario);
        $categorias = $this->categoriasModel->getCategorias();
        if (!$usuario[0]->premium && $categorias[0]->destacada) { // Si el usuario no es premium y la categoria es destacada, no puede desactivar la publicacion.
            if ($this->publicacionesModel->desactivarPublicacion($idPublicacion)) {
                $this->publicacionesView->mostrarMensaje("Publicación desactivada con éxito");
            } else {
                $this->publicacionesView->mostrarMensaje("Error al desactivar la publicación");
            }
        }
    }
}
    
