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
    
            $idMultimediaPregunta = 0;
    
            if (isset($datos['imagenPregunta'])) { // Validacion para ver si se ha subido una imagen para la pregunta

                // Validar tipo de archivo para la pregunta (solo JPG y PNG)
                $tipoArchivoPregunta = strtolower(pathinfo($datos['imagenPregunta']['name'], PATHINFO_EXTENSION));

                if (!in_array($tipoArchivoPregunta, ['jpg', 'jpeg', 'png'])) { // Validacion para ver si el archivo es una imagen
                    throw new Exception("El archivo de la pregunta debe ser PNG o JPG."); // Mensaje de error si el archivo no es del formato correcto
                }
    
                // Generar un nombre único para la multimedia de la pregunta
                $nombrePregunta = pathinfo($datos['imagenPregunta']['name'], PATHINFO_FILENAME); // Cogemos el ombre del archivo
                $nombreMultimedia = $nombrePregunta . "_" . uniqid() . "." . $tipoArchivoPregunta; // Le añadimos un id unico para que no se repita el nombre
    
                // Definir rutas
                $rutaPregunta1 = "img/preguntas/" . $nombreMultimedia;
    
                // Mover archivo a las dos carpetas

                move_uploaded_file($datos['imagenPregunta']['tmp_name'], $rutaPregunta1); // Movemos el archivo a la carpeta de la web
                
    
                // Insertar en la tabla Multimedia (para la pregunta)

                $sqlMultimediaPregunta = "INSERT INTO Multimedia (nombreMultimedia, ruta, tipo) VALUES (:nombre, :ruta, 'P')";

                $stmtMultimediaPregunta = $this->conexion->prepare($sqlMultimediaPregunta);
                // $hash = hash_file('md5', $nombreMultimedia);
                $stmtMultimediaPregunta->bindValue(':nombre', $nombreMultimedia, PDO::PARAM_STR);
                $stmtMultimediaPregunta->bindValue(':ruta', $rutaPregunta1, PDO::PARAM_STR);
                // $stmtMultimediaPregunta->bindValue(':hasheo', $hash, PDO::PARAM_STR);
                $stmtMultimediaPregunta->execute();
    
                $idMultimediaPregunta = $this->conexion->lastInsertId(); // Cogemos el ultimo id insertado para su uso en la pregunta
            }
    
            // Insertar la pregunta con su multimedia que se ha insertado antes
            $sqlPregunta = "INSERT INTO Preguntas (texto, idMultimedia) VALUES (:pregunta, :idMultimedia)";
            $stmtPregunta = $this->conexion->prepare($sqlPregunta);
            $stmtPregunta->bindValue(':pregunta', $datos['pregunta'], PDO::PARAM_STR);
            $stmtPregunta->bindValue(':idMultimedia', $idMultimediaPregunta, PDO::PARAM_INT);
            $stmtPregunta->execute();
    
            $idPregunta = $this->conexion->lastInsertId(); // Cogemos el ultimo id insertado para su uso en las respuestas
    
            // Insertar las respuestas y asociar multimedia a cada respuesta
            $sqlRespuestas = "INSERT INTO Respuestas (idPregunta, letraRespuesta, respuesta, educacion, sanidad, seguridad, economia, idEdificio) 
                            VALUES (:idPregunta, :letraRespuesta, :respuesta, :educacion, :sanidad, :seguridad, :economia, :idEdificio)";
            $stmtRespuesta = $this->conexion->prepare($sqlRespuestas); //   Preparo la consulta para insertar las respuestas
    
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
            
    
            foreach($respuestas as $respuesta){ // Recorremos el array de respuestas para ir insertandolas a la base de datos

                $idMultimediaRespuesta = 0;
    
                if (isset($respuesta['imagen']) && $respuesta['imagen']['tmp_name']) { // Validar si se ha subido una imagen para la respuesta
                    // Validar tipo de archivo para la respuesta (solo JPG y PNG)
                    $tipoArchivoRespuesta = strtolower(pathinfo($respuesta['imagen']['name'], PATHINFO_EXTENSION));

                    if (!in_array($tipoArchivoRespuesta, ['jpg', 'jpeg', 'png'])) { // Validar si el archivo es una imagen
                        throw new Exception("El archivo de la respuesta debe ser PNG o JPG."); // Mensaje de error si el archivo no es del formato correcto
                    }
    
                    // Generar un nombre único para la multimedia de la respuesta
                    $nombreRespuesta = pathinfo($respuesta['imagen']['name'], PATHINFO_FILENAME);
                    $nombreMultimediaRespuesta = $nombreRespuesta . "_" . uniqid() . "." . $tipoArchivoRespuesta;
    
                    // Definir rutas
                    $rutaRespuesta1 = "img/edificios/" . $nombreMultimediaRespuesta; 
                    $rutaRespuesta2 = "../game/img/edificios/" . $nombreMultimediaRespuesta;
    
                    // Mover archivo a las dos carpetas
                    move_uploaded_file($respuesta['imagen']['tmp_name'], $rutaRespuesta1); // Movemos el archivo a la carpeta de la web
                    move_uploaded_file($respuesta['imagen']['tmp_name'], $rutaRespuesta2); // Movemos el archivo a la carpeta del juego
    
                    // Insertamos primero en la tabla Multimedia para poder insertar el ediificio asociado a la respuesta y posteriormente la respuesta

                    $sqlMultimediaRespuesta = "INSERT INTO Multimedia (nombreMultimedia, ruta, tipo) VALUES (:nombre, :ruta, 'E')";
                    $stmtMultimediaRespuesta = $this->conexion->prepare($sqlMultimediaRespuesta);

                    // $hashRespuesta = hash_file('md5', $nombreMultimediaRespuesta);
                    $stmtMultimediaRespuesta->bindValue(':nombre', $nombreMultimediaRespuesta, PDO::PARAM_STR);
                    $stmtMultimediaRespuesta->bindValue(':ruta', $rutaRespuesta1, PDO::PARAM_STR);
                    // $stmtMultimediaRespuesta->bindValue(':hasheo', $hashRespuesta, PDO::PARAM_STR);
                    $stmtMultimediaRespuesta->execute();
    
                    $idMultimediaRespuesta = $this->conexion->lastInsertId(); // Cogemos el ultimo id insertado para su uso en el edificio


                    // Insertar en la tabla Edificios (para la respuesta asociada a la multimedia)
                    $sqlEdificio = "INSERT INTO Edificios (nombreEdificio, idMultimedia) VALUES (:nombreEdificio, :idMultimedia)";

                    $stmtEdificio = $this->conexion->prepare($sqlEdificio);
                    $stmtEdificio->bindValue(':nombreEdificio', $nombreMultimediaRespuesta, PDO::PARAM_STR);
                    $stmtEdificio->bindValue(':idMultimedia', $idMultimediaRespuesta, PDO::PARAM_INT);
                    $stmtEdificio->execute();

                    $idEdificio = $this->conexion->lastInsertId(); // Cogemos el ultimo id insertado para su uso en la respuesta

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
                $stmtRespuesta->execute(); // Ejecutamos la consulta de la respuesta preparada anteriormente y ya que hemos insertado la multimedia y el edificio asociado a la multimedia que esta asociado a la respuesta en la base de datos anteriormente
            }
    
            $this->conexion->commit(); // Hacemos commit de la transacción
            return true;
    
        } catch (PDOException $e) {
            $this->conexion->rollBack(); 
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        } catch (Exception $e) { // Excepcion personalizada para la validacion de los archivos
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
            
            if (isset($datos['imagenPregunta'])){ // Validacion para ver si se ha subido una imagen para la pregunta

                // Validar tipo de archivo para la pregunta (solo JPG y PNG)
                $tipoArchivoPregunta = strtolower(pathinfo($datos['imagenPregunta']['name'], PATHINFO_EXTENSION));

                // if (!in_array($tipoArchivoPregunta, ['jpg', 'jpeg', 'png'])) { // Validacion para ver si el archivo es una imagen
                //     throw new Exception("El archivo de la pregunta debe ser PNG o JPG."); // Mensaje de error si el archivo no es del formato correcto
                // }

    
                // Generar un nombre único para la multimedia de la pregunta
                $nombrePregunta = pathinfo($datos['imagenPregunta']['name'], PATHINFO_FILENAME); // Cogemos el ombre del archivo
                $nombreMultimedia = $nombrePregunta . "_" . uniqid() . "." . $tipoArchivoPregunta; // Le añadimos un id unico para que no se repita el nombre
                // Definir rutas
                $rutaPregunta1 = "img/edificios/" . $nombreMultimedia;
                $rutaPregunta2 = "../game/img/edificios/" . $nombreMultimedia;
                // Mover archivo a las dos carpetas
                move_uploaded_file($datos['imagenPregunta']['tmp_name'], $rutaPregunta2); // Movemos el archivo a la carpeta del juego
                move_uploaded_file($datos['imagenPregunta']['tmp_name'], $rutaPregunta1); // Movemos el archivo a la carpeta de la web
                $sqlMultimediaPregunta = "UPDATE Multimedia SET nombreMultimedia = :nombre, ruta = :ruta WHERE idMultimedia IN (SELECT idMultimedia FROM Preguntas WHERE idPregunta = :idPregunta);";

                $stmtMultimediaPregunta = $this->conexion->prepare($sqlMultimediaPregunta);
                
                $stmtMultimediaPregunta->bindValue(':nombre', $nombreMultimedia, PDO::PARAM_STR);
                $stmtMultimediaPregunta->bindValue(':ruta', $rutaPregunta1, PDO::PARAM_STR);
                $stmtMultimediaPregunta->bindValue('idPregunta', $datos['idPregunta'], PDO::PARAM_INT);
                
                $stmtMultimediaPregunta->execute();

                $idMultimediaPregunta = $this->conexion->lastInsertId();

                //Como se ha añadido una multimedia nueva entonces debemos tambien modificar en la pregunta el idMultimedia que tiene asociado para que este correcto con el nuevo introducido
                echo 'justo antes de consulta 2';
                $sqlPregunta = "UPDATE Preguntas SET texto = :texto, idMultimedia = :idMultimedia WHERE idPregunta = :idPregunta";
                $stmtPregunta = $this->conexion->prepare($sqlPregunta);
                $stmtPregunta->bindValue(':texto', $datos['pregunta'], PDO::PARAM_STR);
                $stmtPregunta->bindValue(':idPregunta', $datos['idPregunta'], PDO::PARAM_INT);
                $stmtPregunta->bindValue(':idMultimedia', $idMultimediaPregunta, PDO::PARAM_INT);
                $stmtPregunta->execute();
                
            }
            else{

                //Si no se introduce un multimedia nuevo, entonces actualizamos solamente los datos de la pregunta, ya que no cambia el multimedia que tiene asociado
                echo 'justo antes de consulta 2';
                $sqlPregunta = "UPDATE Preguntas SET texto = :texto WHERE idPregunta = :idPregunta";
                $stmtPregunta = $this->conexion->prepare($sqlPregunta);
                $stmtPregunta->bindValue(':texto', $datos['pregunta'], PDO::PARAM_STR);
                $stmtPregunta->bindValue(':idPregunta', $datos['idPregunta'], PDO::PARAM_INT);
                $stmtPregunta->execute();

            }
    
            $respuestas = [
                ['letra' => 'a', 'respuesta' => $datos['respuesta1'], 'educacion' => $datos['educacion1'], 'sanidad' => $datos['sanidad1'], 'seguridad' => $datos['seguridad1'], 'economia' => $datos['economia1'], 'imagen' => $datos['respuesta1file']],
                ['letra' => 'b', 'respuesta' => $datos['respuesta2'], 'educacion' => $datos['educacion2'], 'sanidad' => $datos['sanidad2'], 'seguridad' => $datos['seguridad2'], 'economia' => $datos['economia2'], 'imagen' => $datos['respuesta2file']],
                ['letra' => 'c', 'respuesta' => $datos['respuesta3'], 'educacion' => $datos['educacion3'], 'sanidad' => $datos['sanidad3'], 'seguridad' => $datos['seguridad3'], 'economia' => $datos['economia3'], 'imagen' => $datos['respuesta3file']],
                ['letra' => 'd', 'respuesta' => $datos['respuesta4'], 'educacion' => $datos['educacion4'], 'sanidad' => $datos['sanidad4'], 'seguridad' => $datos['seguridad4'], 'economia' => $datos['economia4'], 'imagen' => $datos['respuesta4file']],
            ];
    
            foreach ($respuestas as $respuesta) {

                if(empty($respuestas['imagen'])){

                    //Si esta vacio, entonces es que no se ha introducido un archivo nuevo, por lo que no hace falta modificar ni el multimedia ni el edificio ya que es el mismo
                    echo 'justo antes de consulta 3';
                    $sqlRespuestas = "UPDATE Respuestas 
                    SET respuesta = :respuesta, educacion = :educacion, sanidad = :sanidad, 
                        seguridad = :seguridad, economia = :economia 
                    WHERE idPregunta = :idPregunta AND letraRespuesta = :letraRespuesta";
        
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
                else{

                    //Si se ha introducido una nueva imagen entonces deberemos de actualizar todo, el multimedia asociado al edificio, que a su vez asociado a la respuesta

                    $tipoArchivoRespuesta = strtolower(pathinfo($respuesta['imagen']['name'], PATHINFO_EXTENSION));

                    if (!in_array($tipoArchivoRespuesta, ['jpg', 'jpeg', 'png'])) { // Validar si el archivo es una imagen
                        throw new Exception("El archivo de la respuesta debe ser PNG o JPG."); // Mensaje de error si el archivo no es del formato correcto
                    }
    
                    // Generar un nombre único para la multimedia de la respuesta
                    $nombreRespuesta = pathinfo($respuesta['imagen']['name'], PATHINFO_FILENAME);
                    $nombreMultimediaRespuesta = $nombreRespuesta . "_" . uniqid() . "." . $tipoArchivoRespuesta;
    
                    // Definir rutas
                    $rutaRespuesta1 = "img/edificios/" . $nombreMultimediaRespuesta; 
                    $rutaRespuesta2 = "../game/img/edificios/" . $nombreMultimediaRespuesta;
    
                    // Mover archivo a las dos carpetas
                    move_uploaded_file($respuesta['imagen']['tmp_name'], $rutaRespuesta1); // Movemos el archivo a la carpeta de la web
                    move_uploaded_file($respuesta['imagen']['tmp_name'], $rutaRespuesta2); // Movemos el archivo a la carpeta del juego
                    echo 'justo antes de consulta 3';
                    $sqlMultimediaEdificio = "UPDATE Multimedia SET nombreMultimedia = :nombre, ruta = :ruta WHERE idMultimedia IN (SELECT idMultimedia FROM Preguntas WHERE idPregunta = :idPregunta);";

                    $stmMultimediaEdificio = $this->conexion->prepare($sqlMultimediaEdificio);
                
                    $stmMultimediaEdificio->bindValue(':nombre', $nombreMultimedia, PDO::PARAM_STR);
                    $stmMultimediaEdificio->bindValue(':ruta', $rutaPregunta1, PDO::PARAM_STR);
                    $stmMultimediaEdificio->bindValue('idPregunta', $datos['idPregunta'], PDO::PARAM_INT);
                    
                    $stmMultimediaEdificio->execute();

                    $idMultimediaEdificio = $this->conexion->lastInsertId();

                    //Una vez acuatlizado el Multimedia actualizamos el edificio asociado a ese multimedia
                    echo 'justo antes de consulta 4';
                    $sqlEdificio = "UPDATE Edificios SET nombreEdificio = :nombreEdificio, idMultimedia = :idMultimedia WHERE idEdificio = (SELECT idEdificio FROM Respuestas WHERE idPregunta = :idPregunta AND letraRespuesta = :letraRespuesta);";

                    $stmEdificio = $this->conexion->prepare($sqlEdificio);

                    $stmEdificio->bindValue(':nombreEdificio', $nombreMultimedia, PDO::PARAM_STR);
                    $stmEdificio->bindValue(':idMultimedia', $idMultimediaEdificio, PDO::PARAM_STR);
                    $stmEdificio->bindValue(':idPregunta', $datos['idPregunta'], PDO::PARAM_STR);
                    $stmEdificio->bindValue(':letraRespuesta', $respuesta['letra'], PDO::PARAM_STR);

                    $stmEdificio->execute();

                    $idEdificio = $this->conexion->lastInsertId();

                    //Una vez actualizado el edificio podemos actualizar la respuesta
                    echo 'justo antes de consulta 5';
                    $sqlRespuestas = "UPDATE Respuestas 
                    SET respuesta = :respuesta, educacion = :educacion, sanidad = :sanidad, 
                        seguridad = :seguridad, economia = :economia, idEdificio = :idEdificio 
                    WHERE idPregunta = :idPregunta AND letraRespuesta = :letraRespuesta";
        
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
    public function mEliminarPregunta($idPregunta){
        try {
            $this->conexion->beginTransaction();
        
            $sqlPartidasPreguntas = "DELETE FROM Partidas_preguntas WHERE idPregunta = :idPregunta";
            $stmtPartidasPreguntas = $this->conexion->prepare($sqlPartidasPreguntas);
            $stmtPartidasPreguntas->bindValue(':idPregunta', $idPregunta, PDO::PARAM_INT);
            $stmtPartidasPreguntas->execute();
        
<<<<<<< HEAD
            //2: Cogemos los idEdificio asociados a las respuestas de la pregunta
            $sqlSelectEdificios = "SELECT idEdificio FROM Respuestas WHERE idPregunta = :idPregunta";
            $stmtSelectEdificios = $this->conexion->prepare($sqlSelectEdificios);
            $stmtSelectEdificios->bindValue(':idPregunta', $idPregunta, PDO::PARAM_INT);
            $stmtSelectEdificios->execute();
            $edificios = $stmtSelectEdificios->fetchAll(PDO::FETCH_COLUMN);
        
            // Confirmar transacción
            $this->conexion->commit();
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->conexion->rollBack();
            throw $e;
=======
            // Confirmar la transacción
            $this->conexion->commit();
            
        } catch (Exception $e) {
            $this->conexion->rollBack();
            throw new Exception("Error al eliminar la pregunta y sus respuestas: " . $e->getMessage());
>>>>>>> cef6e4185f2cdc2a5551cc8cb9a2791119c31a9c
        }
        
    }
    

}