import { CImagenes } from "../controllers/cImagenes";
document.querySelector('#formularioImagenes').addEventListener('submit', async function (event) {
    event.preventDefault(); //evita que la pagina se refresque cuando se manda el formulario.

    let imagenes = document.getElementsByName('imagenes').value;

    let formData = new FormData();
    formData.append('imagen', imagenes);
    
    try {
        
    } catch (error) {
        
    }
});