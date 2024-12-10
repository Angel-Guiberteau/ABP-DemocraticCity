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
    function verificarCampo(inputSelector, mensajeSelector) {
        let input = document.querySelector(inputSelector);
        let mensaje = document.querySelector(mensajeSelector);

        if (input && mensaje) {
            input.addEventListener("blur", function () {
                mensaje.style.display = input.value.trim() === '' ? 'inline' : 'none';
            });
        }
    }
    function repetirPassw(inputPassw, inputrPassw, mensajeSelector){
        let input = document.querySelector(inputPassw);
        let input2 = document.querySelector(inputrPassw);
        let mensaje = document.querySelector(mensajeSelector);
        if (input && input2 && mensaje) {
            input2.addEventListener("blur", function (){
                if(input2.value.trim() === ''){
                    mensaje.style.display = 'inline';
                    mensaje.textContent = 'Este campo no puede estar vacío';
                }else if(input.value != input2.value){
                    mensaje.style.display = 'inline';
                    mensaje.textContent = 'Las contraseñas no coinciden';
                }else{ mensaje.style.display = 'none'; }
            });
        }   
    }
    function verificarCampoBoton(inputNombre,inputPass,inputRPass,boton){
        let nombre = document.querySelector(inputNombre);
        let pass = document.querySelector(inputPass);
        let rpass = document.querySelector(inputRPass);
        let botonEnviar = document.querySelector(boton);
        
        nombre.addEventListener("blur", function(){
            if(nombre.value.trim() === '' || pass.value.trim() === '' || rpass.value.trim() === ''){
                botonEnviar.disabled = true;
            }else{
                botonEnviar.disabled = false;
            }
        });

        pass.addEventListener("blur", function(){
            if(nombre.value.trim() === '' || pass.value.trim() === '' || rpass.value.trim() === ''){
                botonEnviar.disabled = true;
            }else{
                botonEnviar.disabled = false;
            }
        });

        rpass.addEventListener("blur", function(){
            if(nombre.value.trim() === '' || pass.value.trim() === '' || rpass.value.trim() === ''){
                botonEnviar.disabled = true;
            }else{
                botonEnviar.disabled = false;
            }
        });
    }
     // Validaciones de campos
    verificarCampo('#nombre', '.nombreUsuarioValidacion');
    verificarCampo('#passw', '.passwUsuarioValidacion');
    verificarCampo('#rpassw', '.rpasswUsuarioValidacion');
    repetirPassw('#passw', '#rpassw', '.rpasswUsuarioValidacion');
    verificarCampoBoton('#nombre','#passw','#rpassw','#registroAdmin');
    verificarCampoBoton('#nombre','#passw','#rpassw','#registroUser');


    
/**
 * Este método permite registrar mediante asincronía. 
 */
document.getElementById('formularioRegistroAdmin').addEventListener('submit', async function (event){

    event.preventDefault(); // Evita que la página se recargue cuando se envía el formulario.

    // Obtiene los valores que el usuario ingresó en los campos del formulario.

    let nombreUsuario = document.getElementById('nombre').value;
    let passlogin = document.getElementById('passw').value;
    let passlogin2 = document.getElementById('rpassw').value;

    
    controlador.cRegistrarse(nombreUsuario, passw, rpassw);
    //Enviar los datos al servidor mediantes fetch.

    
});