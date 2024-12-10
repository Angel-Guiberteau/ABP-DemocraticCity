export class MIniciarSesion {
    constructor() {}
    async mIniciarSesion(formData){
        try {
            const response = await fetch('index.php?c=Partida&m=cCrearSala', {
                method: 'POST',  // Usamos el método POST para enviar los datos.
                body: formData,  // Enviamos los datos en el cuerpo de la solicitud.
            });
            return response;
            // Verifica si la respuesta del servidor es buena .
            
        } catch (error) {  // Si ocurre un error al hacer la solicitud al servidor.
            console.error('Error:', error);  // Muestra el error en la consola para depuración.
            document.getElementById('resultado').innerText = 'Error de conexión.';  // Muestra un mensaje de error al usuario.
            resultado.style.color = 'red';
        }
    }
}