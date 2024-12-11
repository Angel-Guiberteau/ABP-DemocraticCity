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
            $this->conexion->beginTransaction();
            $sql = "INSERT INTO Partidas (nombreCiudad, idAnfitrion, vEducacion, vSanidad, vSeguridad, vEconomia, codSala, puntuacion) VALUES (:nombreCiudad, :idAnfitrion, 5,5,5,5, :codigoSala, 0)";
        
            $stmtInsert = $this->conexion->prepare($sql);
    
            $stmtInsert->bindValue(':nombreCiudad', $datos['nombreCiudad'], PDO::PARAM_STR);
            $stmtInsert->bindValue(':idAnfitrion', $datos['idAnfitrion'], PDO::PARAM_INT);
            $stmtInsert->bindValue(':codigoSala', $datos['codSala'], PDO::PARAM_STR);
            
            $stmtInsert->execute();

            $sql2 = "SELECT * FROM Partidas WHERE nombreCiudad = :nombreCiudad AND idAnfitrion = :idAnfitrion AND codSala = :codigoSala";

            $stmtSelect = $this->conexion->prepare($sql2);

            $stmtSelect->bindValue(':nombreCiudad', $datos['nombreCiudad'], PDO::PARAM_STR);
            $stmtSelect->bindValue(':idAnfitrion', $datos['idAnfitrion'], PDO::PARAM_INT);
            $stmtSelect->bindValue(':codigoSala', $datos['codSala'], PDO::PARAM_STR);
            
            $stmtSelect->execute();

            $this->conexion->commit();

            return $stmtSelect->fetch(PDO::FETCH_ASSOC);


        }catch(Exception $e){
            error_log($e->getMessage());
            $this->conexion->rollBack();
            return false;
        }
    }
    public function mEliminarSala($datos){
        try{
            $sql = "DELETE FROM Partidas WHERE idPartida = :idPartida";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idPartida', $datos['idPartida'], PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount() > 0;

        }catch(Exception $e){
            error_log("Error al eliminar sala: " . $e->getMessage());
            return false;
        }
    }

    public function mUnirseSala($datos){
        
        try{
            $this->conexion->beginTransaction();

            $sql = "SELECT * FROM Partidas WHERE codSala = :codSala";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':codSala', $datos['codSala'], PDO::PARAM_STR);
            $stmt->execute();

            $datosPartidas = $stmt->fetch(PDO::FETCH_ASSOC);

            if($datosPartidas){
                
                $sql2 = "INSERT INTO Usuarios_partidas (idUsuario, idPartida) VALUES (:idUsuario, :idPartida)";
                $stmt2 = $this->conexion->prepare($sql2);
                $stmt2->bindValue(':idUsuario', $datos['idUsuario'], PDO::PARAM_INT);
                $stmt2->bindValue(':idPartida', $datosPartidas['idPartida'], PDO::PARAM_INT);
                $stmt2->execute();
                $this->conexion->commit();
                
            }
            else
                return false;
            

            return $datosPartidas;
        }
        catch(Exception $e){
            $this->conexion->rollBack();
            error_log("Error al unirse a la sala: " . $e->getMessage());
            return false;
        }
    }

    function mMostrarJugadores($datos){
        try{
            
            $sql = "SELECT Usuarios.nombreUsuario FROM Partidas
            INNER JOIN Usuarios_partidas ON Partidas.idPartida = Usuarios_partidas.idPartida
            INNER JOIN Usuarios ON Usuarios_partidas.idUsuario = Usuarios.idUsuario
            WHERE Partidas.idPartida = :idPartida";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idPartida', $datos['idPartida'], PDO::PARAM_INT);
            $stmt->execute();

            $array = [];

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $array[] = $row['nombreUsuario'];
            } 
            return $array;

        }
        catch(Exception $e){
            error_log("Error al mostrar jugadores: " . $e->getMessage());
            return false;
        }
    }

    function mComprobarPartidaEliminada($datos){
        try{
            $sql = "SELECT * FROM Usuarios_partidas WHERE idPartida = :idPartida AND idUsuario = :idUsuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idPartida', $datos['idPartida'], PDO::PARAM_INT);
            $stmt->bindValue(':idUsuario', $datos['idUsuario'], PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() < 1;
        }
        catch(Exception $e){
            error_log("Error al comprobar partida eliminada: " . $e->getMessage());
            return false;
        }
    }

    function mEliminarUsuarioPartida($datos){
        try{
            $sql = "DELETE FROM Usuarios_partidas WHERE idUsuario = :idUsuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idUsuario', $datos['idUsuario'], PDO::PARAM_INT);
            $stmt->execute();
            
            return true;
        }
        catch(Exception $e){
            error_log("Error al eliminar usuario de la partida: " . $e->getMessage());
            return false;
        }
    }
    
}