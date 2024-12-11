import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();
const idPartida = document.getElementById('idPartida').value;
const parrafoJugadores = document.getElementById('nombreJugadores');

window.metodoSiempreActivo() {
    setInterval(() => {
        let result = controlador.cMostrarJugadores(idPartida);
        parrafoJugadores.innerHTML = '';
        result.forEach(nombreJugadores => {
            parrafoJugadores.innerHTML = nombreJugadores+' - ';
        });
    }, 2000); // Se ejecuta cada 2000 ms (2 segundos)
}

// Activa el método
metodoSiempreActivo();