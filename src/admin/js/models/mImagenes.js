export class MImagenes{
    constructor(){}
    async enviarImagen(imagen){
        // Enviar el archivo al servidor usando fetch.
        try {
            const response = await fetch('../../index.php', { // <-- aqui va la ruta al index con el controlador y el metodo del controlador (php).
                method: "POST",
                body: imagen
            });
            alert('metodo');
            if (response.ok) {
                alert("Imagen enviada exitosamente.");
            } else {
                alert("Hubo un error al enviar la imagen.");
            }
        } catch (error) {
            console.error("Error al enviar la imagen:", error);
            alert("Hubo un problema al enviar la imagen.");
        }
    }
}