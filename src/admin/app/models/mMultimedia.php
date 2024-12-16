<?php
    
    class MMultimedia{

        private $conexion;

        public $codError;
        
        function __construct(){
            require_once 'db.php';
            $objConexion = new Db();
            $this->conexion= $objConexion->conexion;
        }

        public function mMostrarMultimedia(){
            
            try {
                // Iniciar la transacción
                $this->conexion->beginTransaction();
        
                // Consultar logros
                $sqlLogros = "
                    SELECT 
                        Logros.idLogro, Logros.textoLogro, 
                        Multimedia.nombreMultimedia, Multimedia.ruta 
                    FROM Logros
                    INNER JOIN Multimedia ON Logros.idMultimedia = Multimedia.idMultimedia;
                ";
                $stmtLogros = $this->conexion->prepare($sqlLogros);
                $stmtLogros->execute();
                $logros = $stmtLogros->fetchAll(PDO::FETCH_ASSOC);
        
                // Consultar preguntas
                $sqlPreguntas = "
                    SELECT 
                        Preguntas.idPregunta, Preguntas.texto, 
                        Multimedia.nombreMultimedia, Multimedia.ruta 
                    FROM Preguntas
                    INNER JOIN Multimedia ON Preguntas.idMultimedia = Multimedia.idMultimedia;
                ";
                $stmtPreguntas = $this->conexion->prepare($sqlPreguntas);
                $stmtPreguntas->execute();
                $preguntas = $stmtPreguntas->fetchAll(PDO::FETCH_ASSOC);
        
                // Consultar edificios
                $sqlEdificios = "
                    SELECT 
                        Edificios.idEdificio, Edificios.nombreEdificio, 
                        Multimedia.nombreMultimedia, Multimedia.ruta 
                    FROM Edificios
                    INNER JOIN Multimedia ON Edificios.idMultimedia = Multimedia.idMultimedia;
                ";
                $stmtEdificios = $this->conexion->prepare($sqlEdificios);
                $stmtEdificios->execute();
                $edificios = $stmtEdificios->fetchAll(PDO::FETCH_ASSOC);
        
                // Commit de la transacción
                $this->conexion->commit();
        
                // Estructurar los datos en un array asociativo
                $resultado = [
                    'logros' => $logros,
                    'preguntas' => $preguntas,
                    'edificios' => $edificios
                ];
        
                return $resultado;

            } catch (PDOException $e) {
                // Rollback en caso de error
                $this->conexion->rollBack();
                error_log("Error al mostrar multimedia: " . $e->getMessage());
                return false;
            }

        }

    }
?>