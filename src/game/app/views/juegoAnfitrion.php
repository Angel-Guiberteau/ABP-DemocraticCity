<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="bodyJuego">
    <?php
        echo '<input type="hidden" id="idPartidaOculto" value="'.$_SESSION['idPartida'].'">';
    ?>
    <div id="juego">
        <nav class="inicio">
            <button><svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="#000000"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-volume"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8a5 5 0 0 1 0 8" /><path d="M17.7 5a9 9 0 0 1 0 14" /><path d="M6 15h-2a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h2l3.5 -4.5a.8 .8 0 0 1 1.5 .5v14a.8 .8 0 0 1 -1.5 .5l-3.5 -4.5" /></svg></button>
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
                    echo '<button id="economia">Economia: 5</button>';
                    echo '<button id="sanidad">Sanidad: 5</button>';
                    echo '<button id="seguridad">Seguridad: 5</button>';
                    echo '<button id="educacion">Educación: 5</button>';
                echo '</div>';
            ?>
            <div class="mapa">
                <div id="edificio1"></div>
                <div id="edificio2"></div>
                <div id="edificio3"></div>
                <div id="edificio4"></div>
                <div id="edificio5"></div>
                <div id="edificio6"></div>
                <div id="edificio7"></div>
                <div id="edificio8"></div>
                <div id="edificio9"></div>
                <div id="edificio10"></div>
                <div id="edificio11"></div>
                <div id="edificio12"></div>
                <div id="edificio13"></div>
                <div id="edificio14"></div>
                <div id="edificio15"></div>
                <div id="edificio16"></div>
            </div>

            <!-- <div>
                <p>Anfitrión Pregunta</p>
            </div>
            <div class="respuestas">
                <button>Respuesta 1</button>
                <button>Respuesta 2</button>
                <button>Respuesta 3</button>
                <button>Respuesta 4</button>
            </div> -->
            <!-- <div class="medidores">
                <button>Economía: 5</button>
                <button>Sanidad: 5</button>
                <button>Seguridad: 5</button>
                <button>Educación: 5</button>
            </div> -->
        </div>
        
    </div>
    <script type="module" src="js/views/mostrarPregunta.js"></script>
    <script type="module" src="js/controllers/cPartida.js"></script>
    <script type="module" src="js/models/mPartida.js"></script>
    <!-- <script src="js/views/musica.js"></script> -->
</body>
</html>