//----------------MOSTRAR CONTRASEÑAS
function mostrarPassw() {
    let contrasenia1 = document.getElementById('passw');
    let contrasenia2 = document.getElementById('rpassw');

    let checkbox = document.querySelector('#verPassw');
    let tipo = checkbox.checked ? "text" : "password";

    if (contrasenia1) contrasenia1.type = tipo;
    if (contrasenia2) contrasenia2.type = tipo;
}
document.addEventListener("DOMContentLoaded", function () {
    

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

    //----------------VERIFICAR SEGUNDA CONTRASEÑA IGUAL
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
    // Validaciones de campos
    verificarCampo('#nombre', '.nombreUsuarioValidacion');
    verificarCampo('#passw', '.passwUsuarioValidacion');
    verificarCampo('#rpassw', '.rpasswUsuarioValidacion');
    repetirPassw('#passw', '#rpassw', '.rpasswUsuarioValidacion');
});
