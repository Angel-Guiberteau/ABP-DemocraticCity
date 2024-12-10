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
        alert('controlador');

        this.modelo.mCrearSala(formData);

        
    }
}