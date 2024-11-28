<?php
class MUsuarios{
    private $conexion;
    function __construct(){
        require_once 'config/configDB.php';
        $this->conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD);
        $this->conexion->set_charset('utf8');
    }
    public function registrar($datos){
        

        $sql="INSERT INTO Usuarios(usuario, contrasena) VALUES('".$datos['usuario']."', '".$datos["password"]."');";

        $this->conexion -> query($sql);

        return $this->comprobarRegistro($this->conexion->affected_rows);
    }
    public function registrarAdm($datos){
        //try{
        $sql="INSERT INTO UsuariosAdmin(usuario, contrasena, superAdmin) VALUES('".$datos['usuario']."', '".$datos["password"]."', 0);";

        $this->conexion->query($sql);

        return $this->comprobarRegistro($this->conexion->affected_rows);
        //}catch{}
    }
    private function comprobarRegistro($p){
        if($p = 1)
            return 'Registro correcto';
        else
            return 'Ha sucedido un error';
    }
    public function inicio($datos){
        
    }
    public function inicioAdm($datos){
        
    }
}