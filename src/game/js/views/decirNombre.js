function hablarNombre() {
    let speech = '';
    const nombreUsuario = document.getElementById('parrafoNombreUsuario').textContent; // Obtener el texto
    speech = new SpeechSynthesisUtterance(nombreUsuario);
    if(nombreUsuario == 'Cebepuche' || nombreUsuario == 'cebepuche'){
        speech = new SpeechSynthesisUtterance('¡¡¡¡¡CEBEPUTEROOO!!!!!!');
    }else{
        if(nombreUsuario == 'Mauri' || nombreUsuario == 'mauri')
            speech = new SpeechSynthesisUtterance('MAURICIO COLMENERO EL MÁS ALTO DE ESPAÑA');
        else
            if(nombreUsuario == 'Angel' || nombreUsuario == 'angel')
                speech = new SpeechSynthesisUtterance('JULIA DONDE ESTÁS');
            else
                if(nombreUsuario == 'Joaquin' || nombreUsuario == 'joaquin')
                    speech = new SpeechSynthesisUtterance('Angel estoy enamorado de ti');
                else
                    if(nombreUsuario == 'Alro' || nombreUsuario == 'alro')
                        speech = new SpeechSynthesisUtterance('LA TUYA MÁS');
    }
    speech.lang = 'es-ES'; // Configura el idioma (español)
    speech.pitch = 1; // Tono de voz
    speech.rate = 1; // Velocidad de habla
    speech.volume = 1; // Volumen

    window.speechSynthesis.speak(speech); // Hablar el texto
}