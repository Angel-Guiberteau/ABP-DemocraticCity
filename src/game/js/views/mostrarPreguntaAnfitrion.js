import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();
// 1. Muestra la pregunta con las respuestas y una cuenta atrás de 45 segundos o todos los jugadores ya han votado o anfitrion termine las votaciones
const idPartida = document.getElementById('idPartidaOculto').value;

const pregunta = document.getElementById('pregunta');
const respuesta1 = document.getElementById('respuesta1');
const respuesta2 = document.getElementById('respuesta2');
const respuesta3 = document.getElementById('respuesta3');
const respuesta4 = document.getElementById('respuesta4');
const edificios = [];
for (let i = 1; i <= 16; i++) {
    edificios['edificio' + i] = document.getElementById('edificio' + i);
}

document.getElementById('mostrarPregunta').addEventListener('click', ()=>{
    controlador.cMostrarPreguntaAnfitrion(idPartida, pregunta, respuesta1, respuesta2, respuesta3, respuesta4);
})