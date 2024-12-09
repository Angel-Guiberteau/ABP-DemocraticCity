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
    public function mostrarModificarPreguntas(){
        $this->vista = 'modificarPreguntas';
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
            header("Location: index.php?c=Preguntas&m=mostrarAniadirPreguntas&operacion=correcto");
            exit;

        }else{
            header("Location: index.php?c=Preguntas&m=mostrarAniadirPreguntas&operacion=INCORRECTO");        }
    } 

    public function cModificarPregunta($datos){
        $this->vista = 'modificarPregunta';
        if($pregunta = $this->objMPreguntas->mModificarPregunta($datos['idPregunta'])){
            return $pregunta;
        }else{
            return false;
        }

    }
    public function cGuardarModificacionPregunta($datos){
        if($this->objMPreguntas->mGuardarModificacionPregunta($datos)){
            $preguntas = $this->cMostrarPreguntasyRespuestas();
            return $preguntas;
        }else{
            return false;
        }

    }
}