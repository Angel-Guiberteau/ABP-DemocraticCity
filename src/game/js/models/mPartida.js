export class MPartida {
    constructor() {}
    async mCrearSala(formData){
        try {
            const response = await fetch('index.php?c=Partida&m=cCrearSala', {
                method: 'POST',  
                body: formData,  
            });
            if(response.ok) {
                const result = await response.text();
                if (result=='correcto') {
                    window.location.href = "index.php?c=Partida&m=mostrarSalaAnfitrion"; 
                } else {
                    alert('algo salio mal');//NO QUIERO REEDIRECCIONAR SINO PONER UN PARRAFO CON UN ERROR
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


    async mEliminarSala(formData){
        try {
            const response = await fetch('index.php?c=Partida&m=cEliminarSala', {
                method: 'POST',  
                body: formData,  
            });
            
            if(response.ok) {
                const result = await response.text();
                
                if (result=='correcto') {

                    window.location.href = "index.php?c=Usuarios&m=mostrarInicio"; 
                } else {
                    alert('algo salio mal');//NO QUIERO REEDIRECCIONAR SINO PONER UN PARRAFO CON UN ERROR
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
    async mUnirseSala(formData){
        try {
            const response = await fetch('index.php?c=Partida&m=cUnirseSala', {
                method: 'POST',  
                body: formData,  
            });           
            if(response.ok) {
                const result = await response.text();

                if (result=='correcto') {
                    window.location.href = "index.php?c=Partida&m=mostrarSalaUsuario"; 
                } else {
                    alert('Algo salio mal');//NO QUIERO REEDIRECCIONAR SINO PONER UN PARRAFO CON UN ERROR
                }  
            } else {
                alert('Algo salio mal');
            }
            
        } catch (error) {  // Si ocurre un error al hacer la solicitud al servidor.
            console.error('Error:', error);  // Muestra el error en la consola para depuración.
            document.getElementById('resultado').innerText = 'Error de conexión.';  // Muestra un mensaje de error al usuario.
            resultado.style.color = 'red';
        }
    }

    async mMostrarJugadores(formData, parrafoJugadores){
        try {
            const response = await fetch('index.php?c=Partida&m=cMostrarJugadores', {
                method: 'POST',  
                body: formData,  
            });
            
            if(response.ok) {
                const result = await response.json();
                 // Inicializa una variable para acumular los nombres
                    if(result != 'incorrecto'){
                        let jugadoresHTML = '';
                        result.forEach((nombreJugador, index) => {
                            jugadoresHTML += nombreJugador;
                            if (index < result.length - 1) {
                                jugadoresHTML += ' - ';
                            }
                        });
                        parrafoJugadores.innerHTML = jugadoresHTML;
                    }else{
                        let jugadoresHTML = '';
                        parrafoJugadores.innerHTML = 'No hay jugadores en la sala';
                    }
                
            } else {
                alert('Algo salio mal');
            }
            
        } catch (error) {  // Si ocurre un error al hacer la solicitud al servidor.
            console.error('Error:', error);  // Muestra el error en la consola para depuración.
            document.getElementById('resultado').innerText = 'Error de conexión.';  // Muestra un mensaje de error al usuario.
            resultado.style.color = 'red';
        }
    }
    async mEliminarUsuarioPartida(formData){

        try {
            const response = await fetch('index.php?c=Partida&m=cEliminarUsuarioPartida', {
                method: 'POST',  
                body: formData,  
            });
            if(response.ok) {
                const result = await response.text();                
                if (result=='correcto') {
                    window.location.href = "index.php?c=Usuarios&m=mostrarInicioJuego"; 
                } else {
                    alert('Algo salio mal');//NO QUIERO REEDIRECCIONAR SINO PONER UN PARRAFO CON UN ERROR
                }  
            } else {
                alert('Algo salio mal');
            }
            
        } catch (error) {  // Si ocurre un error al hacer la solicitud al servidor.
            console.error('Error:', error);  // Muestra el error en la consola para depuración.
            document.getElementById('resultado').innerText = 'Error de conexión.';  // Muestra un mensaje de error al usuario.
            resultado.style.color = 'red';
        }
    }
}