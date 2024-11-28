<?php
class CUsuarios{
    private $objMUsuario;
    function __construct(){
        require_once 'modelos/mRegistro.php';
        $this->objMRegistro = new MUsuarios();
    }
    public function registrar($datos){
        $datos["password"] = password_hash($datos["password"], PASSWORD_DEFAULT);
        return $this->objMUsuario->registrar($datos);
    }
    public function registrarAdm($datos){
        $dato["password"] = password_hash($datos["password"], PASSWORD_DEFAULT);
        return $this->objMUsuario->registrarAdm($datos);
    }
    public function inicio($datos){
        return $this->objMUsuario->inicio($datos);
    }
    public function inicioAdm($datos){
        return $this->objMUsuario->inicioAdm($datos);
    }
}