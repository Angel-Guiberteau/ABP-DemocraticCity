<?php
require_once 'controladores/cRegistro.php';

$objCUsuario = new CUsuarios();
if(empty($_POST) || empty($_POST["usuario"]) || empty($_POST["password"]))
    echo 'error: Datos incompletos';
else
    echo $objCUsuario->registrarAdm($_POST);