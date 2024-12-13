import { CPartida } from '../controllers/cPartida.js';
const controlador = new CPartida()
// Referencias al modal y botones
const modalUnirseSala = document.getElementById('modalUnirseSala');
const unirseSalaButton = document.getElementById('unirseSalaButton');
const closeModalUnirseSala = document.getElementById('closeModalUnirseSala');
const unirseSalaForm = document.getElementById('unirseSalaForm');

// Abrir modal
unirseSalaButton.addEventListener('click', () => {
    modalUnirseSala.style.display = 'flex';
});

// Cerrar modal
closeModalUnirseSala.addEventListener('click', () => {
    modalUnirseSala.style.display = 'none';
    const parrafo = document.getElementById('errorModal');
    parrafo.style.display = 'none';
});

// Manejar envío del formulario
unirseSalaForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const codSala = document.getElementById('codigoSala').value;
    const idUsuario = document.getElementById('idUsuario').value;
    const parrafo = document.getElementById('errorModal');
    controlador.cUnirseSala(codSala, idUsuario, parrafo);
});
