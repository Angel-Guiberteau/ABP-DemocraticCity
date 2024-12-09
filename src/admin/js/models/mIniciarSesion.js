export class MIniciarSesion {
    constructor() {}
    async mIniciarSesion(formData){
        try {
            const response = await fetch('index.php?c=Usuarios&m=inicioAdm', {
                method: 'POST',  // Usamos el método POST para enviar los datos.
                body: formData,  // Enviamos los datos en el cuerpo de la solicitud.
            });
    
            // Verifica si la respuesta del servidor es buena .
            if(response.ok) {
                const result = await response.text(); // Lee la respuesta que el servidor envía como texto.
                // Si la respuesta es "Usuario autenticado correctamente", muestra el mensaje y redirige.
                if (result=='correcto') {
                    window.location.href = "index.php?c=Usuarios&m=mostrarPanel"; 
                    // Cambia la página si la autenticación es exitosa
                } else {
                    if(result=='SUPER'){
                        window.location.href = "index.php?c=Usuarios&m=mostrarPanelSuper"; 
                    }else{
                        const error = document.querySelector('.loginIncorrecto');
                        if(result == 'PasswIncorrecta'){
                            error.innerHTML = 'Contraseña incorrecta';
                        }else{
                            error.innerHTML = 'Error inesperado';
                        }
                        document.querySelector('.loginIncorrecto').style.display = 'inline'; 
                    }
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
    }
}