// Validaciones DWENC: Ismael Paz Bernal.

// Agrega un evento al formulario que se ejecuta al intentar enviarlo.
document.getElementById('formulariologin').addEventListener('submit', async function (event) { 
    event.preventDefault(); // Evita que la página se recargue cuando se envía el formulario.

    // Obtiene los valores que el usuario ingresó en los campos del formulario.
    let nombre = document.getElementById('nombre').value;  
    let contrasenia = document.getElementById('contrasenia').value; 

    //Valida si los campos estan vacíos.
    if (nombre==='' ||contrasenia === '' ){
        document.getElementById('resultado').innerText = 'Los campos están vacíos, Tienes que completar los campos.';
        resultado.style.color = 'red';
        return; 
    }

    // Crea un objeto FormData que se utilizará para enviar los datos del formulario al servidor.
    let formData = new FormData(); 
    formData.append('nombre', nombre); 
    formData.append('contrasenia', contrasenia); 

    // Intenta enviar los datos al servidor mediante una solicitud fetch. 
    try {
        const response = await fetch('servidorlogin.php', {  // Cambiar "servidorlogin.php".
            method: 'POST',  // Usamos el método POST para enviar los datos.
            body: formData,  // Enviamos los datos en el cuerpo de la solicitud.
        });

        // Verifica si la respuesta del servidor es buena .
        if (response.ok) {
            const result = await response.text(); // Lee la respuesta que el servidor envía como texto.

            // Si la respuesta es "Usuario autenticado correctamente", muestra el mensaje y redirige.
            if (result === "Usuario autenticado correctamente") {
                document.getElementById('resultado').innerText = result; // Muestra un mensaje cuando ha habido exito con la respuesta.
                // Redirige al usuario a la página "democraticCity.html" después de que la autenticación sea exitosa.
                window.location.href = "democraticCity.html"; // Cambia la página si la autenticación es exitosa.
            } else {
                document.getElementById('resultado').innerText = result; // Si hay error, muestra el mensaje de error.
            }
        } else {
            // Si la respuesta del servidor no fue exitosa dará un error.
            document.getElementById('resultado').innerText = 'Error en la comunicación con el servidor.';
            resultado.style.color = 'red';
        }
    } catch (error) {  // Si ocurre un error al hacer la solicitud al servidor.
        console.error('Error:', error);  // Muestra el error en la consola para depuración.
        document.getElementById('resultado').innerText = 'Error de conexión.';  // Muestra un mensaje de error al usuario.
        resultado.style.color = 'red';
    }
});

// Esto hace que se muestre u oculte la contraseña cuando el usuario marca o desmarca el checkbox.
document.getElementById('VerContraseña').addEventListener('change', function() {
    let contrasenia = document.getElementById('contrasenia');  
    
    if (this.checked) {
        contrasenia.type = 'text';  
    } else {
        contrasenia.type = 'password';  
    }
});
