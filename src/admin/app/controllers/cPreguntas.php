<?php
class CPreguntas{
    private $objMPreguntas;
    public $vista;
    function __construct(){
        require_once RUTA_MODELOS.'Preguntas.php';
        $this->objMPreguntas = new MPreguntas();
    }

    public function mostrarAniadirPreguntas(){
        $this->vista = 'aniadirPreguntas';
    }
    public function cMostrarPreguntasyRespuestas(){
        $this->vista = 'gestionPreguntas';
        $preguntas=$this->objMPreguntas->mMostrarPreguntasyRespuestas();
        if($preguntas){
            return $preguntas;
        }else{
            return false;
        }
    } 
    public function cAniadirPreguntas($datos){
        $this->vista = 'aniadirPreguntas';
        $preguntas=$this->objMPreguntas->mAniadirPreguntas($datos);
        if($preguntas){
            return true;
        }else{
            return false;
        }
    } 
}