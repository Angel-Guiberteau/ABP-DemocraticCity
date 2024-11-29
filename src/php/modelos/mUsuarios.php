<?php
class MUsuarios{
    private $conexion;
    function __construct(){
        $objConexion = new Db();
        $this->conexion= $objConexion->conexion;
    }
    // registro de usuarios
    public function registrar($datos){
        try{
            $sql="INSERT INTO Usuarios(usuario, contrasena) VALUES('".$datos['usuario']."', '".$datos["password"]."');";

            $this->conexion -> query($sql);

            return $this->comprobar($this->conexion->affected_rows);

        }catch (mysqli_sql_exception $e){
            return false;
        }
    }
    public function registrarAdm($datos){
        try{
            $sql="INSERT INTO UsuariosAdmin(usuario, contrasena, superAdmin) VALUES('".$datos['usuario']."', '".$datos["password"]."', 0);";

            $this->conexion->query($sql);

            return $this->comprobar($this->conexion->affected_rows);

        }catch (mysqli_sql_exception $e){
            return false;
        }
    }
    //inicio de sesion
    public function inicio($datos){
        try{
            $sql='select * from Usuarios where usuario = "'.$datos["usuario"].'";';
            $resultado = $this->conexion->query($sql);

            if($this->comprobar($this->conexion->affected_rows)){
                $fila=$resultado->fetch_assoc();
                if($datos["usuario"] == $fila['usuario'] && password_verify($datos["passw"], $fila["passw"]))
                    return $resultado;
                else
                    return false;
            }
            
        }catch (mysqli_sql_exception $e){
            return false;
        }
    }
    public function inicioAdm($datos){
        try{
            $sql='select * from Usuarios where usuario = "'.$datos["usuario"].'";';
            $resultado = $this->conexion->query($sql);

            if($this->comprobar($this->conexion->affected_rows)){
                $fila=$resultado->fetch_assoc();
                if($datos["usuario"] == $fila['usuario'] && password_verify($datos["passw"], $fila["passw"]))
                    return $resultado;
                else
                    return false;
            }
            
        }catch (mysqli_sql_exception $e){
            return false;
        }
    }

    private function comprobar($p){
        if($p = 1)
            return true;
        else
            return false;
    }
}