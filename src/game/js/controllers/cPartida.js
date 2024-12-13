import { MPartida } from '../models/mPartida.js';
export class CPartida {
    modelo;
    constructor() {
        this.modelo = new MPartida();
    }

    cCrearSala(nombreCiudad, idAnfitrion) {
        let formData = new FormData(); 
        formData.append('nombreCiudad', nombreCiudad); 
        formData.append('idAnfitrion', idAnfitrion); 

        this.modelo.mCrearSala(formData);     
    }
    cEliminarSala(idPartida){
        let formData = new FormData();
        formData.append('idPartida', idPartida); 
        this.modelo.mEliminarSala(formData);
    }
    cUnirseSala(codSala, idUsuario, parrafo){
        let formData = new FormData();
        formData.append('codSala', codSala); 
        formData.append('idUsuario', idUsuario); 
        this.modelo.mUnirseSala(formData, parrafo);

    }

    cMostrarJugadores(idPartida, parrafoJugadores){
        let formData = new FormData();
        formData.append('idPartida', idPartida); 
        this.modelo.mMostrarJugadores(formData, parrafoJugadores);
    }
    cEliminarUsuarioPartida(idUsuario){
        let formData = new FormData(); 
        formData.append('idUsuario', idUsuario); 
        this.modelo.mEliminarUsuarioPartida(formData);
    }
    cSalaEliminada(idPartida, idUsuario, modal) {
        let formData = new FormData();
        formData.append('idPartida', idPartida);
        formData.append('idUsuario', idUsuario);
                
        // Llamamos al modelo para verificar si la sala ha sido eliminada
        this.modelo.mSalaEliminada(formData, modal);
    }
    cSalaEmpezada(idPartida) {
        console.log('controlador');

        let formData = new FormData();
        formData.append('idPartida', idPartida);                
        // Llamamos al modelo para verificar si la sala ha sido eliminada
        this.modelo.mSalaEmpezada(formData);
    }
    cEmpezarPartida(idPartida) {
        let formData = new FormData();
        formData.append('idPartida', idPartida);                
        // Llamamos al modelo para verificar si la sala ha sido eliminada
        this.modelo.mEmpezarPartida(formData);
    }
    cMostrarPreguntaAnfitrion(idPartida, pregunta, respuesta1, respuesta2, respuesta3, respuesta4) {
        let formData = new FormData();
        formData.append('idPartida', idPartida);                
        this.modelo.mMostrarPreguntaAnfitrion(formData, pregunta, respuesta1, respuesta2, respuesta3, respuesta4);
    }

    cMostrarPreguntaUsuario(idPartida, pregunta, respuesta1, respuesta2, respuesta3, respuesta4){
        let formData = new FormData();
        formData.append('idPartida', idPartida);                
        this.modelo.mMostrarPreguntaUsuario(formData, pregunta, respuesta1, respuesta2, respuesta3, respuesta4);
    }
    
}