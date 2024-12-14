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
            $sql = "INSERT INTO Partidas (nombreCiudad, idAnfitrion, vEducacion, vSanidad, vSeguridad, vEconomia, codSala, puntuacion, empezada) VALUES (:nombreCiudad, :idAnfitrion, 5,5,5,5, :codigoSala, 0, 'n')";
        
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

            $sql = "SELECT * FROM Partidas WHERE codSala = :codSala AND empezada = :valor";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':codSala', $datos['codSala'], PDO::PARAM_STR);
            $stmt->bindValue(':valor', 'n', PDO::PARAM_STR);
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
    function mComprobarPartidaEmpezada($datos){
        try{
            $sql = "SELECT * FROM Partidas WHERE idPartida=:idPartida AND empezada = :valor";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idPartida', $datos['idPartida'], PDO::PARAM_INT);
            $stmt->bindValue(':valor', 's', PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0)
                return true;
            else
                return false;
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


    function mEmpezarPartida($datos){
        try{
            $sql = "UPDATE Partidas SET empezada = 's' WHERE idPartida = :idPartida";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idPartida', $datos['idPartida'], PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0)
                return true;
            else
                return false;
        }
        catch(Exception $e){
            error_log("Error al empezar partida: " . $e->getMessage());
            return false;
        }
    }

    function mMostrarPreguntas($datos){

        $this->conexion->beginTransaction();

        try {
            
            $sql = "SELECT * FROM Preguntas WHERE idPregunta NOT IN (SELECT idPregunta FROM Partidas_preguntas WHERE idPartida = :idPartida) ORDER BY RAND() LIMIT 1;";
        
            // Preparar y ejecutar la consulta
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idPartida', $datos['idPartida'], PDO::PARAM_INT);
            $stmt->execute();
            $pregunta = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($pregunta){
                    $sqlRespuestas = "SELECT * FROM Respuestas WHERE idPregunta = :idPregunta;";
                    $stmt2 = $this->conexion->prepare($sqlRespuestas);
                    $stmt2->bindValue(':idPregunta', $pregunta['idPregunta'], PDO::PARAM_INT);
                    $stmt2->execute();
                    $respuestas = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            }
            
            if ($respuestas) {

                $sql2 = "INSERT INTO Partidas_preguntas (idPartida, idPregunta) VALUES (:idPartida, :idPregunta);";
                $stmt3 = $this->conexion->prepare($sql2);
                $stmt3->bindValue(':idPartida', $datos['idPartida'], PDO::PARAM_INT);
                $stmt3->bindValue(':idPregunta', $pregunta['idPregunta'], PDO::PARAM_INT);
                $stmt3->execute();
        
                // Confirmar la transacción
                $this->conexion->commit();
                
                $resultado = [
                    "idPregunta" => $pregunta['idPregunta'],
                    "pregunta" => $pregunta["texto"],
                    "respuestas" => []
                ];

                foreach ($respuestas as $respuesta) {
                    $resultado["respuestas"][] = [
                        "letra" => $respuesta["letraRespuesta"],
                        "texto" => $respuesta["respuesta"],
                        "educacion" => $respuesta["educacion"],
                        "sanidad" => $respuesta["sanidad"],
                        "seguridad" => $respuesta["seguridad"],
                        "economia" => $respuesta["economia"],
                        "idEdificio" => $respuesta["idEdificio"]
                    ];
                }

                return $resultado; // Devuelve la pregunta con sus respuestas
                
            } else {
                // No hay preguntas disponibles, revertir transacción
                $this->conexion->rollBack();
                return false; // Indica que no hay preguntas disponibles
            }
        } catch (Exception $e) {
            error_log("ERROR JODERa: " . $e->getMessage());
            // Revertir la transacción en caso de error
            $this->conexion->rollBack();
            throw new Exception("Error al realizar la consulta: " . $e->getMessage());
        }
        
    }

    function mMostrarPreguntasUsuario($datos){

        $this->conexion->beginTransaction();

        try{

            $sql = "SELECT idPregunta FROM Partidas_preguntas WHERE idPartida = :idPartida ORDER BY lastAdded DESC LIMIT 1;";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idPartida', $datos['idPartida'], PDO::PARAM_INT);
            $stmt->execute();
            $idPregunta = $stmt->fetch(PDO::FETCH_ASSOC);

            if($idPregunta)
            {
                $sql2 = "SELECT * FROM Preguntas
                        WHERE Preguntas.idPregunta = :idPregunta;";
                $stmt2 = $this->conexion->prepare($sql2);
                $stmt2->bindValue(':idPregunta', $idPregunta['idPregunta'], PDO::PARAM_INT);
                $stmt2->execute();
                $pregunta = $stmt2->fetch(PDO::FETCH_ASSOC);
            }

            if($pregunta)
            {

                $sql3 = "SELECT * FROM Respuestas WHERE idPregunta = :idPregunta;";
                $stmt3 = $this->conexion->prepare($sql3);
                $stmt3->bindValue(':idPregunta', $idPregunta['idPregunta'], PDO::PARAM_INT);
                $stmt3->execute();
                $respuestas = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                

                $resultado = [
                    "idPregunta" => $pregunta["idPregunta"], 
                    "pregunta" => $pregunta["texto"], 
                    "respuestas" => []
                ];
    
                foreach ($respuestas as $respuesta) {
                    $resultado["respuestas"][] = [
                        "letra" => $respuesta["letraRespuesta"],
                        "texto" => $respuesta["respuesta"],
                        "educacion" => $respuesta["educacion"],
                        "sanidad" => $respuesta["sanidad"],
                        "seguridad" => $respuesta["seguridad"],
                        "economia" => $respuesta["economia"],
                        "idEdificio" => $respuesta["idEdificio"]
                    ];
                }
            }
        
            $this->conexion->commit();

            return $resultado; // Devuelve la pregunta con sus respuestas


        } catch (Exception $e) {
            error_log("ERROR JODERa: " . $e->getMessage());
            // Revertir la transacción en caso de error
            $this->conexion->rollBack();
            throw new Exception("Error al realizar la consulta: " . $e->getMessage());
            
        }


    }

    function mCalcularJugadores($datos){

        try{

            $sql = "SELECT COUNT(idPartida) AS numJugadores FROM Usuarios_partidas WHERE idPartida = :idPartida;";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idPartida', $datos['idPartida'], PDO::PARAM_INT);
            $stmt->execute();

            $numJugadores = $stmt->fetch(PDO::FETCH_ASSOC);
            return $numJugadores['numJugadores'];
        }
        catch(Exception $e){
            error_log("Error al enviar voto: " . $e->getMessage());
            return false;
        }

    }
    function mPreguntaMasVotada($idPregunta, $letraMasVotada){

        try{

            $sql = "SELECT respuesta FROM Respuestas WHERE idPregunta = :idPregunta AND letraRespuesta = :letraRespuesta;";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idPregunta', $idPregunta, PDO::PARAM_INT);
            $stmt->bindValue(':letraRespuesta', $letraMasVotada, PDO::PARAM_STR);
            $stmt->execute();

            $texto = $stmt->fetch(PDO::FETCH_ASSOC);
            return $texto['respuesta'];
        }
        catch(Exception $e){
            error_log("Error al enviar voto: " . $e->getMessage());
            return false;
        }

    }
    function mValoresRespuesta($idPregunta, $letraRespuesta){

        try{

            $sql = "SELECT educacion, sanidad, seguridad, economia FROM Respuestas WHERE idPregunta = :idPregunta AND letraRespuesta = :letraRespuesta;";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':idPregunta', $idPregunta, PDO::PARAM_INT);
            $stmt->bindValue(':letraRespuesta', $letraRespuesta, PDO::PARAM_STR);
            $stmt->execute();

            $valores = $stmt->fetch(PDO::FETCH_ASSOC);
            return $valores;
        }
        catch(Exception $e){
            error_log("Error al enviar voto: " . $e->getMessage());
            return false;
        }

    }

    function mActualizarFinalPartida($datos){

        try{
         
            $sql = "UPDATE Partidas SET vEducacion = :educacion, vSanidad = :sanidad, vSeguridad = :seguridad, vEconomia = :economia WHERE idPartida = :idPartida;";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':educacion', $datos['educacion'], PDO::PARAM_INT);
            $stmt->bindValue(':sanidad', $datos['sanidad'], PDO::PARAM_INT);
            $stmt->bindValue(':seguridad', $datos['seguridad'], PDO::PARAM_INT);
            $stmt->bindValue(':economia', $datos['economia'], PDO::PARAM_INT);
            $stmt->bindValue(':idPartida', $datos['idPartida'], PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0)
                return true;
            else
                return false;


        }catch(Exception $e){
            error_log("Error al actualizar medidores: " . $e->getMessage());
            return false;
        }

    }
}