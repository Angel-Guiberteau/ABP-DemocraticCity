import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();
const idPartida = document.getElementById('idPartida').value;
const parrafoJugadores = document.getElementById('nombreJugadores');

function metodoSiempreActivo() {
    setInterval(() => {
        controlador.cMostrarJugadores(idPartida, parrafoJugadores); // Asigna el contenido acumulado al final
    }, 5000); // Se ejecuta cada 2000 ms (2 segundos)
}

// Activa el método
metodoSiempreActivo();