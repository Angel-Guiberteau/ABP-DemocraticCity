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

            $sqlPregunta = "INSERT INTO Preguntas (texto) VALUES (:pregunta)";
            $stmtPregunta = $this->conexion->prepare($sqlPregunta);
            $stmtPregunta->bindValue(':pregunta', $datos['pregunta'], PDO::PARAM_STR);
            $stmtPregunta->execute();

            $idPregunta = $this->conexion->lastInsertId();

            $sqlRespuestas = "INSERT INTO Respuestas (idPregunta, letraRespuesta, respuesta, educacion, sanidad, seguridad, economia) VALUES (:idPregunta, :letraRespuesta, :respuesta, :educacion, :sanidad, :seguridad, :economia)";

            $stmtRespuesta = $this->conexion->prepare($sqlRespuestas);

            $respuestas = [
                ['letra' => 'a', 'respuesta' => $datos['respuesta1'], 'educacion' => $datos['educacion1'], 'sanidad' => $datos['sanidad1'], 'seguridad' => $datos['seguridad1'], 'economia' => $datos['economia1']],
                ['letra' => 'b', 'respuesta' => $datos['respuesta2'], 'educacion' => $datos['educacion2'], 'sanidad' => $datos['sanidad2'], 'seguridad' => $datos['seguridad2'], 'economia' => $datos['economia2']],
                ['letra' => 'c', 'respuesta' => $datos['respuesta3'], 'educacion' => $datos['educacion3'], 'sanidad' => $datos['sanidad3'], 'seguridad' => $datos['seguridad3'], 'economia' => $datos['economia3']],
                ['letra' => 'd', 'respuesta' => $datos['respuesta4'], 'educacion' => $datos['educacion4'], 'sanidad' => $datos['sanidad4'], 'seguridad' => $datos['seguridad4'], 'economia' => $datos['economia4']],
            ];
            foreach($respuestas as $respuesta){
                $stmtRespuesta->bindValue(':idPregunta', $idPregunta, PDO::PARAM_INT);
                $stmtRespuesta->bindValue(':letraRespuesta', $respuesta['letra'], PDO::PARAM_STR);
                $stmtRespuesta->bindValue(':respuesta', $respuesta['respuesta'], PDO::PARAM_STR);
                $stmtRespuesta->bindValue(':educacion', $respuesta['educacion'], PDO::PARAM_INT);
                $stmtRespuesta->bindValue(':sanidad', $respuesta['sanidad'], PDO::PARAM_INT);
                $stmtRespuesta->bindValue(':seguridad', $respuesta['seguridad'], PDO::PARAM_INT);
                $stmtRespuesta->bindValue(':economia', $respuesta['economia'], PDO::PARAM_INT);
                error_log("Insertando: " . print_r($respuesta, true));
                $stmtRespuesta->execute();
            }

            $this->conexion->commit();

            return true;

        }catch (PDOException $e) {
            $this->conexion->rollBack();
            error_log("Error en la consulta: " . $e->getMessage());
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
            // Inicia una transacción para asegurar consistencia en la base de datos
            $this->conexion->beginTransaction();
    
            // Actualizar el texto de la pregunta
            $sqlPregunta = "UPDATE Preguntas SET texto = :texto WHERE idPregunta = :idPregunta";
            $stmtPregunta = $this->conexion->prepare($sqlPregunta);
            $stmtPregunta->bindValue(':texto', $datos['pregunta'], PDO::PARAM_STR);
            $stmtPregunta->bindValue(':idPregunta', $datos['idPregunta'], PDO::PARAM_INT);
            $stmtPregunta->execute();
    
            // Actualizar las respuestas asociadas
            $sqlRespuestas = "UPDATE Respuestas 
                SET respuesta = :respuesta, educacion = :educacion, sanidad = :sanidad, 
                    seguridad = :seguridad, economia = :economia 
                WHERE idPregunta = :idPregunta AND letraRespuesta = :letraRespuesta";
    
            $stmtRespuestas = $this->conexion->prepare($sqlRespuestas);
    
            // Asumimos que hay un máximo de 4 respuestas y los datos tienen un formato coherente
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
    
            // Confirmar los cambios
            $this->conexion->commit();
            return true;
    
        } catch (PDOException $e) {
            // Revertir la transacción si ocurre un error
            $this->conexion->rollBack();
            error_log("Error al modificar la pregunta: " . $e->getMessage());
            return false;
        }
    }
    

}