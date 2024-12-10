<?php
class CUsuarios{
    private $objMUsuario;
    public $vista;
    function __construct(){
        require_once RUTA_MODELOS.'Usuarios.php';
        $this->objMUsuario = new MUsuarios();
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
    public function mostrarInicio(){
        $this->vista = 'inicio';
    }
    
    public function registrarAdm($datos){
        
        if($this->comprobarDatosReg($datos)){
            $datos["passw"] = $this->cifrarPassword($datos["passw"]);
            $this->vista = '';
            if($this->objMUsuario->registrarAdm($datos)){
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
            echo 'Los datos introducidos no son correctos';
            return false;
        }
    }
    public function inicioAdm($datos){
        if($this->comprobarDatosIni($datos)){
            // $datos["passw"] = $this->cifrarPassword($datos["passw"]);
            if($resultado = $this->objMUsuario->inicioAdm($datos)){
                if($resultado['superAdmin'] == 1){
                    $this->vista = ''; 
                    echo 'SUPER';
                }
                else{ 
                    echo 'correcto';
                }
                
                return $resultado;
            }else{
                $this->vista = '';
                echo 'Contraseña incorrecta';
                return false;
            }     
        }else{
            $this->vista = '';
            echo 'Error inesperado';
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