import { CAnadirPregunta } from '../controllers/cAnadirPregunta.js';
const controlador = new CAnadirPregunta();

function validarImagenes() {
    const formatosPermitidos = ['image/jpeg', 'image/png'];

    // Crear una lista de los elementos de entrada de archivos
    const archivos = [
        document.getElementById('imagenPregunta'),
        document.getElementById('respuesta1file'),
        document.getElementById('respuesta2file'),
        document.getElementById('respuesta3file'),
        document.getElementById('respuesta4file'),
    ];

    let imagenesValidas = true;

    for (let i = 0; i < archivos.length; i++) {
        const archivo = archivos[i].files[0]; // Obtener el archivo seleccionado
        if (!archivo || !formatosPermitidos.includes(archivo.type)) {
            imagenesValidas = false; // Si algún archivo no es válido, marcamos como inválido
        }
    }

    // Mostrar mensaje de error si las imágenes no son válidas
    const parrafoErrorImagenes = document.getElementById('validacionImagenes');
    if (!imagenesValidas) {
        parrafoErrorImagenes.innerHTML = 'Debe introducir todas las imágenes con formato permitido (JPEG o PNG).';
        parrafoErrorImagenes.style.display = 'inline';
    } else {
        parrafoErrorImagenes.innerHTML = '';
        parrafoErrorImagenes.style.display = 'none';
    }

    return imagenesValidas; // Retorna si todas las imágenes son válidas
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
        if (todosCamposValidos() && validarImagenes()) {
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
    const inputs = document.querySelectorAll('input[type="number"], input[type="text"]');
    for (let input of inputs) {
        // Verificar si el campo requerido está vacío o tiene errores
        if ((input.required && !input.value.trim()) || input.classList.contains('error')) {
            return false; // Retorna falso si algún campo no es válido
        }
    }
    return true; // Retorna verdadero si todos los campos son válidos
}

// Función para habilitar o deshabilitar el botón
function actualizarEstadoBoton() {
    const botonRegistrar = document.getElementById('aniadirPregunta');
    if (todosCamposValidos() && validarImagenes()) {
        botonRegistrar.disabled = false;
        botonRegistrar.style.cursor = 'pointer';
    } else {
        botonRegistrar.disabled = true;
        botonRegistrar.style.cursor = 'not-allowed';
    }
}

// Configuración de eventos al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('input[type="number"], input[type="text"]');
    const archivos = document.querySelectorAll('#imagenPregunta, #respuesta1file, #respuesta2file, #respuesta3file, #respuesta4file');

    const botonRegistrar = document.getElementById('aniadirPregunta');

    // Validar campos de texto y números en tiempo real
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            validarCampo(input);
            actualizarEstadoBoton(); // Recalcular el estado del botón
        });
    });

    // Validar imágenes en tiempo real
    archivos.forEach(archivo => {
        archivo.addEventListener('change', () => {
            validarImagenes();
            actualizarEstadoBoton(); // Recalcular el estado del botón
        });
    });

    // Configuración del evento para enviar el formulario
    document.getElementById('formularioAniadirPreguntas').addEventListener('submit', async (event) => {
        event.preventDefault(); // Evita recargar la página
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
    });
});
