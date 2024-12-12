import { MIniciarSesion } from '../models/mIniciarSesion.js';
export class CIniciarSesion {
    modelo;
    constructor() {
        this.modelo = new MIniciarSesion();
    }

    cIniciarSesion(nombreUsuario, passlogin) {
        let formData = new FormData(); 

        formData.append('usuario', nombreUsuario); 
        formData.append('passw', passlogin); 
        this.modelo.mIniciarSesion(formData);
    }
}