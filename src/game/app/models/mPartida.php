<?php
/**
 * Esta clase permite la total funcionalidad de todos los procesos de los usuarios y administradores, sea inicio de sesión o registro.
 */
class MPartida{
    public $codError;
    private $conexion;
    function __construct(){
        require_once 'db.php';
        $objConexion = new Db();
        $this->conexion= $objConexion->conexion;
    }
    public function mCrearSala($datos){
        try{
            $sql = "INSERT INTO Partidas (nombreCiudad, idAnfitrion, vEducacion, vSanidad, vSeguridad, vEconomia, codSala, puntuacion) VALUES (:nombreCiudad, :idAnfitrion, 5,5,5,5, :codigoSala, 0)";
        
            $stmt = $this->conexion->prepare($sql);
    
            $stmt->bindValue(':nombreCiudad', $datos['nombreCiudad'], PDO::PARAM_STR);
            $stmt->bindValue(':idAnfitrion', $datos['idAnfitrion'], PDO::PARAM_INT);
            $stmt->bindValue(':codigoSala', $datos['codSala'], PDO::PARAM_STR);
            
            $stmt->execute();
            return true;
        }catch(Exception $e){
            return false;
        }
        

    }
    public function mEliminarSala($datos){
        try{
            $sql = "DELETE FROM Partidas WHERE codSala = :codSala AND idAnfitrion = :idAnfitrion";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':codSala', $datos['codSala'], PDO::PARAM_STR);
            $stmt->bindValue(':idAnfitrion', $datos['idAnfitrion'], PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;

        }catch(Exception $e){
            error_log("Error al eliminar sala: " . $e->getMessage());
            
            return false;
        }

    }
    
}