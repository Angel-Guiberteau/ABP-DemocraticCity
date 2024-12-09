import { CImagenes } from "../controllers/cImagenes";
document.getElementById("formularioImagenes").addEventListener("submit", async (event) => {
    event.preventDefault(); // Evitar que el formulario se envíe.

    const inputFile = document.getElementById("imagenes");
    const file = inputFile.files[0]; // Obtener el primer archivo.

    // Comprobamos si se ha seleccionado un archivo.
    if (!file) {
        alert("Por favor, selecciona una imagen.");
        return;
    }

    // Validar formato de imagen (jpg, png).
    const allowedFormats = ["image/jpeg", "image/png"];
    if (!allowedFormats.includes(file.type)) {
        alert("El archivo debe ser una imagen JPG o PNG.");
        return;
    }

    // Crear un nuevo nombre para la imagen
    const newFileName = "imagen_" + new Date().getTime() + "." + file.name.split(".").pop();

    // Crear un objeto FormData para enviar el archivo al servidor.
    const formData = new FormData();
    formData.append("imagen", file, newFileName); // Añadir el archivo con el nuevo nombre.

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
