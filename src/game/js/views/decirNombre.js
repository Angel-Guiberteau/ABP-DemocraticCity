function hablarNombre() {
    let speech = '';
    const nombreUsuario = document.getElementById('parrafoNombreUsuario').textContent; // Obtener el texto
    if(nombreUsuario == 'Cebepuche' || nombreUsuario == 'cebepuche'){
        speech = new SpeechSynthesisUtterance('¡¡¡¡¡CEBEPUTEROOO!!!!!!');
    }else{
        speech = new SpeechSynthesisUtterance(nombreUsuario); // Crear la instancia de voz
    }
    speech.lang = 'es-ES'; // Configura el idioma (español)
    speech.pitch = 1; // Tono de voz
    speech.rate = 1; // Velocidad de habla
    speech.volume = 1; // Volumen

    window.speechSynthesis.speak(speech); // Hablar el texto
}