<?php
/**
 * Esta clase permite la total funcionalidad de la gestión de preguntas.
 */
class MPreguntas{
    private $conexion;
    public $codError;
    function __construct(){
        require_once 'db.php';
        $objConexion = new Db();
        $this->conexion= $objConexion->conexion;
    }
    /**
     * Método que permite mostrar las preguntas y respuestas.
     * @param
     * @return
     */
    public function mMostrarPreguntasyRespuestas(){
        try{

            $sql='SELECT * from Preguntas INNER JOIN Respuestas
            ON Preguntas.idPregunta = Respuestas.idPregunta;';

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $datos = [];
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $idPregunta = $fila['idPregunta'];
                    
                    if (!isset($datos[$idPregunta])) {
                        $datos[$idPregunta] = [
                            'idPregunta' => $idPregunta,
                            'texto' => $fila['texto'],
                            'respuestas' => []
                        ];
                    }
    
                    $datos[$idPregunta]['respuestas'][] = [
                        'letraRespuesta' => $fila['letraRespuesta'],
                        'educacion' => $fila['educacion'],
                        'sanidad' => $fila['sanidad'],
                        'seguridad' => $fila['seguridad'],
                        'economia' => $fila['economia'],
                        'idEdificio' => $fila['idEdificio'],
                        'respuesta' => $fila['respuesta']
                    ];
                }
    
                return $datos; 
            }else{
                return false;
            }
        }catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }

    public function mAniadirPreguntas($datos){
        try{
            $this->conexion->beginTransaction();
    
            // Primero, insertar el multimedia para la pregunta
            $idMultimediaPregunta = 0;
    
            if (isset($datos['imagenPregunta'])) {
                // Validar tipo de archivo para la pregunta (solo JPG y PNG)
                $tipoArchivoPregunta = strtolower(pathinfo($datos['imagenPregunta']['name'], PATHINFO_EXTENSION));

                if (!in_array($tipoArchivoPregunta, ['jpg', 'jpeg', 'png'])) {
                    throw new Exception("El archivo de la pregunta debe ser PNG o JPG.");
                }
    
                // Generar un nombre único para la multimedia de la pregunta
                $nombrePregunta = pathinfo($datos['imagenPregunta']['name'], PATHINFO_FILENAME);
                $nombreMultimedia = $nombrePregunta . "_" . uniqid() . "." . $tipoArchivoPregunta;
    
                // Definir rutas
                $rutaPregunta1 = "img/edificios/" . $nombreMultimedia;
                $rutaPregunta2 = "../game/img/edificios/" . $nombreMultimedia;
    
                // Mover archivo a las dos carpetas
                move_uploaded_file($datos['imagenPregunta']['tmp_name'], $rutaPregunta2);

                move_uploaded_file($datos['imagenPregunta']['tmp_name'], $rutaPregunta1);
                
    
                // Insertar en la tabla Multimedia
                $sqlMultimediaPregunta = "INSERT INTO Multimedia (nombreMultimedia, ruta, tipo) VALUES (:nombre, :ruta, 'P')";
                $stmtMultimediaPregunta = $this->conexion->prepare($sqlMultimediaPregunta);
                // $hash = hash_file('md5', $nombreMultimedia);
                $stmtMultimediaPregunta->bindValue(':nombre', $nombreMultimedia, PDO::PARAM_STR);
                $stmtMultimediaPregunta->bindValue(':ruta', $rutaPregunta1, PDO::PARAM_STR);
                // $stmtMultimediaPregunta->bindValue(':hasheo', $hash, PDO::PARAM_STR);
                $stmtMultimediaPregunta->execute();
    
                $idMultimediaPregunta = $this->conexion->lastInsertId();
            }
    
            // Insertar la pregunta con su multimedia
            $sqlPregunta = "INSERT INTO Preguntas (texto, idMultimedia) VALUES (:pregunta, :idMultimedia)";
            $stmtPregunta = $this->conexion->prepare($sqlPregunta);
            $stmtPregunta->bindValue(':pregunta', $datos['pregunta'], PDO::PARAM_STR);
            $stmtPregunta->bindValue(':idMultimedia', $idMultimediaPregunta, PDO::PARAM_INT);
            $stmtPregunta->execute();
    
            $idPregunta = $this->conexion->lastInsertId();
    
            // Insertar las respuestas y asociar multimedia a cada respuesta
            $sqlRespuestas = "INSERT INTO Respuestas (idPregunta, letraRespuesta, respuesta, educacion, sanidad, seguridad, economia, idEdificio) 
                              VALUES (:idPregunta, :letraRespuesta, :respuesta, :educacion, :sanidad, :seguridad, :economia, :idEdificio)";
            $stmtRespuesta = $this->conexion->prepare($sqlRespuestas);
    
            $respuestas = [
                ['letra' => 'a', 'respuesta' => $datos['respuesta1'], 'educacion' => $datos['educacion1'], 'sanidad' => $datos['sanidad1'], 'seguridad' => $datos['seguridad1'], 'economia' => $datos['economia1'], 'imagen' => $datos['respuesta1file']],
                ['letra' => 'b', 'respuesta' => $datos['respuesta2'], 'educacion' => $datos['educacion2'], 'sanidad' => $datos['sanidad2'], 'seguridad' => $datos['seguridad2'], 'economia' => $datos['economia2'], 'imagen' => $datos['respuesta2file']],
                ['letra' => 'c', 'respuesta' => $datos['respuesta3'], 'educacion' => $datos['educacion3'], 'sanidad' => $datos['sanidad3'], 'seguridad' => $datos['seguridad3'], 'economia' => $datos['economia3'], 'imagen' => $datos['respuesta3file']],
                ['letra' => 'd', 'respuesta' => $datos['respuesta4'], 'educacion' => $datos['educacion4'], 'sanidad' => $datos['sanidad4'], 'seguridad' => $datos['seguridad4'], 'economia' => $datos['economia4'], 'imagen' => $datos['respuesta4file']],
            ];
    
            foreach($respuestas as $respuesta){
                $idMultimediaRespuesta = null;
    
                if (isset($respuesta['imagen']) && $respuesta['imagen']['tmp_name']) {
                    // Validar tipo de archivo para la respuesta (solo JPG y PNG)
                    $tipoArchivoRespuesta = strtolower(pathinfo($respuesta['imagen']['name'], PATHINFO_EXTENSION));
                    if (!in_array($tipoArchivoRespuesta, ['jpg', 'jpeg', 'png'])) {
                        throw new Exception("El archivo de la respuesta debe ser PNG o JPG.");
                    }
    
                    // Generar un nombre único para la multimedia de la respuesta
                    $nombreRespuesta = pathinfo($respuesta['imagen']['name'], PATHINFO_FILENAME);
                    $nombreMultimediaRespuesta = $nombreRespuesta . "_" . uniqid() . "." . $tipoArchivoRespuesta;
    
                    // Definir rutas
                    $rutaRespuesta1 = "img/edificios/" . $nombreMultimediaRespuesta;
                    $rutaRespuesta2 = "../game/img/edificios/" . $nombreMultimediaRespuesta;
    
                    // Mover archivo a las dos carpetas
                    move_uploaded_file($respuesta['imagen']['tmp_name'], $rutaRespuesta1);
                    move_uploaded_file($respuesta['imagen']['tmp_name'], $rutaRespuesta2);
    
                    // Insertar en la tabla Multimedia para respuesta
                    $sqlMultimediaRespuesta = "INSERT INTO Multimedia (nombreMultimedia, ruta, tipo) VALUES (:nombre, :ruta, 'E')";
                    $stmtMultimediaRespuesta = $this->conexion->prepare($sqlMultimediaRespuesta);
                    // $hashRespuesta = hash_file('md5', $nombreMultimediaRespuesta);
                    $stmtMultimediaRespuesta->bindValue(':nombre', $nombreMultimediaRespuesta, PDO::PARAM_STR);
                    $stmtMultimediaRespuesta->bindValue(':ruta', $rutaRespuesta1, PDO::PARAM_STR);
                    // $stmtMultimediaRespuesta->bindValue(':hasheo', $hashRespuesta, PDO::PARAM_STR);
                    $stmtMultimediaRespuesta->execute();
    
                    $idMultimediaRespuesta = $this->conexion->lastInsertId();

                    $sqlEdificio = "INSERT INTO Edificios (nombreEdificio, idMultimedia) VALUES (:nombreEdificio, :idMultimedia)";

                    $stmtEdificio = $this->conexion->prepare($sqlEdificio);
                    $stmtEdificio->bindValue(':nombreEdificio', $nombreMultimediaRespuesta, PDO::PARAM_STR);
                    $stmtEdificio->bindValue(':idMultimedia', $idMultimediaRespuesta, PDO::PARAM_INT);
                    $stmtEdificio->execute();

                    $idEdificio = $this->conexion->lastInsertId();

                }
    
                // Inserta la respuesta con su multimedia asociado
                $stmtRespuesta->bindValue(':idPregunta', $idPregunta, PDO::PARAM_INT);
                $stmtRespuesta->bindValue(':letraRespuesta', $respuesta['letra'], PDO::PARAM_STR);
                $stmtRespuesta->bindValue(':respuesta', $respuesta['respuesta'], PDO::PARAM_STR);
                $stmtRespuesta->bindValue(':educacion', $respuesta['educacion'], PDO::PARAM_INT);
                $stmtRespuesta->bindValue(':sanidad', $respuesta['sanidad'], PDO::PARAM_INT);
                $stmtRespuesta->bindValue(':seguridad', $respuesta['seguridad'], PDO::PARAM_INT);
                $stmtRespuesta->bindValue(':economia', $respuesta['economia'], PDO::PARAM_INT);
                $stmtRespuesta->bindValue(':idEdificio', $idEdificio, PDO::PARAM_INT);
                $stmtRespuesta->execute();
            }
    
            $this->conexion->commit();
            return true;
    
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            $this->conexion->rollBack();
            error_log("Formato de la imagen no valido" . $e->getMessage());
            return false;
        }
    }
    
    
    public function mModificarPregunta($idPregunta){
        try{
            $sql='SELECT * from Preguntas INNER JOIN Respuestas
                ON Preguntas.idPregunta = Respuestas.idPregunta WHERE Preguntas.idPregunta = :idPregunta;';

                $stmt = $this->conexion->prepare($sql);
                $stmt->bindValue(':idPregunta', $idPregunta, PDO::PARAM_INT);

                $stmt->execute();
                if($stmt->rowCount() > 0){
                    $datos = [];
                    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        if (!isset($datos['idPregunta'])) {
                            $datos = [
                                'idPregunta' => $fila['idPregunta'],
                                'texto' => $fila['texto'], // Asegúrate de que este campo exista en tu tabla Preguntas
                                'respuestas' => []
                            ];
                        }
            
                        // Añadimos cada respuesta al array de respuestas
                        $datos['respuestas'][] = [
                            'letraRespuesta' => $fila['letraRespuesta'],
                            'educacion' => $fila['educacion'],
                            'sanidad' => $fila['sanidad'],
                            'seguridad' => $fila['seguridad'],
                            'economia' => $fila['economia'],
                            'idEdificio' => $fila['idEdificio'],
                            'respuesta' => $fila['respuesta']
                        ];
                    }
                    return $datos; 
                }else{
                    return false;
                }
        }catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }
    public function mGuardarModificacionPregunta($datos){
        try {
            $this->conexion->beginTransaction();
    
            $sqlPregunta = "UPDATE Preguntas SET texto = :texto WHERE idPregunta = :idPregunta";
            $stmtPregunta = $this->conexion->prepare($sqlPregunta);
            $stmtPregunta->bindValue(':texto', $datos['pregunta'], PDO::PARAM_STR);
            $stmtPregunta->bindValue(':idPregunta', $datos['idPregunta'], PDO::PARAM_INT);
            $stmtPregunta->execute();
    
            $sqlRespuestas = "UPDATE Respuestas 
                SET respuesta = :respuesta, educacion = :educacion, sanidad = :sanidad, 
                    seguridad = :seguridad, economia = :economia 
                WHERE idPregunta = :idPregunta AND letraRespuesta = :letraRespuesta";
    
            $stmtRespuestas = $this->conexion->prepare($sqlRespuestas);
    
            $respuestas = [
                ['letra' => 'a', 'respuesta' => $datos['respuesta1'], 'educacion' => $datos['educacion1'], 'sanidad' => $datos['sanidad1'], 'seguridad' => $datos['seguridad1'], 'economia' => $datos['economia1']],
                ['letra' => 'b', 'respuesta' => $datos['respuesta2'], 'educacion' => $datos['educacion2'], 'sanidad' => $datos['sanidad2'], 'seguridad' => $datos['seguridad2'], 'economia' => $datos['economia2']],
                ['letra' => 'c', 'respuesta' => $datos['respuesta3'], 'educacion' => $datos['educacion3'], 'sanidad' => $datos['sanidad3'], 'seguridad' => $datos['seguridad3'], 'economia' => $datos['economia3']],
                ['letra' => 'd', 'respuesta' => $datos['respuesta4'], 'educacion' => $datos['educacion4'], 'sanidad' => $datos['sanidad4'], 'seguridad' => $datos['seguridad4'], 'economia' => $datos['economia4']],
            ];
    
            foreach ($respuestas as $respuesta) {
                $stmtRespuestas->bindValue(':idPregunta', $datos['idPregunta'], PDO::PARAM_INT);
                $stmtRespuestas->bindValue(':letraRespuesta', $respuesta['letra'], PDO::PARAM_STR);
                $stmtRespuestas->bindValue(':respuesta', $respuesta['respuesta'], PDO::PARAM_STR);
                $stmtRespuestas->bindValue(':educacion', $respuesta['educacion'], PDO::PARAM_INT);
                $stmtRespuestas->bindValue(':sanidad', $respuesta['sanidad'], PDO::PARAM_INT);
                $stmtRespuestas->bindValue(':seguridad', $respuesta['seguridad'], PDO::PARAM_INT);
                $stmtRespuestas->bindValue(':economia', $respuesta['economia'], PDO::PARAM_INT);
                $stmtRespuestas->execute();
            }
    
            $this->conexion->commit();
            return true;
    
        } catch (PDOException $e) {
            // Revertir la transacción si ocurre un error
            $this->conexion->rollBack();
            error_log("Error al modificar la pregunta: " . $e->getMessage());
            return false;
        }
    }
    public function mEliminarPregunta($idPregunta){
        try{
            $this->conexion->beginTransaction();
            $sqlPreguntas='DELETE FROM Preguntas WHERE Preguntas.idPregunta = :idPregunta;';
            $stmtPreguntas = $this->conexion->prepare($sqlPreguntas);
            $stmtPreguntas->bindValue(':idPregunta', $idPregunta, PDO::PARAM_INT);
            $stmtPreguntas->execute();

            $sqlRespuesta='DELETE FROM Respuestas WHERE Respuestas.idPregunta = :idPregunta;';
            $stmtRespuesta = $this->conexion->prepare($sqlRespuesta);
            $stmtRespuesta->bindValue(':idPregunta', $idPregunta, PDO::PARAM_INT);
            $stmtRespuesta->execute();
            $this->conexion->commit();
            return true; 
        }catch (PDOException $e) {
            $this->conexion->rollBack();
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }
    

}