document.addEventListener('DOMContentLoaded', function () {
    const boton = document.getElementById('musica'); // Obtiene el elemento de audio.
    const botonMute = document.getElementById('musica2'); // Obtiene el botón de silencio.
    boton.addEventListener('click', function () { // Agrega un evento al hacer clic en el botón.
        const audio = document.getElementById('audio'); // Obtiene el elemento de audio.
        sonido.volume = 0.2;
        audio.play();
        botonMute.style.display = 'inline'; // Muestra el botón de silencio.
        boton.style.display = 'none'; // Muestra el botón de silencio.
    });

    botonMute.addEventListener('click', function () { // Agrega un evento al hacer clic en el botón.
        const audio = document.getElementById('audio'); // Obtiene el elemento de audio.
        audio.pause();
        boton.style.display = 'inline'; // Muestra el botón de silencio.
        botonMute.style.display = 'none'; // Muestra el botón de silencio.
    });

    // const sonidoSecreto = document.getElementById('ss');
    // sonidoSecreto.addEventListener('click', function(){
    //     const audio = document.getElementById('sonidosecreto');
    //     audio.play();
    // });


    // Selecciona todos los botones y los inputs de tipo submit
    const botones = document.querySelectorAll('button, input[type="submit"], .boton');
    
    // Define el sonido que quieres reproducir
    const sonido = new Audio('audio/pressbotons2.mp3'); // Reemplaza con la ruta del archivo de sonido

    // Función para reproducir el sonido
    const reproducirSonido = () => {
        sonido.currentTime = 0; // Reinicia el sonido si ya se estaba reproduciendo
        sonido.volume = 0.1;
        sonido.play(); // Reproduce el sonido
    };

    // Agrega el evento click a cada botón y input
    botones.forEach(boton => {
        if (!boton.classList.contains('no-sonido')) {
            boton.addEventListener('click', reproducirSonido);
        }
    });
    const botonesJuego = document.querySelectorAll('#respuesta1, #respuesta2, #respuesta3, #respuesta4');
    
    // Define el sonido que quieres reproducir
    const sonidoJuego = new Audio('audio/botonVotar.mp3'); // Reemplaza con la ruta del archivo de sonido

    // Función para reproducir el sonido
    const reproducirSonidoBotonesJuego = () => {
        sonidoJuego.currentTime = 0; // Reinicia el sonido si ya se estaba reproduciendo
        sonidoJuego.volume = 0.1;
        sonidoJuego.play(); // Reproduce el sonido
    };

    // Agrega el evento click a cada botón y input
    botonesJuego.forEach(boton => {
        if (!boton.classList.contains('no-sonido')) {
            boton.addEventListener('click', reproducirSonidoBotonesJuego);
        }
    });
    
});
