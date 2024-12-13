import { CIniciarSesion } from '../controllers/cIniciarSesion.js';
const controlador = new CIniciarSesion();


//----------------MOSTRAR CONTRASEÑAS
function mostrarPassw(){
    let passlogin = document.querySelector('#passw');
        
    let checkbox = document.querySelector('#verPassw');
    passlogin.type = checkbox.checked ? "text" : "password";
}
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
        input.addEventListener("blur", () => {
            mensaje.style.display = input.value.trim() === '' ? 'inline' : 'none';
        });
    } else {
        console.warn(`Elementos no encontrados: ${inputSelector} o ${mensajeSelector}`);
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

function verificarCamposParaBoton(inputSelectors, boton) {
    const inputs = inputSelectors.map(selector => document.querySelector(selector)).filter(Boolean);

    if (inputs.length === inputSelectors.length) {
        inputs.forEach(input => {
            input.addEventListener('input', () => actualizarEstadoBoton(inputSelectors, boton));
            input.addEventListener('blur', () => actualizarEstadoBoton(inputSelectors, boton));
        });

        // Verificar estado inicial del botón
        actualizarEstadoBoton(inputSelectors, boton);
    } else {
        console.warn('No se encontraron todos los inputs especificados:', inputSelectors);
    }
}

//----------------EJECUTAR
document.addEventListener('DOMContentLoaded', () => {
    verificarCampo('#nombreUsuario', '.nombreUsuarioValidacion');
    verificarCampo('#passw', '.passwUsuarioValidacion');
    verificarCamposParaBoton(['#nombreUsuario', '#passw'], '#iniciarSesion');
});

//----------------REVISAR MEDIANTE FETCH USUARIO Y CONTRASEÑA
//USER
document.getElementById('formularioLoginUser').addEventListener('submit', async function (event) { 
    event.preventDefault();

    let nombreUsuario = document.getElementById('nombreUsuario').value;  
    let passlogin = document.getElementById('passw').value; 
    controlador.cIniciarSesion(nombreUsuario, passlogin);
    // let formData = new FormData(); 
    // formData.append('usuario', nombreUsuario); 
    // formData.append('passw', passlogin); 

    
});