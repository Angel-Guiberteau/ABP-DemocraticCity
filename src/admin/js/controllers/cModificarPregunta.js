// controllers/cAnadirPregunta.js
import { MModificarPregunta } from '../models/mModificarPregunta.js';

export class CModificarPregunta {
    modelo;
    constructor() {
        this.modelo = new MModificarPregunta();
    }

    async validarPregunta(pregunta) {
        return pregunta !== "" && pregunta.length <= 255;
    }

    async validarRespuesta(respuesta) {
        return respuesta !== "" && respuesta.length <= 255;
    }

    async validarNumero(campoId) {
        const valor = parseInt(document.getElementById(campoId).value);
        return !isNaN(valor) && valor >= -10 && valor <= 10;
    }

    procesarFormulario(formData) {
            this.modelo.mModificarPregunta(formData);
    }
}
