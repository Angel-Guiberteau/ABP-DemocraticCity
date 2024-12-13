import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();

const idPartida = document.getElementById('idPartidaOculto').value;
// const idUsuario = document.getElementById('idUsuarioOculto').value; 

function salaEmpezada() {
    setInterval(() => {
        console.log('vista');
        controlador.cSalaEmpezada(idPartida);
        console.log('-----------------------------------------------');
    }, 3000);
}

window.salaEmpezada = salaEmpezada;

salaEmpezada();
