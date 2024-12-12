<?php
class CPartida{
    private $objMPartida;
    public $vista;
    function __construct(){
        require_once RUTA_MODELOS.'Partida.php';
        $this->objMPartida = new MPartida();
    }

    public function mostrarSalaUsuario(){
        $this->vista = 'salaUsuario';
    }
    public function mostrarSalaAnfitrion(){
        $this->vista = 'salaAnfitrion';
    }

    public function mostrarJuegoAnfitrion(){
        $this->vista = 'juegoAnfitrion';
    }

    public function mostrarJuegoUsuario(){
        $this->vista = 'juegoUser';
    }

    public function cCrearSala($datos){
        $this->vista = '';
        $codigoSala = $this->generarCodigoAleatorio(6);
        $datos['codSala'] = $codigoSala;
        if($datoPartida = $this->objMPartida->mCrearSala($datos)){
            $this->vista = '';
            echo 'correcto';
            return $datoPartida;
        }
        else{
            $this->vista = '';
            echo 'incorrecto';
            exit;
        }

    }

    public function cMostrarSala($datos){
        
    }

    public function cEliminarSala($datos){
        $this->vista = '';
        if($this->objMPartida->mEliminarSala($datos)){
            $this->vista = '';
            echo 'correcto';
            exit;
        }
        else{
            $this->vista = '';
            echo 'incorrecto';
            exit;
        }

    }
    function cUnirseSala($datos){
        $this->vista = '';
        if($datosPartidas = $this->objMPartida->mUnirseSala($datos)){
            echo 'correcto';
            return $datosPartidas;
        }
        else{
            echo 'incorrecto';
            exit;
        }
    }

    function cMostrarJugadores($datos){
        $this->vista = '';
        if($nombreJugadores = $this->objMPartida->mMostrarJugadores($datos)){
            $this->vista = '';
            echo json_encode($nombreJugadores, true);
            exit;
        }
        else{
            $this->vista = '';
            echo json_encode('incorrecto');
            exit;
        }
    }

    function cEliminarUsuarioPartida($datos){
        $this->vista = '';
        if($this->objMPartida->mEliminarUsuarioPartida($datos)){
            $this->vista = '';
            echo 'correcto';
            exit;
        }
        else{
            $this->vista = '';
            echo 'incorrecto';
            exit;
        }
    }

    function cComprobarPartidaEliminada($datos){
        $this->vista = '';
        if($this->objMPartida->mComprobarPartidaEliminada($datos)){
            $this->vista = '';
            echo 'correcto';
            exit;
        }
        else{
            $this->vista = '';
            echo 'incorrecto';
            exit;
        }
    }
    function cComprobarPartidaEmpezada($datos){
        $this->vista = '';
        if($this->objMPartida->mComprobarPartidaEmpezada($datos)){
            echo 'correcto';
            exit;
        }
        else{
            echo 'incorrecto';
            exit;
        }
    }

    function cEmpezarPartida($datos){
        $this->vista = '';
        if($this->objMPartida->mEmpezarPartida($datos)){
            echo 'correcto';
            exit;
        }
        else{
            echo 'incorrecto';
            exit;
        }
    }

    function generarCodigoAleatorio($longitud = 6) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = substr(str_shuffle($caracteres), 0, $longitud);
        return $codigo;
    }

}