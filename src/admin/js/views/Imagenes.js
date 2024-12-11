//import { CImagenes } from "../controllers/cImagenes";
document.getElementById("formularioImagenes").addEventListener("submit", async (event) => {
    event.preventDefault(); // Evitar que el formulario se envíe.
    alert("Entra en la vista de JS");

    const imagen = document.getElementById("imagenes");
    console.log(imagen);
    const archivo = imagen.files[0]; // Obtener el primer archivo.

    // Comprobamos si se ha seleccionado un archivo.
    if (!archivo) {
        alert("Por favor, selecciona una imagen.");
        return;
    }

    // Validar formato de imagen (jpg, png).
    const formato = ["image/jpeg", "image/png"];
    if (!formato.includes(archivo.type)) {
        alert("El archivo debe ser una imagen JPG o PNG.");
        return;
    }

    // Crear un nuevo nombre para la imagen
    const nombreNuevo = "imagen_" + new Date().getTime() + "." + archivo.name.split(".").pop();

    // Crear un objeto FormData para enviar el archivo al servidor.
    const formData = new FormData();
    formData.append("imagen", archivo, nombreNuevo); // Añadir el archivo con el nuevo nombre.

    // Enviar el archivo al servidor usando fetch.
    try {
        const response = await fetch("src/admin/img", { // <-- aqui va la ruta del servidor.
            method: "POST",
            body: formData
        });

        if (response.ok) {
            alert("Imagen enviada exitosamente.");
        } else {
            alert("Hubo un error al enviar la imagen.");
        }
    } catch (error) {
        console.error("Error al enviar la imagen:", error);
        alert("Hubo un problema al enviar la imagen.");
    }
});