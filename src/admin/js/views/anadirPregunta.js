// Validar campos del formulario
function validarCampo(input) {
    const valor = input.value.trim(); // Eliminar espacios en blanco
    let mensajeError = ''; 
    const idCampo = input.id; // Id del campo

    // Validar que el campo de pregunta no esté vacío
    if (idCampo === 'pregunta' && valor === '') {
        mensajeError = 'Este campo es obligatorio. Por favor, ingrese una pregunta.';
    }

    // Validar que los campos de respuesta no estén vacíos
    if (idCampo.includes('respuesta') && valor === '') {
        mensajeError = 'Este campo es obligatorio. Por favor, ingrese una respuesta.';
    }

    // Validar campos numéricos (Educación, Sanidad, Seguridad, Economía)
    if (idCampo.includes('educacion') || idCampo.includes('sanidad') || idCampo.includes('seguridad') || idCampo.includes('economia')) {

        const numero = parseInt(valor); // Convertir el valor a número

        // Verificar que sea un número válido y dentro del rango permitido
        if (isNaN(numero) || valor === '') {
            mensajeError = 'Este campo debe contener un número.';
        } else if (numero < -10 || numero > 10) {
            mensajeError = 'El valor debe estar entre -10 y 10.';
        }
    }

    // Mostrar mensaje de error o limpiar mensaje anterior
    const divError = document.querySelector(`.validacion${idCampo.charAt(0).toUpperCase() + idCampo.slice(1)}`); // Buscar el div de error correspondiente
    const botonRegistrar = document.getElementById('registroAdmin'); // Botón de registro

    if (mensajeError) {
        divError.style.display = 'block'; // Mostrar mensaje de error
        divError.textContent = mensajeError; // Asignar el texto 
        input.classList.add('error'); // Añadir clase
        botonRegistrar.disabled = true; // Desactivar el botón de registro si hay errores
    } else {
        divError.style.display = 'none'; // Ocultar mensaje de error
        divError.textContent = ''; // Limpiar texto del mensaje
        input.classList.remove('error'); // Quitar la clase 
        if (todosCamposValidos()) {
            botonRegistrar.disabled = false; // Activar el botón de registro si todo está correcto
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
    document.getElementById('formularioAnadirPregunta').addEventListener('submit', async (event) => {
        
        event.preventDefault(); // Evita recargar la página

        const formulario = document.getElementById('formularioAnadirPregunta'); // Obtener el formulario
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
