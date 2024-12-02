<?php
class CUsuarios{
    private $objMUsuario;
    public $vista;
    function __construct(){
        require_once 'php/modelos/mUsuarios.php';
        $this->objMUsuario = new MUsuarios();
    }

    public function predeterminada(){
        $this->vista = 'loginUser';
    }
    public function mostrarRegistrar(){
        $this->vista = 'registrarseUser';
    }
    public function mostrarAdminRegistro(){
        $this->vista = 'registrarAdmin';
    }
    public function mostrarInicioSesionAdmin(){
        $this->vista = 'loginAdmin';
    }
    public function registrarAdmin(){
        $this->vista = 'registrarAdmin';
    }
    public function mostrarPanel(){
        $this->vista = 'panelAdminGeneral';
    }
    public function mostrarPanelSuper(){
        $this->vista = 'panelAdminSuper';
    }

    public function registrar($datos){
        if($this->comprobarDatosReg($datos)){
            $datos["passw"] = $this->cifrarPassword($datos["passw"]);
            if ($this->objMUsuario->registrar($datos)){
                $this->vista = 'loginUser';
                // json_encode(['status' => 'correcto']);
                return 'correcto';
            }else{
                $this->vista = 'registrarseUser';
                // json_encode(['status' => 'incorrecto']);
                return false;
            }
        }else{
            $this->vista = 'registro';
        }
    }
    public function registrarAdm($datos){
        
        if($this->comprobarDatosReg($datos)){
            $datos["passw"] = $this->cifrarPassword($datos["passw"]);
            $this->vista = 'panelAdminSuper';
            return $this->objMUsuario->registrarAdm($datos);
        }else{
            $this->vista = 'registroAdmin';
            return false;
        }
    }

    public function inicio($datos){
        if($this->comprobarDatosIni($datos)){
            if($resultado = $this->objMUsuario->inicio($datos)){
                $this->vista = 'inicio';
                return $this->objMUsuario->inicio($datos);
            }else{
                $this->vista = 'loginUser';
                return false;
            }
                
            // $datos["passw"] = $this->cifrarPassword($datos["rpassw"]);
        }
    }

    public function inicioAdm($datos){
        if($this->comprobarDatosIni($datos)){
            // $datos["passw"] = $this->cifrarPassword($datos["passw"]);
            if($resultado = $this->objMUsuario->inicioAdm($datos)){
                if($resultado['superAdmin'] == 1){ $this->vista = 'panelAdminSuper'; }
                else{ $this->vista = 'panelAdminGeneral'; }
                    
                return $datos;
            }else{
                $this->vista = 'loginAdmin';
                return false;
            }
                
        }else{
            $this->vista = 'loginAdmin';
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
    public function cerrarSesionAdmin(){
        session_destroy();
        $this->vista = 'loginAdmin';
    }

    private function cifrarPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
}