import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();

// Asegúrate de que la función esté disponible globalmente
window.eliminarUsuarioPartida = function (idUsuario) {
    controlador.cEliminarUsuarioPartida(idUsuario);
};

const idPartida = document.getElementById('idPartidaOculto').value;
const idUsuario = document.getElementById('idUsuarioOculto').value; 
let modal = document.getElementById('modalSalaExpirada');
let botonSE = document.getElementById('botonSalaExpirada');

function salaEliminada() {
    setInterval(() => {
        controlador.cSalaEliminada(idPartida, idUsuario, modal);
    }, 3000);
}

botonSE.addEventListener('click', () => { 
    window.location.href = "index.php?c=Usuarios&m=mostrarInicioJuego";  
});


// Asigna la función al objeto global `window`
window.mostrarJugadores = mostrarJugadores;
window.salaEliminada = salaEliminada;

// Llama a la función para iniciar la verificación
salaEliminada();
