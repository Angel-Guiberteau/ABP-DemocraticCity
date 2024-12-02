//----------------MOSTRAR CONTRASEÑAS
// Función para alternar entre mostrar u ocultar la contraseña en el campo de entrada.
function mostrarPassw() {
    let passlogin = document.querySelector('#passw'); // Obtiene el campo de la contraseña.
    let checkbox = document.querySelector('#verPassw'); // Obtiene el checkbox para controlar la visibilidad.
    // Cambia el tipo del campo de contraseña según el estado del checkbox (text o password).
    passlogin.type = checkbox.checked ? "text" : "password"; 
}

//----------------VERIFICAR CAMPOS VACÍOS
// Función que verifica si un campo está vacío y muestra un mensaje de advertencia si es necesario.
function verificarCampo(inputSelector, mensajeSelector) {
    let input = document.querySelector(inputSelector); // Obtiene el campo de entrada específico.
    let mensaje = document.querySelector(mensajeSelector); // Obtiene el elemento del mensaje de advertencia.

    if (input && mensaje) { // Verifica que ambos elementos existan.
        // Agrega un evento que se activa cuando el campo pierde el foco.
        input.addEventListener("blur", function () {
            // Si el campo está vacío, muestra el mensaje; si no, lo oculta.
            mensaje.style.display = input.value.trim() === '' ? 'inline' : 'none';
        });
    }
}

//----------------REVISAR MEDIANTE FETCH USUARIO Y CONTRASEÑA (ADMIN)
// Evento para manejar el formulario de login del administrador.
document.getElementById('formularioLoginAdmin').addEventListener('submit', async function (event) { 
    event.preventDefault(); // Evita que el formulario recargue la página al enviarse.

    // Obtiene los valores ingresados en los campos de usuario y contraseña.
    let nombreUsuario = document.getElementById('nombreUsuario').value; 
    let passlogin = document.getElementById('passw').value; 

    // Crea un objeto FormData para enviar los datos al servidor.
    let formData = new FormData(); 
    formData.append('usuario', nombreUsuario); // Agrega el usuario.
    formData.append('passw', passlogin); // Agrega la contraseña.

    try {
        // Envía los datos al servidor mediante una solicitud POST con fetch.
        const response = await fetch('../index.php?c=Usuarios&m=registrarAdm', { 
            method: 'POST', 
            body: formData, 
        });

        if (response.ok) { // Verifica si la respuesta del servidor fue exitosa.
            const result = await response.text(); // Obtiene la respuesta del servidor como texto.

            if (result != false) { // Si el servidor indica autenticación exitosa.
                window.location.href = "vistaInicio.html"; // Redirige a la página de inicio.
            } else {
                // Si las credenciales son incorrectas, muestra un mensaje de error.
                document.querySelector('.loginIncorrecto').style.display = 'inline'; 
            }
        } else {
            // Si el servidor devuelve un error, muestra un mensaje al usuario.
            let error = document.querySelector('.loginIncorrecto');
            error.innerHTML = 'ERROR AL CONECTAR CON EL SERVIDOR. Inténtelo de nuevo más tarde.';
            error.style.display = 'inline'; 
        }
    } catch (error) { // Maneja errores relacionados con la conexión.
        console.error('Error:', error); // Muestra el error en la consola.
        let resultado = document.getElementById('resultado'); // Obtiene el contenedor para mensajes.
        resultado.innerText = 'Error de conexión.'; // Muestra un mensaje de error al usuario.
        resultado.style.color = 'red'; 
    }
});

//----------------REVISAR MEDIANTE FETCH USUARIO Y CONTRASEÑA (USER)
// Evento para manejar el formulario de login del usuario (similar al de admin).
document.getElementById('formularioLoginUser').addEventListener('submit', async function (event) { 
    event.preventDefault(); // Evita que el formulario recargue la página al enviarse.

    // Obtiene los valores ingresados en los campos de usuario y contraseña.
    let nombreUsuario = document.getElementById('nombreUsuario').value; 
    let passlogin = document.getElementById('passw').value; 

    // Crea un objeto FormData para enviar los datos al servidor.
    let formData = new FormData(); 
    formData.append('usuario', nombreUsuario); // Agrega el usuario.
    formData.append('passw', passlogin); // Agrega la contraseña.

    try {
        // Envía los datos al servidor mediante una solicitud POST con fetch.
        const response = await fetch('../index.php?c=Usuarios&m=inicio', { 
            method: 'POST', 
            body: formData, 
        });

        if (response.ok) { // Verifica si la respuesta del servidor fue exitosa.
            const result = await response.text(); // Obtiene la respuesta del servidor como texto.

            if (result != false) { // Si el servidor indica autenticación exitosa.
                window.location.href = "vistaInicio.html"; // Redirige a la página de inicio.
            } else {
                // Si las credenciales son incorrectas, muestra un mensaje de error.
                document.querySelector('.loginIncorrecto').style.display = 'inline'; 
            }
        } else {
            // Si el servidor devuelve un error, muestra un mensaje al usuario.
            let error = document.querySelector('.loginIncorrecto');
            error.innerHTML = 'ERROR AL CONECTAR CON EL SERVIDOR. Inténtelo de nuevo más tarde.';
            error.style.display = 'inline'; 
        }
    } catch (error) { // Maneja errores relacionados con la conexión.
        console.error('Error:', error); // Muestra el error en la consola.
        let resultado = document.getElementById('resultado'); // Obtiene el contenedor para mensajes.
        resultado.innerText = 'Error de conexión.'; // Muestra un mensaje de error al usuario.
        resultado.style.color = 'red'; 
    }
});
