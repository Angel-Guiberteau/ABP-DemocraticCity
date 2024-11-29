<?php
class CUsuarios{
    private $objMUsuario;
    public $vista;
    function __construct(){
        require_once 'modelos/mRegistro.php';
        $this->objMRegistro = new MUsuarios();
        $this->vista = VISTA_INICIAL;
    }

    public function registrar($datos){
        if($this->comprobarDatosReg($datos)){
            $datos["passw"] = $this->cifrarPassword($datos["passw"]);
            return $this->objMUsuario->registrar($datos);
        }else{
            $this->vista = VISTA_REGISTRO;
        }
    }
    public function registrarAdm($datos){
        $this->vista = VISTA_REGISTRO_ADMIN;
        if($this->comprobarDatosReg($datos)){
            $datos["passw"] = $this->cifrarPassword($datos["passw"]);
            return $this->objMUsuario->registrarAdm($datos);
        }else{
            return false;
        }
    }

    public function inicio($datos){
        if($this->comprobarDatosIni($datos)){
            $datos["passw"] = $this->cifrarPassword($datos["rpassw"]);
            return $this->objMUsuario->inicio($datos);
        }else{
            return false;
        }
    }
    public function inicioAdm($datos){
        if($this->comprobarDatosIni($datos)){
            $datos["passw"] = $this->cifrarPassword($datos["rpassw"]);
            return $this->objMUsuario->inicioAdm($datos);
        }else{
            return false;
        }
    }

    private function comprobarDatosIni($datos){
        if(empty($datos) || empty($datos["usuario"]) || empty($datos["passw"]))
            return false;
        else
            return true;
    }
    private function comprobarDatosReg($datos){
        if(empty($datos) || empty($datos["usuario"]) || empty($datos["rpassw"]) || empty($datos["rpassw"]))
            return false;
        else
            if($datos["passw"] != $datos ["rpassw"])
                return false;
            return true;
    }

    private function cifrarPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
}