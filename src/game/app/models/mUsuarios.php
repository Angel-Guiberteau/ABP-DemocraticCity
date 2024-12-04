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
            $sql="INSERT INTO Usuarios(nombreUsuario, passUsuario) VALUES('".$datos['usuario']."', '".$datos["passw"]."');";

            $this->conexion -> query($sql);

            return $this->conexion->affected_rows > 0;

        }catch (mysqli_sql_exception $e){
            return false;
        }
    }
    public function registrarAdm($datos){
        try{

            $sql="INSERT INTO Administradores(nombreUsuario, passAdmin, superAdmin) VALUES('".$datos['usuario']."', '".$datos["passw"]."', 0);";

            $this->conexion->query($sql);

            return $this->conexion->affected_rows > 0;

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
            if($this->conexion->affected_rows > 0){
                $fila=$resultado->fetch_assoc();
                if($datos["usuario"] == $fila['nombreUsuario'] && password_verify($datos["passw"], $fila["passUsuario"]))
                    return $fila;
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
            if($this->conexion->affected_rows > 0){
                $fila=$resultado->fetch_assoc();

                if(password_verify($datos["passw"], $fila["passAdmin"])){
                    return $fila;
                }
                else
                    return false;
            }
            
        }catch (mysqli_sql_exception $e){
            return false;
        }
    }
}