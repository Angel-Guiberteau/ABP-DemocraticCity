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
        </div>
        <div class="mapa">
            <div id="edificio1"></div>
            <div id="edificio2"></div>
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
            <p>Esperando Anfitrión</p>
            </div>
        </div>
    </div>
    
    <script type="module" src="js/views/mostrarPreguntaUsuario.js"></script>
    <script type="module" src="js/controllers/cPartida.js"></script>
    <script type="module" src="js/models/mPartida.js"></script>
</body>
</html>