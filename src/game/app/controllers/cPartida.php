<?php
class CPartida{
    private $objMUsuario;
    public $vista;
    function __construct(){
        require_once RUTA_MODELOS.'Usuarios.php';
        $this->objMUsuario = new MUsuarios();
    }

    public function mostrarSala(){
        $this->vista = 'salaAnfitrion';
    }


}