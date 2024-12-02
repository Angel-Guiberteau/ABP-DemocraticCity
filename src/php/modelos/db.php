<?php
class Db{
    private $servidor;
    private $usuario;
    private $password;
    private $bbdd;
    public $conexion;
    function __construct(){
        require_once 'php/config/configDB.php';
        $this->servidor = constant('SERVIDOR');
        $this->usuario = constant('USUARIO');
        $this->password = constant('PASSWORD');
        $this->bbdd = constant('BBDD');
        $this->conexion = $this->conexion = new mysqli($this->servidor, $this->usuario, $this->password, $this->bbdd);
    }
}