//----------------MOSTRAR CONTRASEÑAS
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

//metodo validar campos vacios


//----------------REVISAR MEDIANTE FETCH USUARIO Y CONTRASEÑA
//ADMIN
document.getElementById('formularioLoginAdmin').addEventListener('submit', async function (event) { 
    event.preventDefault(); // Evita que la página se recargue cuando se envía el formulario.

    // Obtiene los valores que el usuario ingresó en los campos del formulario.
    let nombreUsuario = document.getElementById('nombreUsuario').value;  
    let passlogin = document.getElementById('passw').value; 

    // Crea un objeto FormData que se utilizará para enviar los datos del formulario al servidor.
    let formData = new FormData(); 
    formData.append('usuario', nombreUsuario); 
    formData.append('passw', passlogin); 

    // Intenta enviar los datos al servidor mediante una solicitud fetch. 
    try {
        const response = await fetch('../index.php?c=Usuarios&m=inicio', {  // Cambiar "servidorlogin.php".
            method: 'POST',  // Usamos el método POST para enviar los datos.
            body: formData,  // Enviamos los datos en el cuerpo de la solicitud.
        });

        // Verifica si la respuesta del servidor es buena .
        if(response.ok) {
            const result = await response.text(); // Lee la respuesta que el servidor envía como texto.

            // Si la respuesta es "Usuario autenticado correctamente", muestra el mensaje y redirige.
            if (result!=false) {
                window.location.href = "vistaInicio.html"; // Cambia la página si la autenticación es exitosa.
            } else {
                document.querySelector('.loginIncorrecto').style.display = 'inline'; 
            }
        } else {
            // Si la respuesta del servidor no fue exitosa dará un error.
            let error = document.querySelector('.loginIncorrecto');
            error.innerHTML = 'ERROR AL CONECTAR CON EL SERVIDOR. Innténtelo de nuevo más tarde.'
            error.style.display = 'inline'; ;
        }
    } catch (error) {  // Si ocurre un error al hacer la solicitud al servidor.
        console.error('Error:', error);  // Muestra el error en la consola para depuración.
        document.getElementById('resultado').innerText = 'Error de conexión.';  // Muestra un mensaje de error al usuario.
        resultado.style.color = 'red';
    }
});

//USER
document.getElementById('formularioLoginUser').addEventListener('submit', async function (event) { 
    event.preventDefault(); // Evita que la página se recargue cuando se envía el formulario.

    // Obtiene los valores que el usuario ingresó en los campos del formulario.
    let nombreUsuario = document.getElementById('nombreUsuario').value;  
    let passlogin = document.getElementById('passw').value; 

    // Crea un objeto FormData que se utilizará para enviar los datos del formulario al servidor.
    let formData = new FormData(); 
    formData.append('usuario', nombreUsuario); 
    formData.append('passw', passlogin); 

    // Intenta enviar los datos al servidor mediante una solicitud fetch. 
    try {
        const response = await fetch('../index.php?c=Usuarios&m=inicio', {  // Cambiar "servidorlogin.php".
            method: 'POST',  // Usamos el método POST para enviar los datos.
            body: formData,  // Enviamos los datos en el cuerpo de la solicitud.
        });

        // Verifica si la respuesta del servidor es buena .
        if(response.ok) {
            const result = await response.text(); // Lee la respuesta que el servidor envía como texto.

            // Si la respuesta es "Usuario autenticado correctamente", muestra el mensaje y redirige.
            if (result!=false) {
                window.location.href = "vistaInicio.html"; // Cambia la página si la autenticación es exitosa.
            } else {
                document.querySelector('.loginIncorrecto').style.display = 'inline'; 
            }
        } else {
            // Si la respuesta del servidor no fue exitosa dará un error.
            let error = document.querySelector('.loginIncorrecto');
            error.innerHTML = 'ERROR AL CONECTAR CON EL SERVIDOR. Innténtelo de nuevo más tarde.'
            error.style.display = 'inline'; ;
        }
    } catch (error) {  // Si ocurre un error al hacer la solicitud al servidor.
        console.error('Error:', error);  // Muestra el error en la consola para depuración.
        document.getElementById('resultado').innerText = 'Error de conexión.';  // Muestra un mensaje de error al usuario.
        resultado.style.color = 'red';
    }
});