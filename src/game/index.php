<?php
    require_once 'app/config/config.php';

    session_start();

    //   Asignamos automaticamente el metodo y controlador por defecto si no le pasas ninguno.
    if(!isset($_GET['c']))$_GET['c'] = CONTROLADOR_USUARIO;
    
    if(!isset($_GET['m'])){$_GET['m'] = METODO_PREDETERMINADO;} // sin metodo por defecto.

    //Concatenamos para la ruta del controlador e incluirlo despues
    $rutaControlador = RUTA_CONTROLADORES . $_GET['c'] . '.php';
    require_once $rutaControlador;

    //Creamos el objeto del controlador.
    $controlador = 'C'.$_GET['c'];
    $objControlador = new $controlador();

    $datos = [];
    
    // if($_SERVER['REQUEST_METHOD']==='POST')// Compueba se ha enviado un $_POST y realiza una cosa u otra en funcion de lo que necesite.
    //     if(method_exists($objControlador, $_GET['m']))$datos = $objControlador->{$_GET['m']}($_POST);
    // else
    if(method_exists($objControlador, $_GET['m'])){
        $datos = $objControlador->{$_GET['m']}($_POST);
    }

    if(isset($datos['idUsuario'])){
        $_SESSION['idUsuario']= $datos['idUsuario'];
        $_SESSION['nombreUsuario']= $datos['nombreUsuario'];
    }
    if(isset($datos['codSala'])){
        $_SESSION['idPartida']= $datos['idPartida'];
        $_SESSION['codSala']= $datos['codSala'];
        $_SESSION['idAnfitrion']= $datos['idAnfitrion'];
        $_SESSION['nombreCiudad']= $datos['nombreCiudad'];
        $_SESSION['vEducacion']= $datos['vEducacion'];
        $_SESSION['vSanidad']= $datos['vSanidad'];
        $_SESSION['vSeguridad']= $datos['vSeguridad'];
        $_SESSION['vEconomia']= $datos['vEconomia'];
        $_SESSION['puntuacion']= $datos['puntuacion'];
    }
    
    if($objControlador->vista != '')
        require_once RUTA_VISTAS.$objControlador->vista.'.php';