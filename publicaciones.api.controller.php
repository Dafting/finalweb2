<?php
require_once("./models/publicaciones.model.php");
require_once("./api/json.view.php");

class PublicacionesApiController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new PublicacionesModel();
        $this->view = new JSONView();
    }

    public function getPublicaciones() {
        $publicaciones = $this->model->getPublicaciones();
        $this->view->response($publicaciones);
    }
}