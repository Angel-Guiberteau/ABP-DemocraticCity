import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();

// Hacer que la función esté disponible globalmente
window.eliminarUsuarioPartida = function (idUsuario) {
    controlador.cEliminarUsuarioPartida(idUsuario);
};