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

    let contador = 0;
    let votosTotales;
    let idPregunta = -1000;
    let intervaloMostrarPregunta;
    let intervaloCalcularVotosRestantes;

    const modalInicioJuego = document.getElementById('modalInicioJuego');

    let pregunta = document.getElementById('pregunta');
    let respuesta1 = document.getElementById('respuesta1');
    let respuesta2 = document.getElementById('respuesta2');
    let respuesjsonta3 = document.getElementById('respuesta3');
    let respuesta4 = document.getElementById('respuesta4');
    let edificios = [];
    for (let i = 1; i <= 16; i++) {
        edificios['edificio' + i] = document.getElementById('edificio' + i);
    }

/////////////////////////// MOSTRAR PREGUNTAS USUARIO
let lastIdPregunta = -1000;
function mostrarPreguntaUsuario(){
    document.getElementById('votosRestantes').style.cssText = '';
    document.querySelector('.dot-spinner').style.display = 'flex';
    
    // Detener el intervalo si ya estaba corriendo
    if (intervaloMostrarPregunta) {
        clearInterval(intervaloMostrarPregunta);
    }

// Variable para controlar el cambio de idPregunta
    intervaloMostrarPregunta = setInterval(async () => {
        // Obtener el id de la pregunta desde el controlador
        idPregunta= await controlador.cMostrarPreguntaUsuario(idPartida, pregunta, respuesta1, respuesta2, respuesta3, respuesta4, modalInicioJuego);
        
        // Si el idPregunta es válido y diferente al anterior, detener el intervalo
        if (idPregunta >= 0 && idPregunta !== lastIdPregunta) {
            lastIdPregunta = idPregunta;  // Actualizar el idPregunta
            clearInterval(intervaloMostrarPregunta); // Detener el intervalo al obtener una pregunta válida
            document.getElementById('modalEsperarVotos').style.display = 'none';
            respuesta1.disabled = false;
            respuesta2.disabled = false;
            respuesta3.disabled = false;
            respuesta4.disabled = false;
        }
    }, 1000);
    
}
function mostrarPanelFinalPartida(economia, sanidad, seguridad, educacion){
    document.getElementById('modalFinalPartida').style.display = 'flex';
    document.getElementById('textoFinalPartida').innerHTML = 'Tu partida ha acabado';
    document.getElementById('puntuacionFinalPartida').innerHTML = 'Economia: ' + economia + ' Sanidad: ' + sanidad + ' Seguridad: '+ seguridad + ' Educación: ' + educacion;
}

async function comprobarFinal(economia, sanidad, seguridad, educacion){
    if(contador==5 || economia < 1 || sanidad < 1 || seguridad < 1 || educacion < 1){
        controlador.cFinalPartida(idPartida, economia, sanidad, seguridad, educacion);
        mostrarPanelFinalPartida(economia, sanidad, seguridad, educacion);
    }
}
mostrarPreguntaUsuario();
/////////////////////////// MODIFICAR MEDIDORES
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

    comprobarFinal(economia, sanidad, seguridad, educacion);
}

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
    let prueba = await controlador.cCalcularVotosRestantes(numJugadores, nombreArchivoJson, idPregunta);
    return prueba;
}



/////////////////////////// CERRAR MODAL
async function esperar(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
function cerrarModal(){
    modalInicioJuego.style.display = 'none';
}

/////////////////////////// MOSTRAR MODAL DESPUES DE VOTO

function mostrarModalEsperar(textoRespuesta) {
    intervaloCalcularVotosRestantes = setInterval(async () => {
        // Suponiendo que `calcularVotosRestantes` devuelve un JSON con los votos totales.
        const json = await calcularVotosRestantes();
        // Comprobamos el tipo de j
        
        if (esTipoVotosJSON(json)) {
            // Si es el tipo de JSON con votos (A, B, C, D)
            document.getElementById('votosRestantes').innerHTML = 'Votos restantes: ' + (numJugadores - json.totalVotos);
            document.getElementById('respuestaEsperarVotos').innerHTML = textoRespuesta;
            document.getElementById('modalEsperarVotos').style.display = 'flex';
            
        } else if (esTipoLetraVotadaJSON(json)) {
            
            
            if(document.getElementById('modalEsperarVotos').style.display != 'flex'){
                document.getElementById('modalEsperarVotos').style.display = 'flex'
            }
            let parrafoVotosRestantes = document.getElementById('votosRestantes');
            let parrafoRespuestaEsperarVotos = document.getElementById('respuestaEsperarVotos');
            let cargando = document.querySelector('.dot-spinner');
            cargando.style.display = 'none';
            parrafoVotosRestantes.style.cssText = 'font-size: 2.5rem; font-weight: 700; color: rgb(221, 215, 37); text-shadow: -1px 1px 3px black;';

            parrafoVotosRestantes.innerHTML = '⭐¡La letra más votada es: ' + json.letraVotada + ' con ' + json.numeroVotos + ' votos!⭐';

            parrafoRespuestaEsperarVotos.innerHTML ='Tu respuesta: '+ textoRespuesta;
            document.getElementById('esperarVotos').innerHTML = 'Esperando siguiente pregunta...';
            clearInterval(intervaloCalcularVotosRestantes);
            modificarMedidores(json);
            
            
            idPregunta= -1000;
            mostrarPreguntaUsuario();
            
        } else {
            console.log('JSON no reconocido');
        }
    }, 1000);


    // Configurar el texto en el modal
 
}

// Función para verificar si es el primer tipo de JSON (A, B, C, D)
function esTipoVotosJSON(json) {
    return json.hasOwnProperty('totalVotos');
}

// Función para verificar si es el segundo tipo de JSON (letraVotada, numeroVotos)
function esTipoLetraVotadaJSON(json) {
    return json.hasOwnProperty('letraVotada') && json.hasOwnProperty('numeroVotos');
}
