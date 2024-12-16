import { CAnadirPregunta } from '../controllers/cAnadirPregunta.js';
const controlador = new CAnadirPregunta();


let imagenPregunta = document.getElementById('imagenPregunta');
let archivoPregunta;
let respuesta1file = document.getElementById('respuesta1file');
let archivoRespuesta1;
let respuesta2file = document.getElementById('respuesta2file');
let archivoRespuesta2;
let respuesta3file = document.getElementById('respuesta3file');
let archivoRespuesta3;
let respuesta4file = document.getElementById('respuesta4file');
let archivoRespuesta4;

function validarImagenes() {
    const formatosPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

    // Obtener los archivos seleccionados
    archivoPregunta = imagenPregunta.files[0];
    archivoRespuesta1 = respuesta1file.files[0];
    archivoRespuesta2 = respuesta2file.files[0];
    archivoRespuesta3 = respuesta3file.files[0];
    archivoRespuesta4 = respuesta4file.files[0];

    // Validar que cada archivo existe y tiene un formato permitido
    if (!archivoPregunta || !formatosPermitidos.includes(archivoPregunta.type)) {
        return false;
    }
    if (!archivoRespuesta1 || !formatosPermitidos.includes(archivoRespuesta1.type)) {
        return false;
    }
    if (!archivoRespuesta2 || !formatosPermitidos.includes(archivoRespuesta2.type)) {
        return false;
    }
    if (!archivoRespuesta3 || !formatosPermitidos.includes(archivoRespuesta3.type)) {
        return false;
    }
    if (!archivoRespuesta4 || !formatosPermitidos.includes(archivoRespuesta4.type)) {
        return false;
    }

    return true; // Si pasa todas las validaciones, retorna verdadero
}


function validarCampo(input) {
    const valor = input.value.trim();
    let mensajeError = ''; 
    const idCampo = input.id;

    if (idCampo === 'pregunta' && valor === '') {
        mensajeError = 'Este campo es obligatorio. Por favor, ingrese una pregunta.';
    }

    if (idCampo.includes('respuesta') && valor === '') {
        mensajeError = 'Este campo es obligatorio. Por favor, ingrese una respuesta.';
    }

    if (idCampo.includes('educacion') || idCampo.includes('sanidad') || idCampo.includes('seguridad') || idCampo.includes('economia')) {

        const numero = parseInt(valor);

        if (isNaN(numero) || valor === '') {
            mensajeError = 'Este campo debe contener un número.';
        } else if (numero < -10 || numero > 10) {
            mensajeError = 'El valor debe estar entre -10 y 10.';
        }
    }

    const divError = document.querySelector(`.validacion${idCampo.charAt(0).toUpperCase() + idCampo.slice(1)}`);
    const botonRegistrar = document.getElementById('aniadirPregunta');

    if (mensajeError) {
        divError.style.display = 'block';
        divError.textContent = mensajeError;
        input.classList.add('error');
        botonRegistrar.disabled = true;
        botonRegistrar.style.cursor = 'not-allowed';
    } else {
        divError.style.display = 'none';
        divError.textContent = '';
        input.classList.remove('error'); 
        if (todosCamposValidos()) {
            botonRegistrar.disabled = false;
            botonRegistrar.style.cursor = 'pointer';
        } else {
            botonRegistrar.disabled = true;
            botonRegistrar.style.cursor = 'not-allowed';
        }
    }
}

// Función para comprobar si todos los campos del formulario son válidos
function todosCamposValidos() {
    const inputs = document.querySelectorAll('input'); // Obtener todos los campos de entrada
    for (let input of inputs) {
        // Verificar si el campo requerido está vacío o tiene errores
        if ((input.required && !input.value.trim()) || input.classList.contains('error')) {
            return false; // Retorna falso si algún campo no es válido
        }
    }
    return true; // Retorna verdadero si todos los campos son válidos
}

// Configuración de eventos al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('input'); // Obtener todos los campos de entrada
    inputs.forEach(input => {
        // Añadir un evento para validar el campo mientras el usuario escribe
        input.addEventListener('input', () => validarCampo(input));
    });

    // Configuración del evento para enviar el formulario
    document.getElementById('formularioAniadirPreguntas').addEventListener('submit', async (event) => {
        
        event.preventDefault(); // Evita recargar la página
        if(validarImagenes()){
            document.getElementById('validacionImagenes').innerHTML = '';
        
            const formulario = document.getElementById('formularioAniadirPreguntas'); // Obtener el formulario
            const formData = new FormData(formulario); 

            // Validar el formulario antes de enviarlo
            if (formulario.checkValidity()) {
                // Llamar al controlador para gestionar los datos del formulario
                controlador.procesarFormulario(formData);
            } else {
                alert('Por favor, asegúrese de completar todos los campos requeridos.'); // Mostrar mensaje si faltan campos
            }
        }else{
            let parrafoErrorImagenes = document.getElementById('validacionImagenes');
            parrafoErrorImagenes.innerHTML = 'Debe introducir todas las imagenes';
            parrafoErrorImagenes.style.display = 'inline';
        }
    });
});