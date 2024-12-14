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

    function cMostrarPreguntas($datos){
        
        $this->vista = '';

        if($preguntas = $this->objMPartida->mMostrarPreguntas($datos)){
            
            echo json_encode($preguntas);

            $this->crearValoresIniciales($datos);
            exit;
        }
        else{
            echo 'incorrecto';
            return false;
        }
    }
    function cMostrarPreguntasUsuario($datos){
        
        $this->vista = '';

        if($preguntas = $this->objMPartida->mMostrarPreguntasUsuario($datos)){
            echo json_encode($preguntas);
            exit;
        }
        else{
            echo 'incorrecto';
            return false;
        }
    }
    
    function cEnviarVoto($datos){
        try{
            $rutaJson = RUTA_JSON.$datos['idPartida'].$datos['nombreCiudad'].'.json';

            $jsonData = json_decode(file_get_contents($rutaJson), true);
            if(array_key_exists($datos['letraElegida'], $jsonData)){
                $jsonData[$datos['letraElegida']]++;
                file_put_contents($rutaJson, json_encode($jsonData, JSON_PRETTY_PRINT));
                echo "correcto";
            }else{
                echo 'incorrecto';
            }
        }catch(Exception $e){
            echo 'Error';
        }
        
    }

    private function crearValoresIniciales($datos){
        $rutaCarpeta = RUTA_JSON;
        $idPartida = (string)$datos['idPartida'];
        $nombreCiudad = (string)$datos['nombreCiudad'];
        $nombreJson = $idPartida.$nombreCiudad. '.json';
        $rutaArchivo = $rutaCarpeta.$nombreJson;
        if(file_exists($rutaArchivo)){
            unlink($rutaArchivo);
        }
        
        
        $json = [
            "A" => 0,
            "B" => 0,
            "C" => 0,
            "D" => 0
        ];
        file_put_contents($rutaArchivo, json_encode($json, JSON_PRETTY_PRINT));

    }


    function cCalcularJugadores($datos){

        $this->vista = '';

        if($numJugadores = $this->objMPartida->mCalcularJugadores($datos)){
            echo $numJugadores;
            exit;
        }
        else{
            echo 'incorrecto';
            exit;
        }
    }

    function cCalularVotosRestantes($datos){
        
        $this->vista = '';

        // Ruta al archivo JSON
        $rutaArchivo = RUTA_JSON.$datos['nombreArchivo'];

        // Leer contenido del archivo antes que decodicar
        $contenidoJson = file_get_contents($rutaArchivo);
        // echo $contenidoJson;
        // Decodificar el contenido del archivo como un array asociativo
        $datosJson = json_decode($contenidoJson, true);
        
        // Sumar los valores del array
        if(isset($datosJson['A'])){
            $totalVotos = 0;
            $votosA = $datosJson['A'];
            $votosB = $datosJson['B'];
            $votosC = $datosJson['C'];
            $votosD  = $datosJson['D'];
            $totalVotos =  $votosA+$votosB+$votosC+$votosD;
            if($totalVotos == $datos['numJugadores']){
                unlink($rutaArchivo);
                $letraMasVotada = $this->comprobarLetraMayorVotada($votosA,$votosB,$votosC,$votosD);
                $textoPreguntaMasVotada = $this->objMPartida->mPreguntaMasVotada($datos['idPregunta'], $letraMasVotada);
                $votosLetraMasVotada = $this->comprobarVotosLetraMayorVotada($letraMasVotada,$votosA,$votosB,$votosC,$votosD);
                $json = [
                    "letraVotada" => $letraMasVotada,
                    "numeroVotos" => $votosLetraMasVotada,
                    "texto" => $textoPreguntaMasVotada
                ];
                file_put_contents($rutaArchivo, json_encode($json, JSON_PRETTY_PRINT));
                
            }else{
                $json = [
                    "totalVotos" => $totalVotos,
                    "A" => $datosJson['A'],
                    "B" => $datosJson['B'],
                    "C" => $datosJson['C'],
                    "D" => $datosJson['D']
                ];
            }
        }else{
            $json = json_decode($contenidoJson, true);
        }
        echo json_encode($json);
    }


    private function generarCodigoAleatorio($longitud = 6) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = substr(str_shuffle($caracteres), 0, $longitud);
        return $codigo;
    }

    private function comprobarLetraMayorVotada($votosA,$votosB,$votosC,$votosD){

        $votos = [
            'A' => $votosA,
            'B' => $votosB,
            'C' => $votosC,
            'D' => $votosD
        ];
        $maxVotos = max($votosA, $votosB, $votosC, $votosD);

        // Buscamos la clave (letra) que tiene el valor máximo
        $letraMasVotada = array_search($maxVotos, $votos);
        return $letraMasVotada;
    }   
    private function comprobarVotosLetraMayorVotada($letraMasVotada,$votosA,$votosB,$votosC,$votosD){
        switch ($letraMasVotada) {
            case 'A':
                return $votosA;
            case 'B':
                return $votosB;
            case 'C':
                return $votosC;
            case 'D':
                return $votosD;
            default:
                return 0; // Por si hay algún error
        }
    }
    

}