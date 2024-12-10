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
    /**
     * Método que permite guardar en la bbdd el usuario.
     * @param
     */
    public function registrar($datos){
        try{
            // $sql = "INSERT INTO Usuarios(nombreUsuario, passUsuario) VALUES('".$datos['usuario']."', '".$datos["passw"]."');";
            $sql = "INSERT INTO Usuarios(nombreUsuario, passUsuario) VALUES(:usuario, :passw);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':usuario', $datos['usuario'], PDO::PARAM_STR);
            $stmt->bindValue(':passw', $datos['passw'], PDO::PARAM_STR);

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
}