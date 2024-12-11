import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();
const idPartida = document.getElementById('idPartidaOculto').value;
const parrafoJugadores = document.getElementById('nombreJugadores');

function mostrarJugadores() {
        controlador.cMostrarJugadores(idPartida, parrafoJugadores);
}

window.mostrarJugadores = mostrarJugadores;