import { CIniciarSesion } from '../controllers/cIniciarSesion.js';
const controlador = new CIniciarSesion();

//----------------MOSTRAR CONTRASEÑAS
/**
 * Este método permite mostrar las contraseñas.
 */
function mostrarPassw(){
    let passlogin = document.querySelector('#passw');
        
    let checkbox = document.querySelector('#verPassw');
    passlogin.type = checkbox.checked ? "text" : "password";
}

//----------------VERIFICAR CAMPOS VACÍOS
function verificarCampo(inputSelector, mensajeSelector) {
    let input = document.querySelector(inputSelector);
    let mensaje = document.querySelector(mensajeSelector);

    if (input && mensaje) {
        input.addEventListener("blur", function () {
            mensaje.style.display = input.value.trim() === '' ? 'inline' : 'none';
        });
    }
}
function verificarCamposParaBoton(inputNombre, inputPassw, boton){
    let input1 = document.querySelector(inputNombre);
    let input2 = document.querySelector(inputPassw);
    let submit = document.querySelector(boton);

    input1.addEventListener('blur', function(){
        if(input1.value.trim()!= '' && input2.value.trim() != ''){
            submit.disabled = false;
        }else{
            submit.disabled = true;
        }
    });
    input2.addEventListener('blur', function(){
        if(input1.value.trim()!= '' && input2.value.trim() != ''){
            submit.disabled = false;
        }else{
            submit.disabled = true;
        }
    });
    
}

verificarCampo('#nombreUsuario', '.nombreUsuarioValidacion');
verificarCampo('#passw', '.passwUsuarioValidacion');
verificarCamposParaBoton('#nombreUsuario', '#passw', '#iniciarSesion');
verificarCamposParaBoton('#nombreUsuario', '#passw', '#iniciarSesionAdmin');

//----------------REVISAR MEDIANTE FETCH USUARIO Y CONTRASEÑA
//ADMIN
document.getElementById('formularioLoginAdmin').addEventListener('submit', async function (event) { 
    event.preventDefault(); // Evita que la página se recargue cuando se envía el formulario.

    // Obtiene los valores que el usuario ingresó en los campos del formulario.
    let nombreUsuario = document.getElementById('nombreUsuario').value;  
    let passlogin = document.getElementById('passw').value; 

    // Crea un objeto FormData que se utilizará para enviar los datos del formulario al servidor.
    controlador.cIniciarSesion(nombreUsuario, passlogin);

    // Intenta enviar los datos al servidor mediante una solicitud fetch. 
    
});