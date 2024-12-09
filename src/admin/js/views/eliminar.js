import { CEliminar } from '../controllers/cEliminar.js';
const controlador = new CAnadirPregunta();

// Configuración de eventos al cargar la página
document.addEventListener('DOMContentLoaded', () => {

    // Configuración del evento para enviar el formulario
    document.getElementById('formularioAniadirPreguntas').addEventListener('submit', async (event) => {
        
        event.preventDefault(); // Evita recargar la página

        const formulario = document.getElementById('formularioAniadirPreguntas'); // Obtener el formulario
        const formData = new FormData(formulario); 

        // Validar el formulario antes de enviarlo
        if (formulario.checkValidity()) {
            // Llamar al controlador para gestionar los datos del formulario
            controlador.procesarFormulario(formData);
        } else {
            console.error('Por favor, asegúrese de completar todos los campos requeridos.'); // Mostrar mensaje si faltan campos
        }
    });
});
