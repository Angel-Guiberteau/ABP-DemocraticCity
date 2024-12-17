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
    let idPregunta = -1000;
    let intervaloMostrarPregunta;
    let intervaloCalcularVotosRestantes;

    const modalInicioJuego = document.getElementById('modalInicioJuego');

    let pregunta = document.getElementById('pregunta');
    let respuesta1 = document.getElementById('respuesta1');
    let respuesta2 = document.getElementById('respuesta2');
    let respuesta3 = document.getElementById('respuesta3');
    let respuesta4 = document.getElementById('respuesta4');
    let edificios = [];
    for (let i = 1; i <= 13; i++) {
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
            contador++;
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
    let victorySound = document.getElementById('victorySound'); // Selecciona el sonido
    let textoFinal = document.getElementById('textoFinalPartida');
    if(economia<=0)
        textoFinal.innerHTML = 'Debido a la pobreza, el creador de SpaceX ha comprado la ciudad para poner sus instalaciones en el dejándote sin territorio...';
    else if(sanidad<=0)
        textoFinal.innerHTML = 'La rabia a llegado a tu ciudad y ha hecho que todos se infecten, ya no hay huida...';
        else if(seguridad<=0)
            textoFinal.innerHTML = 'Oh no, debido a la baja seguridad, una mafia que estaba oculta en la ciudad se ha hecho con el poder...';
            else if(educacion<=0)
                textoFinal.innerHTML = 'Debido a la poca educación que hay en la ciudad, la gente se ha mudado a estudiar a otras ciudades dejándonos solos...';
                else if(contador>=13){
                    victorySound.play().catch(error => console.log('Error al reproducir el audio:', error));
                    textoFinal.innerHTML = '⭐¡Tu ciudad ha crecido segura y próspera!⭐';
                    textoFinal.style.color = 'yellow';
                }
                    
    document.getElementById('puntuacionFinalPartida').innerHTML = 'Economia: ' + economia + ' Sanidad: ' + sanidad + ' Seguridad: '+ seguridad + ' Educación: ' + educacion;
}

function comprobarFinal(economia, sanidad, seguridad, educacion){
    console.log("Valores finales:", { economia, sanidad, seguridad, educacion, contador });
    if(contador==13 || economia < 1 || sanidad < 1 || seguridad < 1 || educacion < 1){
        mostrarPanelFinalPartida(economia, sanidad, seguridad, educacion);
    }
}
mostrarPreguntaUsuario();
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
            parrafoVotosRestantes.style.fontSize = '2.5rem';
            parrafoVotosRestantes.style.fontWeight = '700';
            parrafoVotosRestantes.style.color = 'rgb(221, 215, 37)';
            parrafoVotosRestantes.style.textShadow = '-1px 1px 3px black';
            parrafoVotosRestantes.innerHTML = '⭐¡La letra más votada es: ' + json.letraVotada + ' con ' + json.numeroVotos + ' votos!⭐';
            parrafoRespuestaEsperarVotos.innerHTML ='Tu respuesta: '+ textoRespuesta;
            document.getElementById('esperarVotos').innerHTML = 'Esperando siguiente pregunta...';

            mostrarEdificios(json);

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
