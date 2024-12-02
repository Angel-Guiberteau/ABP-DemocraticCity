<?php
class CUsuarios{
    private $objMUsuario;
    public $vista;
    function __construct(){
        require_once 'php/modelos/mUsuarios.php';
        $this->objMRegistro = new MUsuarios();
    }

    public function predeterminada(){
        $this->vista = 'loginUser';
    }
    public function mostrarRegistrar(){
        $this->vista = 'registrarseUser';
    }

    public function registrar($datos){
        if($this->comprobarDatosReg($datos)){
            $datos["passw"] = $this->cifrarPassword($datos["passw"]);
            if ($this->objMUsuario->registrar($datos)){
                $this->vista = 'inicioSesion';
                return true;
            }else{
                $this->vista = 'registro';
                return false;
            }
        }else{
            $this->vista = 'registro';
        }
    }
    public function registrarAdm($datos){
        $this->vista = 'registroAdmin';
        if($this->comprobarDatosReg($datos)){
            $datos["passw"] = $this->cifrarPassword($datos["passw"]);
            return $this->objMUsuario->registrarAdm($datos);
        }else{
            return false;
        }
    }

    public function inicio($datos){
        $this->vista = '';
        if($this->comprobarDatosIni($datos)){
            $datos["passw"] = $this->cifrarPassword($datos["rpassw"]);
            return $this->objMUsuario->inicio($datos);
        }else{
            return false;
        }
    }
    public function inicioAdm($datos){
        $this->vista = '';
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