import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();

const idPartida = document.getElementById('idPartidaOculto').value;
// const idUsuario = document.getElementById('idUsuarioOculto').value; 
document.getElementById('comenzarPartida').addEventListener('click', ()=>{
    controlador.cEmpezarPartida(idPartida);
});
