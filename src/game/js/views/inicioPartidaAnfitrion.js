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

let contador = 0;
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

function mostrarPanelFinalPartida(economia, sanidad, seguridad, educacion){
    document.getElementById('modalFinalPartida').style.display = 'flex';
    document.getElementById('textoFinalPartida').innerHTML = 'Tu partida ha acabado';
    document.getElementById('puntuacionFinalPartida').innerHTML = 'Economia: ' + economia + ' Sanidad: ' + sanidad + ' Seguridad: '+ seguridad + ' Educación: ' + educacion;
}
async function comprobarFinal(economia, sanidad, seguridad, educacion){
        if(contador==5 || economia < 1 || sanidad < 1 || seguridad < 1 || educacion < 1){
            mostrarPanelFinalPartida(economia, sanidad, seguridad, educacion);
            await esperar(2500);
            controlador.cFinalPartida(idPartida, economia, sanidad, seguridad, educacion, contador, nombreArchivoJson);
            
        }
}


function modificarMedidores(json){
    contador++;
    let economia = document.getElementById('valorEconomia');
    let sanidad = document.getElementById('valorSanidad');
    let seguridad = document.getElementById('valorSeguridad');
    let educacion = document.getElementById('valorEducacion');

    let economiaValor = parseInt(economia.innerHTML) || 0;
    let sanidadValor = parseInt(sanidad.innerHTML) || 0;
    let seguridadValor = parseInt(seguridad.innerHTML) || 0;
    let educacionValor = parseInt(educacion.innerHTML) || 0;

    let valorFinalEconomia = economiaValor + (json.economia);
    let valorFinalSanidad = sanidadValor + (json.sanidad);
    let valorFinalSeguridad = seguridadValor + (json.seguridad);
    let valorFinalEducacion = educacionValor + (json.educacion);

    valorFinalEconomia = Math.min(valorFinalEconomia, 10);
    valorFinalSanidad = Math.min(valorFinalSanidad, 10);
    valorFinalSeguridad = Math.min(valorFinalSeguridad, 10);
    valorFinalEducacion = Math.min(valorFinalEducacion, 10);

    economia.innerHTML = valorFinalEconomia;
    if(valorFinalEconomia <= 3){ economia.style.color = 'red' }
    else if(valorFinalEconomia >= 8){ economia.style.color = 'green' }
        else if(valorFinalEconomia == 5){ economia.style.color = 'black' }
    
    sanidad.innerHTML = valorFinalSanidad;
    if(valorFinalSanidad <= 3){ sanidad.style.color = 'red' }
    else if(valorFinalSanidad >= 8){ sanidad.style.color = 'green' }
        else if(valorFinalSanidad == 5){ sanidad.style.color = 'black' }

    seguridad.innerHTML = valorFinalSeguridad;
    if(valorFinalSeguridad <= 3){ seguridad.style.color = 'red' }
    else if(valorFinalSeguridad >= 8){ seguridad.style.color = 'green' }
        else if(valorFinalSeguridad == 5){ seguridad.style.color = 'black' }
        
    educacion.innerHTML = valorFinalEducacion;
    if(valorFinalEducacion <= 3){ educacion.style.color = 'red' }
    else if(valorFinalEducacion >= 8){ educacion.style.color = 'green' }
        else if(valorFinalEducacion == 5){ educacion.style.color = 'black' }

    comprobarFinal(valorFinalEconomia,valorFinalSanidad,valorFinalSeguridad,valorFinalEducacion);
}
async function esperar(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
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
    if(intervaloId)
        clearInterval(intervaloId);

    document.getElementById('modalEsperarVotos').style.display = 'none';
    document.getElementById('cModalMostrarVotos').style.display = 'flex';
    document.querySelector('.centrarContenido').style.display = 'flex';
    document.querySelector('.none').style.display = 'none';


    
    await dinamicaJuego();

})
document.getElementById('mostrarPregunta').addEventListener('click', async ()=>{
    await dinamicaJuego();
});
async function dinamicaJuego(){
    await mostrarPreguntaAnfitrion();
    cerrarModal();
    await esperar(3000);

    mostrarModalVotosActuales();

    intervaloId = setInterval(async () => {

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
            clearInterval(intervaloId);
            document.getElementById('cModalMostrarVotos').style.display = 'none';
            document.querySelector('.centrarContenido').style.display = 'none';
            document.querySelector('.none').style.display = 'flex';
            document.getElementById('letraMasVotado').innerHTML = '⭐¡La letra más votada es: ' + json.letraVotada + ' con ' + json.numeroVotos + ' votos!⭐';

            document.getElementById('letraMasVotado').style.cssText = 'font-size: 2.5rem; font-weight: 700; color: rgb(221, 215, 37); text-shadow: -1px 1px 3px black;';
            document.getElementById('textoMasVotado').style.cssText = 'font-size: 2.5rem; font-weight: 700; color: rgb(221, 215, 37); text-shadow: -1px 1px 3px black;';
            document.getElementById('textoMasVotado').innerHTML = '⭐Respuesta: '+json.texto+'⭐';
            modificarMedidores(json);
            


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
