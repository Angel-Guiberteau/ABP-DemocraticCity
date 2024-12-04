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