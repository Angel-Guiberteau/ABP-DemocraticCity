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
    }, 1000);
    
}

function cerrarModal(){
    modalInicioJuego.style.display = 'none';
}

mostrarPreguntaUsuario();

function enviarVoto(letraElegida, textoRespuesta){
    controlador.cEnviarVoto(letraElegida,idPartida, nombreCiudad);
    respuesta1.disabled = true;
    respuesta2.disabled = true;
    respuesta3.disabled = true;
    respuesta4.disabled = true;
    mostrarModalEsperar(textoRespuesta);
}
function mostrarModalEsperar(textoRespuesta) {
    document.getElementById('respuestaEsperarVotos').innerHTML = textoRespuesta;
    document.getElementById('modalEsperarVotos').style.display = 'flex';
}

respuesta1.addEventListener('click', () =>{
    const textoBoton = respuesta1.innerHTML;
    enviarVoto('A', textoBoton);
});
respuesta2.addEventListener('click', () =>{
    const textoBoton = respuesta2.innerHTML;
    enviarVoto('B', textoBoton);
});
respuesta3.addEventListener('click', () =>{
    const textoBoton = respuesta3.innerHTML;
    enviarVoto('C', textoBoton);
});
respuesta4.addEventListener('click', () =>{
    const textoBoton = respuesta4.innerHTML;
    enviarVoto('D', textoBoton);
});