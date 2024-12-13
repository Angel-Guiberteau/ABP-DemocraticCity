import { CPartida } from '../controllers/cPartida.js';
const controlador = new CPartida()
// Referencias al modal y botones
const modalInicioJuego = document.getElementById('modalInicioJuego');
const closeModalInicioJuego= document.getElementById('closeModalInicioJuego');
const idPartida = document.getElementById('idPartidaOculto').value;
const nombreCiudad = document.getElementById('nombreCiudadOculto').value;

const pregunta = document.getElementById('pregunta');
const respuesta1 = document.getElementById('respuesta1');
const respuesta2 = document.getElementById('respuesta2');
const respuesta3 = document.getElementById('respuesta3');
const respuesta4 = document.getElementById('respuesta4');
const edificios = [];
for (let i = 1; i <= 16; i++) {
    edificios['edificio' + i] = document.getElementById('edificio' + i);
}

//Cuando pulse el botón del modal, que muestre la pregunta
document.getElementById('mostrarPregunta').addEventListener('click', ()=>{
    controlador.cMostrarPreguntaAnfitrion(idPartida, nombreCiudad, pregunta, respuesta1, respuesta2, respuesta3, respuesta4);
    cerrarModal();
});

// Cerrar modal
closeModalInicioJuego.addEventListener('click', () => {
    modalInicioJuego.style.display = 'none';
});
function cerrarModal(){
    modalInicioJuego.style.display = 'none';
}
