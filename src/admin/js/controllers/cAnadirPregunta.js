// controllers/cAnadirPregunta.js
import { MAnadirPregunta } from '../models/mAnadirPregunta.js';
export class CAnadirPregunta {
    modelo;
    constructor() {
        this.modelo = new MAnadirPregunta();
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
        alert('controlador');
        try {
            // Aquí puedes realizar validaciones adicionales si es necesario
            const resultado = await this.modelo.mAnadirPregunta(formData);
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
