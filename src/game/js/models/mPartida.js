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
                if (result.trim()=='correcto') {
                    window.location.href = "index.php?c=Partida&m=mostrarSalaAnfitrion"; 
                } else {
                    alert('Error al ccrear sala');//NO QUIERO REEDIRECCIONAR SINO PONER UN PARRAFO CON UN ERROR
                }  
            } else {
                // Si la respuesta del servidor no fue exitosa dará un error.
                let error = document.querySelector('.loginIncorrecto');
                error.innerHTML = 'ERROR AL CONECTAR CON EL SERVIDOR. Inténtelo de nuevo más tarde.'
                error.style.display = 'inline'; ;
            }
            
        } catch (error) {  // Si ocurre un error al hacer la solicitud al servidor.
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
                
                if (result.trim() =='correcto') {

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
    async mUnirseSala(formData, parrafo){
        try {
            const response = await fetch('index.php?c=Partida&m=cUnirseSala', {
                method: 'POST',  
                body: formData,  
            });           
            if(response.ok) {
                const result = await response.text();
                if(result.trim() == 'correcto')
                    window.location.href = "index.php?c=Partida&m=mostrarSalaUsuario";
                else
                {
                    parrafo.innerHTML = 'Código de sala incorrecto o sala ya comenzada';
                    parrafo.style.display = 'block';
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
                if (result.trim()=='correcto') {
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

    async mSalaEliminada(formData, modal) {
        
        try {
            // Realizamos la solicitud fetch para comprobar si la partida ha sido eliminada
            const response = await fetch('index.php?c=Partida&m=cComprobarPartidaEliminada', {
                method: 'POST',
                body: formData,
            });
            
            if (response.ok) {
                const result = await response.text();
                                
                // Si la respuesta es 'correcto', mostramos el modal
                if (result.trim() === 'correcto') {
                    modal.style.display = 'flex';
                } 
    
            }
            
        } catch (error) {
            console.error('Error al comprobar la eliminación de la sala', error);
        }
    }
    async mSalaEmpezada(formData) {        
        console.log('modelo');

        try {
            // Realizamos la solicitud fetch para comprobar si la partida ha sido eliminada
            const response = await fetch('index.php?c=Partida&m=cComprobarPartidaEmpezada', {
                method: 'POST',
                body: formData,
            });
            
            if (response.ok) {
                const result = await response.text();
                console.log(result);

                if (result.trim() === 'correcto') {
                    window.location.href = "index.php?c=Partida&m=mostrarJuegoUsuario";
                }
            }
            
        } catch (error) {
            console.error('Error al comprobar la eliminación de la sala', error);
        }
    }
    async mEmpezarPartida(formData) {        
        try {
            // Realizamos la solicitud fetch para comprobar si la partida ha sido eliminada
            const response = await fetch('index.php?c=Partida&m=cEmpezarPartida', {
                method: 'POST',
                body: formData,
            });
            
            if (response.ok) {
                const result = await response.text();
                if (result.trim() === 'correcto') {
                    window.location.href = "index.php?c=Partida&m=mostrarJuegoAnfitrion";
                }else{
                    alert('Upss... Hubo un error al iniciar la partida');
                }
            }
            
        } catch (error) {
            console.error('Error al comprobar la eliminación de la sala', error);
        }
    }
    async mMostrarPreguntaAnfitrion(formData, pregunta, respuesta1, respuesta2, respuesta3, respuesta4) {   
        try {
            // Realizamos la solicitud fetch para comprobar si la partida ha sido eliminada
            const response = await fetch('index.php?c=Partida&m=cMostrarPreguntas', {
                method: 'POST',
                body: formData,
                
            });
            
            if (response.ok) {
                const result = await response.text();
                console.log(result);
                let data = JSON.parse(result);
                console.log(data);
                
                pregunta.innerHTML = data.pregunta;
                respuesta1.textContent = `${data.respuestas[0].letra}: ${data.respuestas[0].texto}`; // Respuesta A
                respuesta2.textContent = `${data.respuestas[1].letra}: ${data.respuestas[1].texto}`; // Respuesta B
                respuesta3.textContent = `${data.respuestas[2].letra}: ${data.respuestas[2].texto}`; // Respuesta C
                respuesta4.textContent = `${data.respuestas[3].letra}: ${data.respuestas[3].texto}`; // Respuesta D
            }
            
        } catch (error) {
            console.error('Error: ', error);
        }
    }
    async mMostrarPreguntaUsuario(formData, pregunta, respuesta1, respuesta2, respuesta3, respuesta4, modalInicioJuego) {   
        try {
            const response = await fetch('index.php?c=Partida&m=cMostrarPreguntasUsuario', {
                method: 'POST',
                body: formData,
                
            });
            
            if (response.ok) {
                const result = await response.text();
                let data = JSON.parse(result);
                pregunta.innerHTML = data.pregunta;
                respuesta1.textContent = `${data.respuestas[0].letra}: ${data.respuestas[0].texto}`; // Respuesta A
                respuesta2.textContent = `${data.respuestas[1].letra}: ${data.respuestas[1].texto}`; // Respuesta B
                respuesta3.textContent = `${data.respuestas[2].letra}: ${data.respuestas[2].texto}`; // Respuesta C
                respuesta4.textContent = `${data.respuestas[3].letra}: ${data.respuestas[3].texto}`; // Respuesta D
                modalInicioJuego.style.display = 'none';
            }
            
        } catch (error) {
            console.error('esperando pregunta', error);
        }
    }
    async mEnviarVoto(formData) {   
        try {
            const response = await fetch('index.php?c=Partida&m=cEnviarVoto', {
                method: 'POST',
                body: formData,
                
            });
            
            if (response.ok){
                const result = await response.text();
            }
                
            
        } catch (error) {
            
        }
    }
    
    
}