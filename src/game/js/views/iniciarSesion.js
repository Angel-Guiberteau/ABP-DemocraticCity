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
        const response = await fetch('index.php?c=Usuarios&m=inicio', {  // Cambiar "servidorlogin.php".
            method: 'POST',  // Usamos el método POST para enviar los datos.
            body: formData,  // Enviamos los datos en el cuerpo de la solicitud.
        });

        // Verifica si la respuesta del servidor es buena .
        if(response.ok) {
            const result = await response.text(); // Lee la respuesta que el servidor envía como texto.

            // Si la respuesta es "Usuario autenticado correctamente", muestra el mensaje y redirige.
            if (result=='correcto') {
                window.location.href = "index.php?c=Usuarios&m=mostrarInicio"; // Cambia la página si la autenticación es exitosa.
            } else {
                const error = document.querySelector('.loginIncorrecto');
                if(result == 'PasswIncorrecta'){
                    error.innerHTML = 'Contraseña incorrecta';
                }else{
                    error.innerHTML = 'Error inesperado';
                }
                document.querySelector('.loginIncorrecto').style.display = 'inline'; 
            }
        } else {
            // Si la respuesta del servidor no fue exitosa dará un error.
            let error = document.querySelector('.loginIncorrecto');
            error.innerHTML = 'ERROR AL CONECTAR CON EL SERVIDOR. Inténtelo de nuevo más tarde.'
            error.style.display = 'inline'; ;
        }
    } catch (error) {  // Si ocurre un error al hacer la solicitud al servidor.
        console.error('Error:', error);  // Muestra el error en la consola para depuración.
        document.getElementById('resultado').innerText = 'Error de conexión.';  // Muestra un mensaje de error al usuario.
        resultado.style.color = 'red';
    }
});