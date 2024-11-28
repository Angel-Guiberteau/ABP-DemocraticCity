<?php
    require_once 'php/config/config.php';

    //   Asignamos automaticamente el metodo y controlador por defecto si no le pasas ninguno.
    if(!isset($_GET['controlador']))$_GET['controlador'] = controlador_Usuario;
    if(!isset($_GET['metodo'])){$_GET['metodo'] = metodo_Usuario;}

    //Concatenamos para la ruta del controlador e incluirlo despues
    $rutaControlador = 'php/controladores/c' . $_GET['controlador'] . '.php';
    require_once $rutaControlador;

    //Creamos el objeto del controlador.
    $controlador = 'C'.$_GET['controlador'];
    $objControlador = new $controlador();
    