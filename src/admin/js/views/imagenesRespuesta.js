import { CImagenes } from "../controllers/cImagenes.js";
const objCImagenes = new CImagenes();

document.getElementById("formularioImagenes").addEventListener("submit", async (event) => {

    event.preventDefault(); // Evitar que el formulario se envíe.

    alert("Entra en la vista de JS");

    const imagen = document.getElementById("imagenes");
    const archivo = imagen.files[0]; // Obtener el primer archivo, por si consiguen meter mas de un archivo.

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

    objCImagenes.prepararImagen(archivo);
});