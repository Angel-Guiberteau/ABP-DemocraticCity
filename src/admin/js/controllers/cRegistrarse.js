import { MRegistrarse } from '../models/mRegistrarse.js';
export class CRegistrarse {
    modelo;
    constructor() {
        this.modelo = new MRegistrarse();
    }

    cRegistrarse(nombreUsuario, passw, rpassw) {
        let formData = new FormData(); 
        formData.append('usuario', nombreUsuario); 
        formData.append('passw', passw); 
        formData.append('rpassw', rpassw); 
        this.modelo.mRegistrarse(formData);
    }
}