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

}