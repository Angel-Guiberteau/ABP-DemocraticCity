import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();
// 1. Muestra la pregunta con las respuestas y una cuenta atrás de 45 segundos o todos los jugadores ya han votado o anfitrion termine las votaciones
const idPartida = document.getElementById('idPartidaOculto').value;
const nombreCiudad = document.getElementById('nombreCiudadOculto').value;

const modalInicioJuego = document.getElementById('modalInicioJuego');
const closeModalInicioJuego= document.getElementById('closeModalInicioJuego');

const pregunta = document.getElementById('pregunta');
const respuesta1 = document.getElementById('respuesta1');
const respuesta2 = document.getElementById('respuesta2');
const respuesta3 = document.getElementById('respuesta3');
const respuesta4 = document.getElementById('respuesta4');
const edificios = [];
for (let i = 1; i <= 16; i++) {
    edificios['edificio' + i] = document.getElementById('edificio' + i);
}

function mostrarPreguntaUsuario(){
    setInterval(()=>{
        controlador.cMostrarPreguntaUsuario(idPartida, pregunta, respuesta1, respuesta2, respuesta3, respuesta4, modalInicioJuego);
    }, 5000);
    
}

// Cerrar modal
closeModalInicioJuego.addEventListener('click', () => {
    modalInicioJuego.style.display = 'none';
});

function cerrarModal(){
    modalInicioJuego.style.display = 'none';
}

mostrarPreguntaUsuario();

function enviarVoto(letraElegida){
    controlador.cEnviarVoto(letraElegida,idPartida, nombreCiudad);
}

respuesta1.addEventListener('click', () =>{
    enviarVoto('A');
});
respuesta2.addEventListener('click', () =>{
    enviarVoto('B');
});
respuesta3.addEventListener('click', () =>{
    enviarVoto('C');
});
respuesta4.addEventListener('click', () =>{
    enviarVoto('D');
});