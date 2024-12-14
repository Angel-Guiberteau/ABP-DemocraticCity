import { CPartida } from '../controllers/cPartida.js';
const controlador = new CPartida()

const modalInicioJuego = document.getElementById('modalInicioJuego');
const closeModalInicioJuego= document.getElementById('closeModalInicioJuego');

const idPartida = document.getElementById('idPartidaOculto').value;
const nombreCiudad = document.getElementById('nombreCiudadOculto').value;
const nombreArchivoJson = `${idPartida}${nombreCiudad}.json`;
async function calcularJugadores() {
    return await controlador.cCalcularJugadores(idPartida);
}
let numJugadores = await calcularJugadores();

let idPregunta;
let intervaloId;
const pregunta = document.getElementById('pregunta');
const respuesta1 = document.getElementById('respuesta1');
const respuesta2 = document.getElementById('respuesta2');
const respuesta3 = document.getElementById('respuesta3');
const respuesta4 = document.getElementById('respuesta4');
const edificios = [];
for (let i = 1; i <= 16; i++) {
    edificios['edificio' + i] = document.getElementById('edificio' + i);
}

/////////////////////////// COMENZAR JUEGO AL MOSTRAR PREGUNTA

async function calcularVotosRestantes(){
    let json = await controlador.cCalcularVotosRestantes(numJugadores, nombreArchivoJson, idPregunta);
    return json;
}

async function mostrarModalVotosActuales(){
    document.getElementById('modalEsperarVotos').style.display = 'flex';
}

async function mostrarPreguntaAnfitrion(){
    idPregunta = await controlador.cMostrarPreguntaAnfitrion(idPartida, nombreCiudad, pregunta, respuesta1, respuesta2, respuesta3, respuesta4);
    
}
document.getElementById('siguientePregunta').addEventListener('click', async ()=>{
    ////Esperar 3 segs
    document.getElementById('modalEsperarVotos').style.display = 'none';
    document.getElementById('cModalMostrarVotos').style.display = 'flex';
    document.querySelector('.centrarContenido').style.display = 'flex';
    document.querySelector('.none').style.display = 'none';


    if(intervaloId)
        clearInterval(intervaloId);

    await dinamicaJuego();

})
document.getElementById('mostrarPregunta').addEventListener('click', async ()=>{
    await dinamicaJuego();
});
async function dinamicaJuego(){
    await mostrarPreguntaAnfitrion();
    cerrarModal();
    ////Esperar
    mostrarModalVotosActuales();

    intervaloId = setInterval(async () => {
        console.log('vista idpregunta ' + idPregunta);

        const json = await calcularVotosRestantes();

        if (esTipoVotosJSON(json)) {
            let letraA = document.getElementById('letraA');
            let letraB = document.getElementById('letraB');
            let letraC = document.getElementById('letraC');
            let letraD = document.getElementById('letraD');

            letraA.innerHTML = 'A:' + json.A;
            letraB.innerHTML = 'B:' + json.B;
            letraC.innerHTML = 'C:' + json.C;
            letraD.innerHTML = 'D:' + json.D;

            document.getElementById('votosRestantes').innerHTML = 'Votos restantes: ' + (numJugadores - json.totalVotos);
            
        } else if (esTipoLetraVotadaJSON(json)) {
            document.getElementById('cModalMostrarVotos').style.display = 'none';
            document.querySelector('.centrarContenido').style.display = 'none';
            document.querySelector('.none').style.display = 'flex';
            document.getElementById('letraMasVotado').innerHTML = '⭐¡La letra más votada es: ' + json.letraVotada + ' con ' + json.numeroVotos + ' votos!⭐';

            document.getElementById('letraMasVotado').style.cssText = 'font-size: 2.5rem; font-weight: 700; color: rgb(221, 215, 37); text-shadow: -1px 1px 3px black;';
            document.getElementById('textoMasVotado').style.cssText = 'font-size: 2.5rem; font-weight: 700; color: rgb(221, 215, 37); text-shadow: -1px 1px 3px black;';

            document.getElementById('textoMasVotado').innerHTML = '⭐Respuesta: '+json.texto+'⭐';


        } else {
            console.log('JSON no reconocido');
        }
    }, 1000);


    // Configurar el texto en el modal
    // document.getElementById('respuestaEsperarVotos').innerHTML = textoRespuesta;
    // document.getElementById('modalEsperarVotos').style.display = 'flex';






    function esTipoVotosJSON(json) {
        return json.hasOwnProperty('totalVotos');
    }
    
    // Función para verificar si es el segundo tipo de JSON (letraVotada, numeroVotos)
    function esTipoLetraVotadaJSON(json) {
        return json.hasOwnProperty('letraVotada') && json.hasOwnProperty('numeroVotos');
    }
}



/////////////////////////// CERRAR PRIMER MODAL
closeModalInicioJuego.addEventListener('click', () => {
    modalInicioJuego.style.display = 'none';
});
function cerrarModal(){
    modalInicioJuego.style.display = 'none';
}
