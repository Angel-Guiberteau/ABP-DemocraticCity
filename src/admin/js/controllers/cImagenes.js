import { MImagenes } from "../../js/models/mImagenes.js";
export class CImagenes{
    objMImagenes;
    constructor(){
        this.objMImagenes = new MImagenes();
    }
    prepararImagen(imagen){
        alert('controlador');
        // Crear un nuevo nombre para la imagen.
        const nombreNuevo = "imagen_" + new Date().getTime() + "." + imagen.name.split(".").pop();

        // Crear un objeto FormData para enviar el archivo al servidor.
        const formData = new FormData();
        formData.append("imagen", imagen, nombreNuevo); // Añadir el archivo con el nuevo nombre.
        this.objMImagenes.enviarImagen(formData);
    }
}