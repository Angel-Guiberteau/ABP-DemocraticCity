import { MPartida } from '../models/mPartida.js';
export class CPartida {
    modelo;
    constructor() {
        this.modelo = new MPartida();
    }

    cCrearSala(nombreCiudad, idAnfitrion) {
        alert();
        let formData = new FormData(); 
        formData.append('nombreCiudad', nombreCiudad); 
        formData.append('idAnfitrion', idAnfitrion); 

        this.modelo.mCrearSala(formData);        
    }
    cEliminarSala(codSala, idAnfitrion){
        let formData = new FormData();
        formData.append('codSala', codSala); 
        formData.append('idAnfitrion', idAnfitrion); 
        this.modelo.mEliminarSala(formData);
    }
}