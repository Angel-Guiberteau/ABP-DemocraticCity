<?php
class Db{
    private $servidor;
    private $usuario;
    private $password;
    private $bbdd;
    public $conexion;
    function __construct(){
        require_once RUTA_CONFIGS.'.configDB.php';
        $this->servidor = constant('SERVIDOR');
        $this->usuario = constant('USUARIO');
        $this->password = constant('PASSWORD');
        $this->bbdd = constant('BBDD');

        $dsn = 'mysql:host=' . $this->servidor . ';dbname=' . $this->bbdd;

        $opciones = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        try {
            $this->conexion = new PDO($dsn, $this->usuario, $this->password, $opciones);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}