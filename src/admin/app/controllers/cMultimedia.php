<?php
    
    class CMultimedia{

        private $objMultimedia;

        public $vista;

        public function __construct() {
            
            require_once RUTA_MODELOS.'Multimedia.php';
            $this->objMultimedia = new MMultimedia();
            
        }

        public function cMostrarGestionMultimedia(){
            $this->vista = 'gestionMultimedia';

            $datos = $this->objMultimedia->mMostrarMultimedia();

            if($datos)
                return $datos;
            else
                return false;
        }

    }
?>