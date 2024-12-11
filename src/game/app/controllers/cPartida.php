<?php
class CPartida{
    private $objMPartida;
    public $vista;
    function __construct(){
        require_once RUTA_MODELOS.'Partida.php';
        $this->objMPartida = new MPartida();
    }

    public function mostrarSalaAnfitrion(){
        $this->vista = 'salaAnfitrion';
    }

    public function cCrearSala($datos){
        $this->vista = '';
        $codigoSala = $this->generarCodigoAleatorio(6);
        $datos['codSala'] = $codigoSala;
        if($this->objMPartida->mCrearSala($datos)){
            $this->vista = '';
            echo 'correcto';
            return $datos;

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

    function generarCodigoAleatorio($longitud = 6) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = substr(str_shuffle($caracteres), 0, $longitud);
        return $codigo;
    }
}