<?php
    require_once 'php/config/config.php';
    require_once 'php/modelos/db.php';

    session_start();

    //   Asignamos automaticamente el metodo y controlador por defecto si no le pasas ninguno.
    if(!isset($_GET['c']))$_GET['c'] = controlador_Usuario;
    if(!isset($_GET['m'])){$_GET['m'] = '';} // sin metodo por defecto.

    //Concatenamos para la ruta del controlador e incluirlo despues
    $rutaControlador = 'php/controladores/c' . $_GET['m'] . '.php';
    require_once $rutaControlador;

    //Creamos el objeto del controlador.
    $controlador = 'C'.$_GET['controlador'];
    $objControlador = new $controlador();

    $datos;
    if($_SERVER['REQUEST_METHOD']=='POST')// Compueba se ha enviado un $_POST y realiza una cosa u otra en funcion de lo que necesite.
        if(method_exists($objControlador, $_GET['m']))$datos = $objControlador->{$_GET['m']}($_POST);
    else
        if(method_exists($objControlador, $_GET['m']))$datos = $objControlador->{$_GET['m']}();

    if(isset($datos['usuario']))$_SESSION = $datos;

    require_once 'php/vistas/'.$objControlador->vista.'.php';