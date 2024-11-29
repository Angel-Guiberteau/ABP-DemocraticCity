// Validaciones DIWEC: Ismael Paz Bernal. 

// Agrega un evento al formulario que se ejecuta al intentar enviarlo.
document.getElementById('Formulario').addEventListener('submit', async function (event) { 
event.preventDefault(); // Prevenir que la página se recargue automáticamente.
   
  // Obtener los valores de los campos de texto del formulario.
  let nombre = document.getElementById('nombre').value;
  let contrasenia1 = document.getElementById('contrasenia1').value;
  let contrasenia2 = document.getElementById('contrasenia2').value;

  //Valida si los campos estan vacíos.
  if (nombre==='' ||contrasenia1 === '' || contrasenia2 === ''  ){
    document.getElementById('resultado').innerText = 'Campos vacíos, Tienes que completar los campos.';
    resultado.style.color = 'red';
    return; 
  }


  //Verifica si las contraseñas coinciden.
  if (contrasenia1 !== contrasenia2) {
    resultado.textContent = 'Error: Las contraseñas no coinciden.';
    resultado.style.color = 'red';
    return; 
  }

  // Crea un objeto FormData para enviar los datos del formulario.
  let formData = new FormData(); 
  formData.append('nombre', nombre);
  formData.append('contrasenia2', contrasenia2);

  // Intenta enviar los datos al servidor mediante una solicitud fetch, Cambiar el nombre del servidor.php por otro.
  try {
    const response = await fetch('servidorRegistro.php', {
      method: 'POST',
      body: formData,
    });

    // Verifica si la respuesta del servidor es exitosa.
    if (response.ok) {
      const result = await response.text(); // Lee la respuesta del servidor como texto 
      // Muestra la respuesta del servidor en el elemento con id 'resultado', quitar para que no aparezca
      document.getElementById('resultado').innerText = `Respuesta del servidor: ${result}`;
    } else {
      // Muestra un mensaje de error si la respuesta no es exitosa
      document.getElementById('resultado').innerText = 'Error al enviar los datos';
      resultado.style.color = 'red';
    }
  } catch (error) {
    // Muestra un mensaje de error en caso de fallo de conexión
    console.error('Error:', error);
    document.getElementById('resultado').innerText = 'Error de conexión';
    resultado.style.color = 'red';
  }
});

// Esto hace que muestre o oculte la contraseña al marcar o desmarcar el checkbox
document.getElementById('VerContraseña').addEventListener('change', function(){
  let contrasenia1 = document.getElementById('contrasenia1');
  let contrasenia2 = document.getElementById('contrasenia2'); 
  if (this.checked) {
    contrasenia1.type = 'text';
    contrasenia2.type = 'text';
  }else {
    contrasenia1.type = 'password'; 
    contrasenia2.type = 'password';        
  }

});