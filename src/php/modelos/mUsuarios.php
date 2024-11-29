<?php
class MUsuarios{
    private $conexion;
    function __construct(){
        $objConexion = new Db();
        $this->conexion= $objConexion->conexion;
    }
    // registro de usuarios
    public function registrar($datos){
        

        $sql="INSERT INTO Usuarios(usuario, contrasena) VALUES('".$datos['usuario']."', '".$datos["password"]."');";

        $this->conexion -> query($sql);

        return $this->comprobar($this->conexion->affected_rows);
    }
    public function registrarAdm($datos){
        try{
            $sql="INSERT INTO UsuariosAdmin(usuario, contrasena, superAdmin) VALUES('".$datos['usuario']."', '".$datos["password"]."', 0);";

            $this->conexion->query($sql);

            return $this->comprobar($this->conexion->affected_rows);
        }catch (mysqli_sql_exception $e){
            return 'Error en el registro';
        }
    }
    //inicio de sesion
    public function inicio($datos){
        $sql='select * from Usuarios where usuario = "'.$_POST["usuario"].'";';
        $this->conexion->query($sql);
        $this->comprobar($this->conexion->affected_rows);
    }
    public function inicioAdm($datos){
        $sql='select * from Usuarios where usuario = "'.$_POST["usuario"].'" AND superAdmin = 0;';
        $this->conexion->query($sql);
        $this->comprobar($this->conexion->affected_rows);
    }

    private function comprobar($p){
        if($p = 1)
            return 'Registro correcto';
        else
            return 'Ha sucedido un error';
    }
}