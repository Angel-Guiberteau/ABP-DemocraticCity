<?php
class MUsuarios{
    private $conexion;
    function __construct(){
        require_once 'db.php';
        $objConexion = new Db();
        $this->conexion= $objConexion->conexion;
    }
    // registro de usuarios
    public function registrar($datos){
        try{
            $sql="INSERT INTO Usuarios(nombreUsuario, passw) VALUES('".$datos['usuario']."', '".$datos["password"]."');";

            $this->conexion -> query($sql);

            return $this->comprobar($this->conexion->affected_rows);

        }catch (mysqli_sql_exception $e){
            return false;
        }
    }
    public function registrarAdm($datos){
        try{

            $sql="INSERT INTO Administradores(nombreUsuario, passwAdmin, superAdmin) VALUES('".$datos['usuario']."', '".$datos["password"]."', 0);";

            $this->conexion->query($sql);

            return $this->comprobar($this->conexion->affected_rows);

        }catch (mysqli_sql_exception $e){
            return false;
        }
    }
    //inicio de sesion
    public function inicio($datos){
        try{
            $sql='SELECT * from Usuarios where nombreUsuario = "'.$datos["usuario"].'";';
            $resultado = $this->conexion->query($sql);
            $datos["passw"] = mysqli_real_escape_string($this->conexion, $datos["passw"]);
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
            $sql='SELECT * from Administradores where nombreUsuario = "'.$datos["usuario"].'";';
            $resultado = $this->conexion->query($sql);
            $datos["passw"] = mysqli_real_escape_string($this->conexion, $datos["passw"]);
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