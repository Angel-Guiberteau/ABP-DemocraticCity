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

    async procesarFormulario(formData) {
        try {
            // Aquí puedes realizar validaciones adicionales si es necesario
            const resultado = await this.modelo.mModificarPregunta(formData);
            if (resultado.success) {
                console.log('Pregunta añadida con éxito');
            } else {
                console.error('Hubo un error al añadir la pregunta:', resultado.message);
            }
        } catch (error) {
            console.error('Error al procesar el formulario:', error);
        }
    }
}
