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
    cUnirseSala(codSala, idUsuario){
        alert('controlador');

        let formData = new FormData();
        formData.append('codSala', codSala); 
        formData.append('idUsuario', idUsuario); 
        this.modelo.mUnirseSala(formData);
    }

    cMostrarJugadores(idPartida){
        let formData = new FormData();
        formData.append('idPartida', idPartida); 
        let result = this.modelo.mMostrarJugadores(formData);
        return result;
    }
}