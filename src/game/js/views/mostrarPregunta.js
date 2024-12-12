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
function mostrarPregunta(){
    setInterval(()=>{
        alert('vista');

        let data = controlador.cMostrarPregunta(idPartida);
        pregunta.textContent = data.pregunta; // Asigna la pregunta

        respuesta1.textContent = `${data.respuestas[0].letra}: ${data.respuestas[0].texto}`; // Respuesta A
        respuesta2.textContent = `${data.respuestas[1].letra}: ${data.respuestas[1].texto}`; // Respuesta B
        respuesta3.textContent = `${data.respuestas[2].letra}: ${data.respuestas[2].texto}`; // Respuesta C
        respuesta4.textContent = `${data.respuestas[3].letra}: ${data.respuestas[3].texto}`; // Respuesta D
        
    }, 3000);
}
mostrarPregunta();