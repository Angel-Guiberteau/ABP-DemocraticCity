import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();

const idPartida = document.getElementById('idPartidaOculto').value;
// const idUsuario = document.getElementById('idUsuarioOculto').value; 

function salaEmpezada() {
    setInterval(() => {
        controlador.cSalaEmpezada(idPartida);
    }, 2500);
}

window.salaEmpezada = salaEmpezada;

salaEmpezada();
