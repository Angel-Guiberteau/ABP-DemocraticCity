import { CRegistrarse } from '../controllers/cRegistrarse.js';
const controlador = new CRegistrarse();
    //----------------MOSTRAR CONTRASEÑAS
    function mostrarPassw() {
        let passlogin1 = document.querySelector('#passw');
        let passlogin2 = document.querySelector('#rpassw');
    
        let checkbox = document.querySelector('#verPassw');
    
        passlogin1.type = checkbox.checked ? "text" : "password";
        passlogin2.type = checkbox.checked ? "text" : "password";
    }
    window.mostrarPassw = mostrarPassw;
    //----------------VERIFICAR CAMPOS VACÍOS
function verificarCampo(inputSelector, mensajeSelector) {
    const input = document.querySelector(inputSelector);
    const mensaje = document.querySelector(mensajeSelector);

    if (input && mensaje) {
        input.addEventListener("input", () => {
            mensaje.style.display = input.value.trim() === '' ? 'inline' : 'none';
        });
        input.addEventListener("blur", () => {
            mensaje.style.display = input.value.trim() === '' ? 'inline' : 'none';
        });
    } else {
        console.warn(`Elementos no encontrados: ${inputSelector} o ${mensajeSelector}`);
    }
}

//----------------VERIFICAR CONTRASEÑAS
function repetirPassw(inputPassw, inputrPassw, mensajeSelector) {
    const input = document.querySelector(inputPassw);
    const input2 = document.querySelector(inputrPassw);
    const mensaje = document.querySelector(mensajeSelector);

    if (input && input2 && mensaje) {
        const validar = () => {
            if (input2.value.trim() === '') {
                mensaje.style.display = 'inline';
                mensaje.textContent = 'Este campo no puede estar vacío';
            } else if (input.value !== input2.value) {
                mensaje.style.display = 'inline';
                mensaje.textContent = 'Las contraseñas no coinciden';
            } else {
                mensaje.style.display = 'none';
            }
        };

        input2.addEventListener("input", validar); // Validación en tiempo real
        input2.addEventListener("blur", validar); // Validación al perder el foco
    } else {
        console.warn(`Elementos no encontrados: ${inputPassw}, ${inputrPassw}, o ${mensajeSelector}`);
    }
}

//----------------HABILITAR/DESHABILITAR BOTÓN DE ENVÍO
function actualizarEstadoBoton(inputs, boton) {
    const allFilled = inputs.every(inputSelector => {
        const input = document.querySelector(inputSelector);
        return input && input.value.trim() !== '';
    });

    const submit = document.querySelector(boton);
    if (submit) {
        submit.disabled = !allFilled;
    } else {
        console.warn(`Botón no encontrado: ${boton}`);
    }
}

function verificarCampoBoton(inputNombre, inputPass, inputRPass, boton) {
    const inputSelectors = [inputNombre, inputPass, inputRPass];

    inputSelectors.forEach(selector => {
        const input = document.querySelector(selector);
        if (input) {
            input.addEventListener('input', () => actualizarEstadoBoton(inputSelectors, boton)); // Actualiza en tiempo real
            input.addEventListener('blur', () => actualizarEstadoBoton(inputSelectors, boton));  // Actualiza al perder foco
        }
    });

    // Verificar estado inicial del botón
    actualizarEstadoBoton(inputSelectors, boton);
}

//----------------EJECUTAR VALIDACIONES
document.addEventListener('DOMContentLoaded', () => {
    verificarCampo('#nombre', '.nombreUsuarioValidacion');
    verificarCampo('#passw', '.passwUsuarioValidacion');
    verificarCampo('#rpassw', '.rpasswUsuarioValidacion');
    repetirPassw('#passw', '#rpassw', '.rpasswUsuarioValidacion');
    verificarCampoBoton('#nombre', '#passw', '#rpassw', '#registroUser');
});

    document.getElementById('formularioRegistro').addEventListener('submit', async function (event){

        event.preventDefault(); // Evita que la página se recargue cuando se envía el formulario.
    
        // Obtiene los valores que el usuario ingresó en los campos del formulario.
    
        let nombreUsuario = document.getElementById('nombre').value;
        let passlogin = document.getElementById('passw').value;
        let passlogin2 = document.getElementById('rpassw').value;
    
        controlador.cRegistrarse(nombreUsuario, passlogin, passlogin2);
});



