<?php
    # Omito el código con todas las declaraciones e includes. 

    $router = new Router();

    $router->addRoute("/publicaciones/:id", "GET", "PublicacionesController", "mostrarPublicacion");
    $router->addRoute("/publicaciones/:id", "POST", "PublicacionesController", "crearPublicacion");
    $router->addRoute("/buscarPublicacion/:categoria/:descripcion", "GET", "PublicacionesController", "buscarPublicaciones");
    $router->addRoute("/desactivarPublicacion/:id", "GET", "PublicacionesController", "desactivarPublicacion");

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']); 