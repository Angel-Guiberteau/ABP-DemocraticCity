function hablarNombre() {
    const nombreUsuario = document.getElementById('parrafoNombreUsuario').textContent; // Obtener el texto
    const speech = new SpeechSynthesisUtterance(nombreUsuario); // Crear la instancia de voz
    speech.lang = 'es-ES'; // Configura el idioma (español)
    speech.pitch = 1; // Tono de voz
    speech.rate = 1; // Velocidad de habla
    speech.volume = 1; // Volumen

    window.speechSynthesis.speak(speech); // Hablar el texto
}