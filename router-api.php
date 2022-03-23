<?php
    # Omito el código con todas las declaraciones e includes. 

    $router = new Router();

    $router->addRoute("/publicaciones", "GET", "PublicacionesController", "mostrarTodasLasPublicaciones");

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']); 