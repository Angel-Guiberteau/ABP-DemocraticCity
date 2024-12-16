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

            $sql='SELECT  
                        Preguntas.idPregunta,
                        Preguntas.texto,
                        Preguntas.idMultimedia AS idMultimediaPregunta,
                        Respuestas.letraRespuesta,
                        Respuestas.educacion,
                        Respuestas.sanidad,
                        Respuestas.seguridad,
                        Respuestas.economia,
                        Respuestas.idEdificio,
                        Respuestas.respuesta,
                        Edificios.idMultimedia AS idMultimediaEdificio,
                        MultimediaPregunta.ruta AS rutaPregunta,
                        MultimediaEdificio.ruta AS rutaEdificio
                    FROM Preguntas 
                    INNER JOIN Respuestas 
                        ON Preguntas.idPregunta = Respuestas.idPregunta
                    LEFT JOIN Edificios 
                        ON Respuestas.idEdificio = Edificios.idEdificio
                    LEFT JOIN Multimedia AS MultimediaPregunta 
                        ON Preguntas.idMultimedia = MultimediaPregunta.idMultimedia
                    LEFT JOIN Multimedia AS MultimediaEdificio
                        ON Edificios.idMultimedia = MultimediaEdificio.idMultimedia';

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
                            //Guardamos el idMultimedia de la pregunta
                            'idMultimediaPregunta' => $fila['idMultimediaPregunta'], 
                            //Guardamos la ruta de la multimedia de la pregunta
                            'rutaPregunta' => $fila['rutaPregunta'], 
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
                        'respuesta' => $fila['respuesta'],
                         //Guardamos el idMultimedia del ediificio asociado a la respuesta
                        'idMultimediaEdificio' => $fila['idMultimediaEdificio'],
                        //Guardamos la ruta de la multimedia del edificio asociado a la respuesta
                        'rutaEdificio' => $fila['rutaEdificio'] 
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
    
            $idMultimediaPregunta = 0;
            
            if (isset($datos['imagenPregunta'])) { // Validacion para ver si se ha subido una imagen para la pregunta
                
                // Validar tipo de archivo para la pregunta (solo JPG y PNG)
                $tipoArchivoPregunta = strtolower(pathinfo($datos['imagenPregunta']['name'], PATHINFO_EXTENSION));

                // Validacion para ver si el archivo es una imagen

                if (!in_array($tipoArchivoPregunta, ['jpg', 'jpeg', 'png'])) { 
                    // Mensaje de error si el archivo no es del formato correcto
                    throw new Exception("El archivo de la respuesta debe ser PNG o JPG o JPEG o JPEG."); 
                }
    
                // Generar un nombre único para la multimedia de la pregunta

                // Cogemos el ombre del archivo
                $nombrePregunta = pathinfo($datos['imagenPregunta']['name'], PATHINFO_FILENAME); 
                // Le añadimos un id unico para que no se repita el nombre
                $nombreMultimedia = $nombrePregunta . "_" . uniqid() . "." . $tipoArchivoPregunta; 
    
                // Definir rutas
                $rutaPregunta1 = "img/preguntas/" . $nombreMultimedia;
    
                // Movemos el archivo a la carpeta

                move_uploaded_file($datos['imagenPregunta']['tmp_name'], $rutaPregunta1); 
                
    
                // Insertar en la tabla Multimedia (para la pregunta)

                $sqlMultimediaPregunta = "INSERT INTO Multimedia (nombreMultimedia, ruta, tipo) VALUES (:nombre, :ruta, 'P')";

                $stmtMultimediaPregunta = $this->conexion->prepare($sqlMultimediaPregunta);
                // $hash = hash_file('md5', $nombreMultimedia);
                $stmtMultimediaPregunta->bindValue(':nombre', $nombreMultimedia, PDO::PARAM_STR);
                $stmtMultimediaPregunta->bindValue(':ruta', $rutaPregunta1, PDO::PARAM_STR);
                // $stmtMultimediaPregunta->bindValue(':hasheo', $hash, PDO::PARAM_STR);
                $stmtMultimediaPregunta->execute();
    
                // Cogemos el ultimo id insertado para su uso en la pregunta

                $idMultimediaPregunta = $this->conexion->lastInsertId(); 
            }
    
            // Insertar la pregunta con su multimedia que se ha insertado antes
            $sqlPregunta = "INSERT INTO Preguntas (texto, idMultimedia) VALUES (:pregunta, :idMultimedia)";
            $stmtPregunta = $this->conexion->prepare($sqlPregunta);
            $stmtPregunta->bindValue(':pregunta', $datos['pregunta'], PDO::PARAM_STR);
            $stmtPregunta->bindValue(':idMultimedia', $idMultimediaPregunta, PDO::PARAM_INT);
            $stmtPregunta->execute();
    
            // Cogemos el ultimo id insertado para su uso en las respuestas

            $idPregunta = $this->conexion->lastInsertId(); 
    
            // Insertar las respuestas y asociar multimedia a cada respuesta
            $sqlRespuestas = "INSERT INTO Respuestas (idPregunta, letraRespuesta, respuesta, educacion, sanidad, seguridad, economia, idEdificio) 
                            VALUES (:idPregunta, :letraRespuesta, :respuesta, :educacion, :sanidad, :seguridad, :economia, :idEdificio)";
            $stmtRespuesta = $this->conexion->prepare($sqlRespuestas); 
    
            // Array con las respuestas


            $respuestas = [
                [
                    'letra' => 'A',
                    'respuesta' => $datos['respuesta1'],
                    'educacion' => $datos['educacion1'],
                    'sanidad' => $datos['sanidad1'],
                    'seguridad' => $datos['seguridad1'],
                    'economia' => $datos['economia1'],
                    'imagen' => isset($datos['respuesta1file']) ? $datos['respuesta1file'] : null,
                ],
                [
                    'letra' => 'B',
                    'respuesta' => $datos['respuesta2'],
                    'educacion' => $datos['educacion2'],
                    'sanidad' => $datos['sanidad2'],
                    'seguridad' => $datos['seguridad2'],
                    'economia' => $datos['economia2'],
                    'imagen' => isset($datos['respuesta2file']) ? $datos['respuesta2file'] : null,
                ],
                [
                    'letra' => 'C',
                    'respuesta' => $datos['respuesta3'],
                    'educacion' => $datos['educacion3'],
                    'sanidad' => $datos['sanidad3'],
                    'seguridad' => $datos['seguridad3'],
                    'economia' => $datos['economia3'],
                    'imagen' => isset($datos['respuesta3file']) ? $datos['respuesta3file'] : null,
                ],
                [
                    'letra' => 'D',
                    'respuesta' => $datos['respuesta4'],
                    'educacion' => $datos['educacion4'],
                    'sanidad' => $datos['sanidad4'],
                    'seguridad' => $datos['seguridad4'],
                    'economia' => $datos['economia4'],
                    'imagen' => isset($datos['respuesta4file']) ? $datos['respuesta4file'] : null,
                ],
            ];
            
            // Recorremos el array de respuestas para ir insertandolas a la base de datos

            foreach($respuestas as $respuesta){ 

                $idMultimediaRespuesta = 0;
    
                // Validar si se ha subido una imagen para la respuesta
                
                if (isset($respuesta['imagen']) && $respuesta['imagen']['tmp_name']) { 
                    // Validar tipo de archivo para la respuesta (solo JPG y PNG)
                    $tipoArchivoRespuesta = strtolower(pathinfo($respuesta['imagen']['name'], PATHINFO_EXTENSION));

                    // Validar si el archivo es una imagen

                    if (!in_array($tipoArchivoRespuesta, ['jpg', 'jpeg', 'png'])) { 
                        // Mensaje de error si el archivo no es del formato correcto
                        throw new Exception("El archivo de la respuesta debe ser PNG o JPG o JPEG o JPEG.");
                    }
    
                    // Generar un nombre único para la multimedia de la respuesta
                    $nombreRespuesta = pathinfo($respuesta['imagen']['name'], PATHINFO_FILENAME);
                    $nombreMultimediaRespuesta = $nombreRespuesta . "_" . uniqid() . "." . $tipoArchivoRespuesta;
    
                    // Definir rutas
                    $rutaRespuesta1 = "img/edificios/" . $nombreMultimediaRespuesta; 
    
    
                    // Mover archivo a la carpeta
                    move_uploaded_file($respuesta['imagen']['tmp_name'], $rutaRespuesta1); 
            
    
                    // Insertamos primero en la tabla Multimedia para poder insertar el ediificio asociado a la respuesta y posteriormente la respuesta

                    $sqlMultimediaRespuesta = "INSERT INTO Multimedia (nombreMultimedia, ruta, tipo) VALUES (:nombre, :ruta, 'E')";
                    $stmtMultimediaRespuesta = $this->conexion->prepare($sqlMultimediaRespuesta);

                    // $hashRespuesta = hash_file('md5', $nombreMultimediaRespuesta);
                    $stmtMultimediaRespuesta->bindValue(':nombre', $nombreMultimediaRespuesta, PDO::PARAM_STR);
                    $stmtMultimediaRespuesta->bindValue(':ruta', $rutaRespuesta1, PDO::PARAM_STR);
                    // $stmtMultimediaRespuesta->bindValue(':hasheo', $hashRespuesta, PDO::PARAM_STR);
                    $stmtMultimediaRespuesta->execute();
    

                    // Cogemos el ultimo id insertado para su uso en el edificio

                    $idMultimediaRespuesta = $this->conexion->lastInsertId(); 


                    // Insertar en la tabla Edificios (para la respuesta asociada a la multimedia)
                    $sqlEdificio = "INSERT INTO Edificios (nombreEdificio, idMultimedia) VALUES (:nombreEdificio, :idMultimedia)";

                    $stmtEdificio = $this->conexion->prepare($sqlEdificio);
                    $stmtEdificio->bindValue(':nombreEdificio', $nombreMultimediaRespuesta, PDO::PARAM_STR);
                    $stmtEdificio->bindValue(':idMultimedia', $idMultimediaRespuesta, PDO::PARAM_INT);
                    $stmtEdificio->execute();

                    // Cogemos el ultimo id insertado para su uso en la respuesta

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

                // Ejecutamos la consulta de la respuesta preparada anteriormente y ya que hemos insertado la multimedia y el edificio asociado a la multimedia que esta asociado a la respuesta en la base de datos anteriormente

                $stmtRespuesta->execute(); 
            }
    
            $this->conexion->commit(); 
            return true;
    
        } catch (PDOException $e) {
            $this->conexion->rollBack(); 
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        } catch (Exception $e) {

             // Excepcion personalizada para la validacion de los formatos de los archivos

            $this->conexion->rollBack();
            error_log("Formato de la imagen no valido" . $e->getMessage());
            return false;
        }
    }
    
    
    public function mModificarPregunta($idPregunta){
        try{

                $sql='SELECT  
                        Preguntas.idPregunta,
                        Preguntas.texto,
                        Preguntas.idMultimedia AS idMultimediaPregunta,
                        Respuestas.letraRespuesta,
                        Respuestas.educacion,
                        Respuestas.sanidad,
                        Respuestas.seguridad,
                        Respuestas.economia,
                        Respuestas.idEdificio,
                        Respuestas.respuesta,
                        Edificios.idMultimedia AS idMultimediaEdificio,
                        MultimediaPregunta.ruta AS rutaPregunta,
                        MultimediaEdificio.ruta AS rutaEdificio
                    FROM Preguntas 
                    INNER JOIN Respuestas 
                        ON Preguntas.idPregunta = Respuestas.idPregunta
                    LEFT JOIN Edificios 
                        ON Respuestas.idEdificio = Edificios.idEdificio
                    LEFT JOIN Multimedia AS MultimediaPregunta 
                        ON Preguntas.idMultimedia = MultimediaPregunta.idMultimedia
                    LEFT JOIN Multimedia AS MultimediaEdificio
                        ON Edificios.idMultimedia = MultimediaEdificio.idMultimedia
                    WHERE Preguntas.idPregunta = :idPregunta;';
                

                $stmt = $this->conexion->prepare($sql);
                $stmt->bindValue(':idPregunta', $idPregunta, PDO::PARAM_INT);
                
                $stmt->execute();

                
                if($stmt->rowCount() > 0){
                    $datos = [];
                    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        if (!isset($datos['idPregunta'])) {
                            $datos = [
                                'idPregunta' => $fila['idPregunta'],
                                'texto' => $fila['texto'], 
                                 //Guardamos el idMultimedia de la pregunta
                                'idMultimediaPregunta' => $fila['idMultimediaPregunta'],
                                //Guardamos la ruta de la multimedia de la pregunta
                                'rutaPregunta' => $fila['rutaPregunta'], 
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
                            'respuesta' => $fila['respuesta'],
                            //Guardamos el idMultimedia del ediificio asociado a la respuesta
                            'idMultimediaEdificio' => $fila['idMultimediaEdificio'], 
                            //Guardamos la ruta de la multimedia del edificio asociado a la respuesta
                            'rutaEdificio' => $fila['rutaEdificio'] 
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

            // Validamos si se ha subido una imagen nueva para la pregunta
            
            if (!empty($datos['imagenPregunta']['tmp_name']) && $datos['imagenPregunta']['error'] === UPLOAD_ERR_OK){
    
                // Validar tipo de archivo para la pregunta (solo JPG y PNG)
                $tipoArchivoPregunta = strtolower(pathinfo($datos['imagenPregunta']['name'], PATHINFO_EXTENSION));
                if (!in_array($tipoArchivoPregunta, ['jpg', 'jpeg', 'png'])) {
                    throw new Exception("El archivo de la respuesta debe ser PNG o JPG o JPEG o JPEG.");
                }

                // Generar un nombre único para la multimedia de la pregunta
                $nombrePregunta = pathinfo($datos['imagenPregunta']['name'], PATHINFO_FILENAME);
                $nombreMultimedia = $nombrePregunta . "_" . uniqid() . "." . $tipoArchivoPregunta;

                // Definir rutas
                $rutaPregunta1 = "img/preguntas/" . $nombreMultimedia;

                // Mover archivo a la carpeta
                move_uploaded_file($datos['imagenPregunta']['tmp_name'], $rutaPregunta1);

                // Insertamos un nuevo multimedia en la tabla Multimedia

                $sqlMultimediaPregunta = "INSERT INTO Multimedia (nombreMultimedia, ruta, tipo) VALUES (:nombre, :ruta, 'P')";

                $stmtMultimediaPregunta = $this->conexion->prepare($sqlMultimediaPregunta);
                $stmtMultimediaPregunta->bindValue(':nombre', $nombreMultimedia, PDO::PARAM_STR);
                $stmtMultimediaPregunta->bindValue(':ruta', $rutaPregunta1, PDO::PARAM_STR);

                $stmtMultimediaPregunta->execute();

                $idMultimediaPregunta = $this->conexion->lastInsertId();

                // Actualizamos la pregunta asociandola tambien con el nuevo multimedia que se ha insertado

                $sqlPregunta = "UPDATE Preguntas SET texto = :texto, idMultimedia = :idMultimedia WHERE idPregunta = :idPregunta";

                $stmtPregunta = $this->conexion->prepare($sqlPregunta);
                $stmtPregunta->bindValue(':texto', $datos['pregunta'], PDO::PARAM_STR);
                $stmtPregunta->bindValue(':idPregunta', $datos['idPregunta'], PDO::PARAM_INT);
                $stmtPregunta->bindValue(':idMultimedia', $idMultimediaPregunta, PDO::PARAM_INT);

                $stmtPregunta->execute();

                // Por ultimo borramos el multimedia antiguo asociado a la pregunta y el archivo de la carpeta

                $sqlBorrarMultimediaPregunta = "DELETE FROM Multimedia WHERE idMultimedia = :idMultimedia";

                $stmtBorrarMultimediaPregunta = $this->conexion->prepare($sqlBorrarMultimediaPregunta);
                $stmtBorrarMultimediaPregunta->bindValue(':idMultimedia', $datos['idMultimediaPregunta'], PDO::PARAM_INT);

                $stmtBorrarMultimediaPregunta->execute();

                $rutaMultimediaPregunta = $datos['rutaPregunta'];

                unlink($rutaMultimediaPregunta);


            } else {
                // Si no se introduce un multimedia nuevo, entonces actualizamos solamente los datos de la pregunta

                $sqlPregunta = "UPDATE Preguntas SET texto = :texto WHERE idPregunta = :idPregunta";

                $stmtPregunta = $this->conexion->prepare($sqlPregunta);
                $stmtPregunta->bindValue(':texto', $datos['pregunta'], PDO::PARAM_STR);
                $stmtPregunta->bindValue(':idPregunta', $datos['idPregunta'], PDO::PARAM_INT);

                $stmtPregunta->execute();
            }


            // Actualizamos las respuestas

            $respuestas = [
                ['letra' => 'a', 'respuesta' => $datos['respuesta1'], 'educacion' => $datos['educacion1'], 'sanidad' => $datos['sanidad1'], 'seguridad' => $datos['seguridad1'], 'economia' => $datos['economia1'], 'imagen' => $datos['respuesta1file']],
                ['letra' => 'b', 'respuesta' => $datos['respuesta2'], 'educacion' => $datos['educacion2'], 'sanidad' => $datos['sanidad2'], 'seguridad' => $datos['seguridad2'], 'economia' => $datos['economia2'], 'imagen' => $datos['respuesta2file']],
                ['letra' => 'c', 'respuesta' => $datos['respuesta3'], 'educacion' => $datos['educacion3'], 'sanidad' => $datos['sanidad3'], 'seguridad' => $datos['seguridad3'], 'economia' => $datos['economia3'], 'imagen' => $datos['respuesta3file']],
                ['letra' => 'd', 'respuesta' => $datos['respuesta4'], 'educacion' => $datos['educacion4'], 'sanidad' => $datos['sanidad4'], 'seguridad' => $datos['seguridad4'], 'economia' => $datos['economia4'], 'imagen' => $datos['respuesta4file']],
            ];
            $cont = 1;
            foreach($respuestas as $respuesta) {
                if (!empty($respuesta['imagen']['tmp_name'])) {
                    // Si no esta vacio, se ha introducido un archivo nuevo, primero creamos un nuevo multimedia para la respuesta

                    $tipoArchivoRespuesta = strtolower(pathinfo($respuesta['imagen']['name'], PATHINFO_EXTENSION));

                    if (!in_array($tipoArchivoRespuesta, ['jpg', 'jpeg', 'png'])) {
                        throw new Exception("El archivo de la respuesta debe ser PNG o JPG o JPEG o JPEG.");
                    }

                    $nombreRespuesta = pathinfo($respuesta['imagen']['name'], PATHINFO_FILENAME);
                    $nombreMultimediaRespuesta = $nombreRespuesta . "_" . uniqid() . "." . $tipoArchivoRespuesta;

                    $rutaRespuesta1 = "img/edificios/" . $nombreMultimediaRespuesta;

                    move_uploaded_file($respuesta['imagen']['tmp_name'], $rutaRespuesta1);

                    $sqlMultimediaRespuesta = "INSERT INTO Multimedia (nombreMultimedia, ruta, tipo) VALUES (:nombre, :ruta, 'E')";

                    $stmtMultimediaRespuesta = $this->conexion->prepare($sqlMultimediaRespuesta);
                    $stmtMultimediaRespuesta->bindValue(':nombre', $nombreMultimediaRespuesta, PDO::PARAM_STR);
                    $stmtMultimediaRespuesta->bindValue(':ruta', $rutaRespuesta1, PDO::PARAM_STR);

                    $stmtMultimediaRespuesta->execute();

                    $idMultimediaRespuesta = $this->conexion->lastInsertId();

                    // Insertar en la tabla Edificios (para la respuesta asociada a la multimedia)

                    $sqlEdificio = "INSERT INTO Edificios (nombreEdificio, idMultimedia) VALUES (:nombreEdificio, :idMultimedia)";

                    $stmtEdificio = $this->conexion->prepare($sqlEdificio);
                    $stmtEdificio->bindValue(':nombreEdificio', $nombreMultimediaRespuesta, PDO::PARAM_STR);
                    $stmtEdificio->bindValue(':idMultimedia', $idMultimediaRespuesta, PDO::PARAM_INT);

                    $stmtEdificio->execute();

                    $idEdificio = $this->conexion->lastInsertId();

                    // Actualizamos la respuesta con el nuevo multimedia

                    $sqlRespuestas = "UPDATE Respuestas SET respuesta = :respuesta, educacion = :educacion, sanidad = :sanidad, seguridad = :seguridad, economia = :economia, idEdificio = :idEdificio WHERE idPregunta = :idPregunta AND letraRespuesta = :letraRespuesta";

                    $stmtRespuestas = $this->conexion->prepare($sqlRespuestas);

                    $stmtRespuestas->bindValue(':idPregunta', $datos['idPregunta'], PDO::PARAM_INT);
                    $stmtRespuestas->bindValue(':letraRespuesta', $respuesta['letra'], PDO::PARAM_STR);
                    $stmtRespuestas->bindValue(':respuesta', $respuesta['respuesta'], PDO::PARAM_STR);
                    $stmtRespuestas->bindValue(':educacion', $respuesta['educacion'], PDO::PARAM_INT);
                    $stmtRespuestas->bindValue(':sanidad', $respuesta['sanidad'], PDO::PARAM_INT);
                    $stmtRespuestas->bindValue(':seguridad', $respuesta['seguridad'], PDO::PARAM_INT);
                    $stmtRespuestas->bindValue(':economia', $respuesta['economia'], PDO::PARAM_INT);
                    $stmtRespuestas->bindValue(':idEdificio', $idEdificio, PDO::PARAM_INT);

                    $stmtRespuestas->execute();

                    // Borramos el multimedia antiguo asociado a la respuesta y el archivo de la carpeta

                    $sqlBorrarMultimediaRespuesta = "DELETE FROM Multimedia WHERE idMultimedia = :idMultimedia";

                    $stmtBorrarMultimediaRespuesta = $this->conexion->prepare($sqlBorrarMultimediaRespuesta);
                    $stmtBorrarMultimediaRespuesta->bindValue(':idMultimedia', $datos['idMultimediaEdificio'.$cont], PDO::PARAM_INT);

                    $stmtBorrarMultimediaRespuesta->execute();

                    $rutaMultimediaRespuesta = $datos['rutaEdificio'.$cont];

                    unlink($rutaMultimediaRespuesta);
                    $cont++;

                } else {
                    // Si esta vacio, no se ha introducido un archivo nuevo, por lo que solo actualizamos los datos de la respuesta

                    $sqlRespuestas = "UPDATE Respuestas SET respuesta = :respuesta, educacion = :educacion, sanidad = :sanidad, seguridad = :seguridad, economia = :economia WHERE idPregunta = :idPregunta AND letraRespuesta = :letraRespuesta";

                    $stmtRespuestas = $this->conexion->prepare($sqlRespuestas);

                    $stmtRespuestas->bindValue(':idPregunta', $datos['idPregunta'], PDO::PARAM_INT);
                    $stmtRespuestas->bindValue(':letraRespuesta', $respuesta['letra'], PDO::PARAM_STR);
                    $stmtRespuestas->bindValue(':respuesta', $respuesta['respuesta'], PDO::PARAM_STR);
                    $stmtRespuestas->bindValue(':educacion', $respuesta['educacion'], PDO::PARAM_INT);
                    $stmtRespuestas->bindValue(':sanidad', $respuesta['sanidad'], PDO::PARAM_INT);
                    $stmtRespuestas->bindValue(':seguridad', $respuesta['seguridad'], PDO::PARAM_INT);
                    $stmtRespuestas->bindValue(':economia', $respuesta['economia'], PDO::PARAM_INT);

                    $stmtRespuestas->execute();
                }
            }
    
            $this->conexion->commit();
            return true;
    
        } catch (PDOException $e) {
            // Revertir la transacción si ocurre un error
            $this->conexion->rollBack();
            error_log("Error al modificar la pregunta: " . $e->getMessage());
            return false;
        } catch (Exception $e) { // Excepcion personalizada para la validacion de los archivos
            $this->conexion->rollBack();
            error_log("Formato de la imagen no valido" . $e->getMessage());
            return false;
        }
    }
    public function mEliminarPregunta($datos){
        try {

            $this->conexion->beginTransaction();

            // Eliminamos la multimedia de la pregunta y el archivo de la carpeta

            $sqlBorrarMultimediaPregunta = "DELETE FROM Multimedia WHERE idMultimedia = :idMultimedia";

            $stmtBorrarMultimediaPregunta = $this->conexion->prepare($sqlBorrarMultimediaPregunta);
            $stmtBorrarMultimediaPregunta->bindValue(':idMultimedia', $datos['idMultimediaPregunta'], PDO::PARAM_INT);

            $stmtBorrarMultimediaPregunta->execute();

            $rutaMultimediaPregunta = $datos['rutaPregunta'];

            unlink($rutaMultimediaPregunta);

            $cont = 1;

            // Eliminamos los multimedias asociados a los edicicios y los archivos de la carpeta

            while (isset($datos['idMultimediaEdificio'.$cont])) {

                $sqlBorrarMultimediaRespuesta = "DELETE FROM Multimedia WHERE idMultimedia = :idMultimedia";

                $stmtBorrarMultimediaRespuesta = $this->conexion->prepare($sqlBorrarMultimediaRespuesta);
                $stmtBorrarMultimediaRespuesta->bindValue(':idMultimedia', $datos['idMultimediaEdificio'.$cont], PDO::PARAM_INT);

                $stmtBorrarMultimediaRespuesta->execute();

                $rutaMultimediaRespuesta = $datos['rutaEdificio'.$cont];

                unlink($rutaMultimediaRespuesta);

                $cont++;
            }


            $this->conexion->commit();
            return true;
            
        } catch (Exception $e) {
            $this->conexion->rollBack();
            throw new Exception("Error al eliminar la pregunta y sus respuestas: " . $e->getMessage());
        }
        
    }
    

}