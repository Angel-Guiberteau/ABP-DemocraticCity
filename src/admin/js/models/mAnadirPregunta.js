export class mAnadirPregunta {
    constructor() {}

    async mAnadirPregunta(formData) {
        try {
            const response = await fetch('index.php?c=Preguntas&m=mostrarAniadirPreguntas', {
                method: 'POST',
                body: formData,
            });

            if (response.ok) {
                const result = await response.text(); 
                alert(result);

                if (result === 'Pregunta añadida correctamente') {
                    window.location.href = "index.php?c=Preguntas&m=mostrarAniadirPreguntas";
                } else {
                    const error = document.querySelector('.errorMensaje');
                    error.innerHTML = result; 
                    error.style.display = 'block';
                }
            } else {
                const error = document.querySelector('.errorMensaje');
                error.innerHTML = 'Error al conectar con el servidor. Inténtelo más tarde.';
                error.style.display = 'block';
            }
        } catch (error) {
            console.error('Error de conexión:', error);
            const errorElemento = document.querySelector('.errorMensaje');
            errorElemento.innerHTML = 'Error de conexión.';
            errorElemento.style.display = 'block';
        }
    }
}
