<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title><?php
        echo $_SESSION['nombreCiudad'];
    ?></title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="bodyJuego">
    <?php
        echo '<input type="hidden" id="idPartidaOculto" value="'.$_SESSION['idPartida'].'">';
        echo '<input type="hidden" id="nombreCiudadOculto" value="'.$_SESSION['nombreCiudad'].'">';
    ?>
    <div id="juego">
        <audio src="audio/musicaInicio.mp3" preload="auto" id="audio"></audio>
        <audio src="audio/finPartida.mp3" preload="auto" id="victorySound"></audio>

        <nav class="icons">
            <button id="musica" class="unmute"><svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="#000000"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-volume"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8a5 5 0 0 1 0 8" /><path d="M17.7 5a9 9 0 0 1 0 14" /><path d="M6 15h-2a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h2l3.5 -4.5a.8 .8 0 0 1 1.5 .5v14a.8 .8 0 0 1 -1.5 .5l-3.5 -4.5" /></svg></button>
            <button id="musica2" class="mute"><svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-volume-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8a5 5 0 0 1 1.912 4.934m-1.377 2.602a5 5 0 0 1 -.535 .464" /><path d="M17.7 5a9 9 0 0 1 2.362 11.086m-1.676 2.299a9 9 0 0 1 -.686 .615" /><path d="M9.069 5.054l.431 -.554a.8 .8 0 0 1 1.5 .5v2m0 4v8a.8 .8 0 0 1 -1.5 .5l-3.5 -4.5h-2a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h2l1.294 -1.664" /><path d="M3 3l18 18" /></svg></button>
        </nav>
        <div class="preguntas">
            <?php
                // Div donde aparece la pregunta
                echo '<div>';
                    echo '<p id="pregunta"></p>';
                echo '</div>';
                // Div donde aparecen las respuestas
                echo '<div class="respuestas">';
                    echo '<button id="respuesta1"></button>';
                    echo '<button id="respuesta2"></button>';
                    echo '<button id="respuesta3"></button>';
                    echo '<button id="respuesta4"></button>';
                echo '</div>';
                echo '<div class="medidores">';
                    echo '<button id="economia">Economia: <span id="valorEconomia">5</span></button>';
                    echo '<button id="sanidad">Sanidad: <span id="valorSanidad">5</span></button>';
                    echo '<button id="seguridad">Seguridad: <span id="valorSeguridad">5</span></button>';
                    echo '<button id="educacion">Educacion: <span id="valorEducacion">5</span></button>';
                echo '</div>';
            ?>
            <div class="mapa">
                <img src="img/mapaJuego.png" alt="">
                <img src="" alt="" id="edificio1">
                <img src="" alt="" id="edificio2">
                <img src="" alt="" id="edificio3">
                <img src="" alt="" id="edificio4">
                <img src="" alt="" id="edificio5">
                <img src="" alt="" id="edificio6">
                <img src="" alt="" id="edificio7">
                <img src="" alt="" id="edificio8">
                <img src="" alt="" id="edificio9">
                <img src="" alt="" id="edificio10">
                <img src="" alt="" id="edificio11">
                <img src="" alt="" id="edificio12">
                <img src="" alt="" id="edificio13"> 
            </div>
        </div>
    </div>

    <!-- MODAL INICIO JUEGO -->

    <div id="modalInicioJuego">
        <div class="modal-content">
            <span class="close" id="closeModalInicioJuego">&times;</span>
            <?php
                echo '<h1>Bienvenido a '.$_SESSION['nombreCiudad'].'</h1>';
            ?>
            <div id="cModalInicioJuego">
                <button id="mostrarPregunta" class="boton">Iniciar Juego</button>
            </div>
        </div>
    </div>

    <!-- MODAL ESPERAR VOTOS -->

    <div id="modalEsperarVotos">
        <div class="modal-content">
            <h1>Esperando Votaciones</h1>
            <div id="cModalMostrarVotos">
                <p id="letraA"></p>
                <p id="letraB"></p>
                <p id="letraC"></p>
                <p id="letraD"></p>
            </div>
            <div class="centrarContenido">
                <p id="votosRestantes"></p>
                <div class="dot-spinner">
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                </div>
            </div>
            <div class="centrarContenido none"> 
                <p id="letraMasVotado"></p>
                <p id="textoMasVotado"></p>
                <button class="boton" id="siguientePregunta">Siguiente Preguta</button>
            </div>
        </div>
    </div>

    <!-- MODAL FINAL PARTIDA -->

    <div>
        <div id="modalFinalPartida">
            <div class="modal-content">
                <h1>Fin de la partida</h1>
                <div id="cModalFinalPartida">
                    <p id="textoFinalPartida"></p>
                    <p id="puntuacionFinalPartida"></p>
                    <a href="index.php?c=Usuarios&m=mostrarInicio" class="boton">Volver</a>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="js/views/inicioPartidaAnfitrion.js"></script>
    <script type="module" src="js/controllers/cPartida.js"></script>
    <script type="module" src="js/models/mPartida.js"></script>
    <!-- <script src="js/views/musica.js"></script> -->
</body>
</html>