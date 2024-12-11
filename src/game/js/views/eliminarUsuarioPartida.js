import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();

// Asegúrate de que la función esté disponible globalmente
window.eliminarUsuarioPartida = function (idUsuario) {
    controlador.cEliminarUsuarioPartida(idUsuario);
};

const idPartida = document.getElementById('idPartidaOculto').value;
const idUsuario = document.getElementById('idUsuarioOculto').value; 

function salaEliminada() {
    setInterval(() => {
        controlador.cSalaEliminada(idPartida, idUsuario);
    }, 3000);
}

// Asigna la función al objeto global `window`
window.mostrarJugadores = mostrarJugadores;
window.salaEliminada = salaEliminada;

// Llama a la función para iniciar la verificación
salaEliminada();
