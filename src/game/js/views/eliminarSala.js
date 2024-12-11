import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();

// Hacer que la función esté disponible globalmente
window.eliminarSala = function (codSala, idAnfitrion) {

    controlador.cEliminarSala(codSala, idAnfitrion);
};