<!--Joaquín Telo Núñez-->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manual de juego</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/styleManual.css">
    </head>
    <body>
        <main>
            <nav class="icons">
                
                <div>
                    <button><svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                    </button>
                    <?php
                        echo '<p id="parrafoNombreUsuario" onclick="hablarNombre()">'.$_SESSION['nombreUsuario'].'</p>';
                    ?>
                </div>
        
                <div>
                    <button id="musica" class="unmute"><svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="#000000"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-volume"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8a5 5 0 0 1 0 8" /><path d="M17.7 5a9 9 0 0 1 0 14" /><path d="M6 15h-2a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h2l3.5 -4.5a.8 .8 0 0 1 1.5 .5v14a.8 .8 0 0 1 -1.5 .5l-3.5 -4.5" /></svg></button>

                    <button id="musica2" class="mute"><svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-volume-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8a5 5 0 0 1 1.912 4.934m-1.377 2.602a5 5 0 0 1 -.535 .464" /><path d="M17.7 5a9 9 0 0 1 2.362 11.086m-1.676 2.299a9 9 0 0 1 -.686 .615" /><path d="M9.069 5.054l.431 -.554a.8 .8 0 0 1 1.5 .5v2m0 4v8a.8 .8 0 0 1 -1.5 .5l-3.5 -4.5h-2a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h2l1.294 -1.664" /><path d="M3 3l18 18" /></svg></button>

                    <a href="index.php?c=Usuarios&m=cerrarSesionUser">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
                    </a>
                </div>
            
            </nav>
            <h1>Manual de juego</h1>
            <section>
                <details>
                    <summary>Crear sala</summary>
                    <div class="summaryContainer">
                        <div>
                            <div>
                                <img src="img/cracionSala.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Una vez iniciamos sesión, podremos pulsar el botón jugar, donde se nos mostrará la opción de crear una sala.</p>
                            </div>
                        </div>
                        <hr/>
                        <div>
                            <div>
                                <img src="img/salaAnfit.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Cuando creamos la sala se genera un código aleatorio, el cual los jugadores podrán usar para entrar y jugar.
                                    Cuando desees iniciar la partida solo tendrás que pulsar el botón comenzar partidas.
                                </p>
                            </div>
                        </div>
                    </div>
                </details>
            </section>
            <section>
                <details>
                    <summary>Entrar en una sala</summary>
                    <div class="summaryContainer">
                        <div>
                            <div>
                                <img src="img/unirseSala.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Una vez iniciamos sesión, podremos pulsar el botón jugar, donde se nos mostrará la opción de unirse a una sala.</p>
                            </div>
                        </div>
                        <hr/>
                        <div>
                            <div>
                                <img src="img/clave.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Introduciremos el código que se ha generado al crear la sala y pulsamos el botón Unirse.</p>
                            </div>
                        </div>
                        <hr/>
                        <div>
                            <div>
                                <img src="img/salaEspera.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Una vez ingresemos solo tendremos que esperar a que el anfitrión inicie la partida.</p>
                            </div>
                        </div>
                    </div>
                </details>
            </section>
            <section>
                <details>
                    <summary>Jugar</summary>
                    <div class="summaryContainer">
                        <div>
                            <div>
                                <img src="img/juego1.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Cuando el anfitrión inicie la partida se mostrará una pregunta y sus cuatro respuestas.</p>
                            </div>
                        </div>
                        <hr/>
                        <div>
                            <div>
                                <img src="img/juego3.png" alt="">
                            </div>
                            <div class="texto">
                                <p>Cada respuesta modifica los distintos valores de (Economía, Sanidad, Seguridad y Educación).</p>
                                <p>Cada jugador votara una respuesta y la más votada será la que salga elegida.</p>
                                <p>Cada respuesta coloca un edificio en el mapa en función de la respuesta.</p>
                            </div>
                        </div>
                        <hr/>
                        <div>
                            <div>
                                <img src="img/juego2.png" alt="">
                            </div>
                            <div class="texto">
                                <p>La partida termina cuando cualquiera de los medidores llegan a ser menores de cero y se ganará la partida si se completa la ciudad entera (Se responden a las trece preguntas).</p>
                            </div>
                        </div>
                    </div>
                </details>
            </section>
        </main>
    </body>
</html>