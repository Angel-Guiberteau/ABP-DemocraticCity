//----------------MOSTRAR CONTRASEÑAS
function mostrarPassw() {
    let passlogin1 = document.querySelector('#passw');
    let passlogin2 = document.querySelector('#rpassw');

    let checkbox = document.querySelector('#verPassw');

    passlogin1.type = checkbox.checked ? "text" : "password";
    passlogin2.type = checkbox.checked ? "text" : "password";
}

document.addEventListener("DOMContentLoaded", function () {
    
    //---------------- VERIFICAR CAMPOS VACÍOS
    function verificarCampo(inputSelector, mensajeSelector) {
        let input = document.querySelector(inputSelector);
        let mensaje = document.querySelector(mensajeSelector);

        if (input && mensaje) {
            input.addEventListener("blur", function () {
                mensaje.style.display = input.value.trim() === '' ? 'inline' : 'none';
            });
        }
    }

    //---------------- VERIFICAR SEGUNDA CONTRASEÑA IGUAL AL ANTERIOR
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
});


document.getElementById('registroAdmin').addEventListener('submit', async function (event){

    event.preventDefault(); // Evita que la página se recargue cuando se envía el formulario.

    // Obtiene los valores que el usuario ingresó en los campos del formulario.

    let nombreUsuario = document.getElementById('nombre').value;
    let passlogin = document.getElementById('passw').value;
    let passlogin2 = document.getElementById('rpassw').value;

    let formData = new FormData();
    formData.append('usuario', nombreUsuario);
    formData.append('passw', passlogin);
    formData.append('rpassw', passlogin2);

    //Enviar los datos al servidor mediantes fetch.

    try{
        const response = await fetch('../index.php?c=Usuarios&m=registrarAdm',{ //CAMBIAR SERVIDOR
            method: 'POST', //Usamos post para enviar datos
            body: formData, //Enviamos datos en el body de la solicitud
        });

        if(response.ok){
            const result = await response.text();
            if(result != false){
                window.location.href = "vistaInicio.html";
            }else{
                document.querySelector('.registroIncorrecto').style.display = 'inline';
            }
        }else{
            let error = document.querySelector('.registroIncorrecto');
            error.innerHTML = 'ERROR AL CONECTAR CON EL SERVIDOR. Inténtelo de nuevo más tarde.';
            error.style.display = 'inline';
        }
    }catch(error){
        console.log(error);
        document.getElementById('resultado').innerText = 'Error de conexión.';  // Muestra un mensaje de error al usuario.
        resultado.style.color = 'red';
    }
});

document.getElementById('registroUser').addEventListener('submit', async function (event){

    event.preventDefault(); // Evita que la página se recargue cuando se envía el formulario.

    // Obtiene los valores que el usuario ingresó en los campos del formulario.

    let nombreUsuario = document.getElementById('nombre').value;
    let passlogin = document.getElementById('passw').value;
    let passlogin2 = document.getElementById('rpassw').value;

    let formData = new FormData();
    formData.append('usuario', nombreUsuario);
    formData.append('passw', passlogin);
    formData.append('rpassw', passlogin2);

    //Enviar los datos al servidor mediantes fetch.

    try{
        const response = await fetch('index.php?c=Usuarios&m=registrar',{ //CAMBIAR SERVIDOR
            method: 'POST', //Usamos post para enviar datos
            body: formData, //Enviamos datos en el body de la solicitud
        });

        if(response.ok){
            const result = await response.text();
            if(result != 'incorrecto'){
                // window.location.href = "index.php?c=Usuarios&m=predeterminada";
                document.querySelector('.registroIncorrecto').style.display = 'inline';
            }else{
                document.querySelector('.registroIncorrecto').style.display = 'inline';
            }
        }else{
            let error = document.querySelector('.registroIncorrecto');
            error.innerHTML = 'ERROR AL CONECTAR CON EL SERVIDOR. Inténtelo de nuevo más tarde.';
            error.style.display = 'inline';
        }
    }catch(error){
        console.log(error);
        document.getElementById('resultado').innerText = 'Error de conexión.';  // Muestra un mensaje de error al usuario.
        resultado.style.color = 'red';
    }
});