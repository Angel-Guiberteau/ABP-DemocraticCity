<?php
/**
 * Esta clase permite la total funcionalidad de todos los procesos de los usuarios y administradores, sea inicio de sesión o registro.
 */
class MUsuarios{
    private $conexion;
    public $codError;
    function __construct(){
        require_once 'db.php';
        $objConexion = new Db();
        $this->conexion= $objConexion->conexion;
    }
    /**
     * Método que permite registrar nuevos Admin (Solo puede hacerlo un SUPERAdmin)
     * @param
     */
    public function registrarAdm($datos){
        try{

            $sql="INSERT INTO Administradores(nombreUsuario, passAdmin, superAdmin) VALUES(:usuario, :passw, :super);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':usuario', $datos['usuario'], PDO::PARAM_STR);
            $stmt->bindValue(':passw', $datos['passw'], PDO::PARAM_STR);
            $stmt->bindValue(':super', '0' , PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->rowCount() > 0;

        }catch (PDOException $e) {
            if($e->errorInfo[1] == 1062)
                $this->codError = "1062";
            else
                $this->codError = "9998";
            
            return false;
        }
    }
    
    /**
     * Método que permite e inicio de sesión de los usuarios.
     * @param
     * @return
     */
    public function inicio($datos){
        try{

            $sql='SELECT * from Usuarios where nombreUsuario = :usuario;';

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':usuario', $datos['usuario'], PDO::PARAM_STR);

            $stmt->execute();
            if($stmt->rowCount() > 0){
                $fila = $stmt->fetch(PDO::FETCH_ASSOC);
                if($datos["usuario"] == $fila['nombreUsuario'] && password_verify($datos["passw"], $fila["passUsuario"])){
                    return $fila;
                    $this->codError = 'correcto';
                } else{
                    $this->codError = 'PasswIncorrecto';
                    return false;
                }
                    
            }
                
            

        }catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }
    /**
     * Método que permite el inicio de sesión de los administradores ya sean generales o SUPER.
     * @param
     * @return
     */
    public function inicioAdm($datos){
            
        try{

            $sql='SELECT * from Administradores where nombreUsuario = :usuario;';

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':usuario', $datos['usuario'], PDO::PARAM_STR);

            $stmt->execute();
            if($stmt->rowCount() > 0){
                $fila = $stmt->fetch(PDO::FETCH_ASSOC);
                if($datos["usuario"] == $fila['nombreUsuario'] && password_verify($datos["passw"], $fila["passAdmin"]))
                    return $fila;
                else
                    return false;
            }
                
            

        }catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }
}