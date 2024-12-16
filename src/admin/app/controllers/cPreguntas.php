<?php
class CPreguntas{
    private $objMPreguntas;
    public $vista;
    function __construct(){
        require_once RUTA_MODELOS.'Preguntas.php';
        $this->objMPreguntas = new MPreguntas();
    }

    public function mostrarGestionPreguntas(){
        $this->vista = 'gestionPreguntas';
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

        $datos = $_POST;
        $imagenes = $_FILES;

        $datos += $imagenes;

            $preguntas=$this->objMPreguntas->mAniadirPreguntas($datos);
            if($preguntas){
                $this->vista = '';
                echo 'correcto';
                return true;
    
            }else{
                $this->vista = '';
                echo 'incorrecto';
                return false;
            }
        
    } 

    public function cModificarPregunta($datos){ //ESTO SOLO MUESTRA EN LOS INPUTS LA INFO DE LA PREGUNTA QUE SE QUIERE MODIFICAR
        $this->vista = 'modificarPregunta';
        
        if($pregunta = $this->objMPreguntas->mModificarPregunta($datos['idPregunta'])){
            return $pregunta;
        }else{
            return false;
        }

    }
    public function cGuardarModificacionPregunta($datos){ //METODO USADO PARA MODIFICAR LA PREGUNTA 

        $datos = $_POST;
        $imagenes = $_FILES;

        $datos += $imagenes;

        if($this->objMPreguntas->mGuardarModificacionPregunta($datos)){
            $preguntas = $this->cMostrarPreguntasyRespuestas();
            $this->vista = '';
            echo 'correcto';
            return $preguntas;
        }else{
            $this->vista = '';
            echo 'incorrecto';
            return false;
        }
        

    }
    public function cEliminarPregunta($datos){
        if($this->cComprobarDatos($datos)){
            if($this->objMPreguntas->mEliminarPregunta($datos['idPregunta'])){
                $preguntas = $this->cMostrarPreguntasyRespuestas();
                return $preguntas;
            }else{
                $preguntas = $this->cMostrarPreguntasyRespuestas();
                return false;
            }
        }else{
            return false;
        }
        
    }
    public function cComprobarDatos($datos) {
        if (empty($datos) || !is_array($datos)) {
            return false;
        }

        foreach ($datos as $clave => $valor) {
            if (!isset($valor) || trim($valor) === '') {
                return false;
            }
        }
    
        return true;
    }

}