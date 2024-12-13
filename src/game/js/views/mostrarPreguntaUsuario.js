import { CPartida } from '../controllers/cPartida.js';

const controlador = new CPartida();

/////////////////////////// VARIABLES GLOBALES
    const idPartida = document.getElementById('idPartidaOculto').value;
    const nombreCiudad = document.getElementById('nombreCiudadOculto').value;
    const nombreArchivoJson = `${idPartida}${nombreCiudad}.json`;
    async function calcularJugadores() {
        return await controlador.cCalcularJugadores(idPartida);
    }
    let numJugadores = await calcularJugadores();

    let votosTotales;

    const modalInicioJuego = document.getElementById('modalInicioJuego');

    const pregunta = document.getElementById('pregunta');
    const respuesta1 = document.getElementById('respuesta1');
    const respuesta2 = document.getElementById('respuesta2');
    const respuesta3 = document.getElementById('respuesta3');
    const respuesta4 = document.getElementById('respuesta4');
    const edificios = [];
    for (let i = 1; i <= 16; i++) {
        edificios['edificio' + i] = document.getElementById('edificio' + i);
    }

/////////////////////////// MOSTRAR PREGUNTAS USUARIO
function mostrarPreguntaUsuario(){
    setInterval(()=>{
        controlador.cMostrarPreguntaUsuario(idPartida, pregunta, respuesta1, respuesta2, respuesta3, respuesta4, modalInicioJuego);
    }, 1000);
    
}
mostrarPreguntaUsuario();

/////////////////////////// ENVIAR VOTO AL JSON

function enviarVoto(letraElegida, textoRespuesta){
    controlador.cEnviarVoto(letraElegida,idPartida, nombreCiudad);
    respuesta1.disabled = true;
    respuesta2.disabled = true;
    respuesta3.disabled = true;
    respuesta4.disabled = true;
    mostrarModalEsperar(textoRespuesta);
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

/////////////////////////// CALCULAR VOTOS RESTANTES

async function calcularVotosRestantes(){
    return controlador.cCalcularVotosRestantes(numJugadores, nombreArchivoJson);
}



/////////////////////////// CERRAR MODAL

function cerrarModal(){
    modalInicioJuego.style.display = 'none';
}

/////////////////////////// MOSTRAR MODAL DESPUES DE VOTO

function mostrarModalEsperar(textoRespuesta) {
    setInterval(async ()=>{
        votosTotales = await calcularVotosRestantes();
        document.getElementById('votosRestantes').innerHTML = 'Votos restantes: '+ (numJugadores - votosTotales);
    }, 1000);
    //Brother piensa antes de hacer las cosas tio...
    document.getElementById('respuestaEsperarVotos').innerHTML = textoRespuesta;
    document.getElementById('modalEsperarVotos').style.display = 'flex';
}





