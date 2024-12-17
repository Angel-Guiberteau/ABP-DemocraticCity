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


/////////////////////////// MOSTRAR EDIFICIOS
function mostrarEdificios(json) {
    let imgEdificio = document.getElementById('edificio' + contador);
    let originalName = json.nombreArchivo; 

    // Verifica que el nombre del archivo sea el esperado
    console.log("Nombre original:", originalName);

    // Elimina la parte con guion bajo y 13 caracteres alfanuméricos, usando una expresión regular
    let newName = originalName.replace(/_[a-zA-Z0-9]{13}\./, `${contador}.`); // Reemplaza _ + 13 caracteres alfanuméricos + punto por el contador
    console.log("Nombre con contador:", newName);

    // Asegura que la extensión sea correctamente modificada
    // newName = newName.replace(/(\.(png|jpg))$/, `.${contador}$1`); // Solo agrega el contador antes de la extensión
    console.log("Nombre final:", newName);

    // Asigna la nueva ruta a la imagen
    imgEdificio.src = 'img/edificios/' + newName;
    imgEdificio.style.display = 'inline';
}
///////////////////// COMENZAR JUEGO AL MOSTRAR PREGUNTA

function mostrarPanelFinalPartida(economia, sanidad, seguridad, educacion){
    document.getElementById('modalFinalPartida').style.display = 'flex';
    let victorySound = document.getElementById('victorySound'); // Selecciona el sonido
    let gameOver = document.getElementById('loseSound'); // Selecciona el sonido
    let textoFinal = document.getElementById('textoFinalPartida');
    if(economia<=0){
        gameOver.play().catch(error => console.log('Error al reproducir el audio:', error));
        textoFinal.innerHTML = 'Debido a la pobreza, el creador de SpaceX ha comprado la ciudad para poner sus instalaciones en el dejándote sin territorio...';
    }else if(sanidad<=0){
        gameOver.play().catch(error => console.log('Error al reproducir el audio:', error));
        textoFinal.innerHTML = 'La rabia a llegado a tu ciudad y ha hecho que todos se infecten, ya no hay huida...';
    } else if(seguridad<=0) {
            gameOver.play().catch(error => console.log('Error al reproducir el audio:', error));
            textoFinal.innerHTML = 'Oh no, debido a la baja seguridad, una mafia que estaba oculta en la ciudad se ha hecho con el poder...';
    }else if(educacion<=0){
        gameOver.play().catch(error => console.log('Error al reproducir el audio:', error));
        textoFinal.innerHTML = 'Debido a la poca educación que hay en la ciudad, la gente se ha mudado a estudiar a otras ciudades dejándonos solos...';
    }else if(contador>=13){
        victorySound.play().catch(error => console.log('Error al reproducir el audio:', error));
        textoFinal.innerHTML = '⭐¡Tu ciudad ha crecido segura y próspera!⭐';
        textoFinal.style.color = 'yellow';
    }          
    document.getElementById('puntuacionFinalPartida').innerHTML = 'Economia: ' + economia + ' Sanidad: ' + sanidad + ' Seguridad: '+ seguridad + ' Educación: ' + educacion;
}
async function comprobarFinal(economia, sanidad, seguridad, educacion){
        if(contador==13 || economia < 1 || sanidad < 1 || seguridad < 1 || educacion < 1){
            mostrarPanelFinalPartida(economia, sanidad, seguridad, educacion);
            await esperar(3000);
            controlador.cFinalPartida(idPartida, economia, sanidad, seguridad, educacion, contador, nombreArchivoJson);
        }else
            return false
}


function modificarMedidores(json){
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
    // Limitar valores máximos a 10
    valorFinalEconomia = Math.min(valorFinalEconomia, 10);
    valorFinalSanidad = Math.min(valorFinalSanidad, 10);
    valorFinalSeguridad = Math.min(valorFinalSeguridad, 10);
    valorFinalEducacion = Math.min(valorFinalEducacion, 10);

    economia.innerHTML = valorFinalEconomia;
    if(valorFinalEconomia <= 3){ economia.style.color = 'red' }
    else if(valorFinalEconomia >= 8){ economia.style.color = 'green' }
    else if([4, 5, 6, 7].includes(valorFinalEconomia)){ economia.style.color = '#fddaac' }

    sanidad.innerHTML = valorFinalSanidad;
    if(valorFinalSanidad <= 3){ sanidad.style.color = 'red' }
    else if(valorFinalSanidad >= 8){ sanidad.style.color = 'green' }
    else if([4, 5, 6, 7].includes(valorFinalSanidad)){ sanidad.style.color = '#fddaac' }

    seguridad.innerHTML = valorFinalSeguridad;
    if(valorFinalSeguridad <= 3){ seguridad.style.color = 'red' }
    else if(valorFinalSeguridad >= 8){ seguridad.style.color = 'green' }
    else if([4, 5, 6, 7].includes(valorFinalSeguridad)){ seguridad.style.color = '#fddaac' }

    educacion.innerHTML = valorFinalEducacion;
    if(valorFinalEducacion <= 3){ educacion.style.color = 'red' }
    else if(valorFinalEducacion >= 8){ educacion.style.color = 'green' }
    else if([4, 5, 6, 7].includes(valorFinalEducacion)){ educacion.style.color = '#fddaac' }

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
    await esperar(1500);

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
            contador++;
            document.getElementById('cModalMostrarVotos').style.display = 'none';
            document.querySelector('.centrarContenido').style.display = 'none';
            document.querySelector('.none').style.display = 'flex';
            document.getElementById('letraMasVotado').innerHTML = '⭐¡La letra más votada es: ' + json.letraVotada + ' con ' + json.numeroVotos + ' votos!⭐';

            document.getElementById('letraMasVotado').style.cssText = 'font-size: 2.5rem; font-weight: 700; color: rgb(221, 215, 37); text-shadow: -1px 1px 3px black;';
            document.getElementById('textoMasVotado').style.cssText = 'font-size: 2.5rem; font-weight: 700; color: rgb(221, 215, 37); text-shadow: -1px 1px 3px black;';
            document.getElementById('textoMasVotado').innerHTML = '⭐Respuesta: '+json.texto+'⭐';
            mostrarEdificios(json);
            modificarMedidores(json);
        } else {
            console.log('JSON no reconocido');
        }
    }, 750);


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
