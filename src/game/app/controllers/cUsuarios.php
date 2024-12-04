<?php
class CUsuarios{
    private $objMUsuario;
    public $vista;
    function __construct(){
        require_once RUTA_MODELOS.'Usuarios.php';
        $this->objMUsuario = new MUsuarios();
    }

    public function predeterminada(){
        $this->vista = 'loginUser';
    }
    public function mostrarRegistrar(){
        $this->vista = 'registrarseUser';
    }
    public function mostrarInicio(){
        $this->vista = 'inicio';
    }

    public function registrar($datos){
        if($this->comprobarDatosReg($datos)){
            $datos["passw"] = $this->cifrarPassword($datos["passw"]);
            if ($this->objMUsuario->registrar($datos)){
                $this->vista = '';
                echo 'correcto';
                return true;
            }else{
                $this->vista = '';
                echo $this->objMUsuario->codError;
                return false;
            }
        }else{
            $this->vista = '';
            echo $this->objMUsuario->codError;
            return false;
        }
    }

    public function inicio($datos){
        if($this->comprobarDatosIni($datos)){
            if($resultado = $this->objMUsuario->inicio($datos)){
                $this->vista = '';
                echo 'correcto';
                return $resultado;
            }else{
                $this->vista = '';
                echo $this->objMUsuario->codError;
                return false;
            }
        }
        echo $this->objMUsuario->codError; 
        return false;
    }

    private function comprobarDatosIni($datos){
        if(empty($datos) || empty($datos["usuario"]) || empty($datos["passw"]))
            return false;
        else
            return true;
    }
    private function comprobarDatosReg($datos){
        if(empty($datos) || empty($datos["usuario"]) || empty($datos["passw"]) || empty($datos["rpassw"]))
            return false;
        else
            if($datos["passw"] != $datos ["rpassw"])
                return false;
            return true;
    }

    public function cerrarSesionUser(){
        session_destroy();
        $this->vista = 'loginUser';
    }

    private function cifrarPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
}