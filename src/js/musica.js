document.addEventListener('DOMContentLoaded', function () {
    const boton = document.getElementById('musica'); // Obtiene el elemento de audio.
    const botonMute = document.getElementById('musica2'); // Obtiene el botón de silencio.
    boton.addEventListener('click', function () { // Agrega un evento al hacer clic en el botón.
        const audio = document.getElementById('audio'); // Obtiene el elemento de audio.
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

    const sonidoSecreto = document.getElementById('ss');
    sonidoSecreto.addEventListener('click', function(){
        const audio = document.getElementById('sonidosecreto');
        audio.play();
    });
    
});
