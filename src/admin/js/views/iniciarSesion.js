import { CIniciarSesion } from '../controllers/cIniciarSesion.js';
const controlador = new CIniciarSesion();

//----------------MOSTRAR CONTRASEÑAS
/**
 * Este método permite mostrar las contraseñas.
 */
function mostrarPassw() {
    const passlogin = document.querySelector('#passw');
    const checkbox = document.querySelector('#verPassw');
    if (passlogin && checkbox) {
        passlogin.type = checkbox.checked ? 'text' : 'password';
    }
}

// Vincular evento para mostrar contraseñas
document.addEventListener('DOMContentLoaded', () => {
    const checkbox = document.querySelector('#verPassw'); // Checkbox para mostrar contraseña
    if (checkbox) {
        checkbox.addEventListener('change', mostrarPassw); // Vincula el evento
    }
});

//----------------VERIFICAR CAMPOS VACÍOS
function verificarCampo(inputSelector, mensajeSelector) {
    const input = document.querySelector(inputSelector);
    const mensaje = document.querySelector(mensajeSelector);

    if (input && mensaje) {
        input.addEventListener('blur', () => {
            mensaje.style.display = input.value.trim() === '' ? 'inline' : 'none';
        });
    }
}

function verificarCamposParaBoton(inputNombre, inputPassw, boton) {
    const input1 = document.querySelector(inputNombre);
    const input2 = document.querySelector(inputPassw);
    const submit = document.querySelector(boton);

    const verificarEstadoBoton = () => {
        if (input1.value.trim() && input2.value.trim()) {
            submit.disabled = false;
        } else {
            submit.disabled = true;
        }
    };

    if (input1 && input2 && submit) {
        input1.addEventListener('blur', verificarEstadoBoton);
        input2.addEventListener('blur', verificarEstadoBoton);
    }
}

verificarCampo('#nombreUsuario', '.nombreUsuarioValidacion');
verificarCampo('#passw', '.passwUsuarioValidacion');
verificarCamposParaBoton('#nombreUsuario', '#passw', '#iniciarSesionAdmin');

//----------------REVISAR MEDIANTE FETCH USUARIO Y CONTRASEÑA
// ADMIN
document.getElementById('formularioLoginAdmin').addEventListener('submit', async (event) => {
    event.preventDefault(); // Evita que la página se recargue cuando se envía el formulario.

    const nombreUsuario = document.getElementById('nombreUsuario').value;
    const passlogin = document.getElementById('passw').value;

    if (nombreUsuario && passlogin) {
        // Llama al método del controlador para manejar la lógica de inicio de sesión
        controlador.cIniciarSesion(nombreUsuario, passlogin);
    } else {
        console.error('Faltan campos por completar.');
    }
});
