<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Creacion de sala</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<audio src="audio/musicaInicio.mp3" preload="auto" id="audio"></audio>
<main>
    <nav class="icons">
            
            <div>
                <button><svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg></button>

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
    <div>
        <?php
            echo '<input type="hidden" id="idPartidaOculto" value="'.$_SESSION['idPartida'].'">';
            echo '<input type="hidden" id="idUsuarioOculto" value="'.$_SESSION['idUsuario'].'">';
            if(isset($_SESSION['nombreCiudad'])){
                echo "<h1 id='tituloJuego'>".$_SESSION['nombreCiudad']."</h1>";
            }
        ?>
        <p class="resultadoMensaje" style="display: block; color: black;"></p>
        <div class="botones-inicio">
            <h2 class="tituloSala">Código de la sala</h2>
            <?php
                if(isset($_SESSION['codSala'])){
                    echo "<h3 class='valorSala'>".$_SESSION['codSala']."</h3>";
                }
            ?>
            <h2 class="tituloSala">Jugadores actuales</h2>
            <?php
                echo '<p id="nombreJugadores" class="valorSala">';
                if(isset($datos))
                {
                    foreach($datos as $dato)
                    {
                        echo $dato['nombreUsuario']." - ";
                    }
                }
                echo "</p>";
            ?>
            <div class="enlacesSala">
                <?php
                    echo '<button class="boton" onclick="mostrarJugadores()">Actualizar jugadores</button>';
                ?>

                <?php
                    echo '<button class="boton" onclick="eliminarUsuarioPartida(\'' . $_SESSION['idUsuario'] . '\')">Salir de la sala</button>';
                ?>
            </div>
        </div>
        <div class="alcaldes">
            <div><img src="img/alcalde1.png" alt=""></div>
            <div><img src="img/alcalde2.png" alt=""></div>
        </div>
    </div>
</main>

    <!-- MODAL -->

    <div id="modalSalaExpirada">
        <div class="modal-content">
            <h1>La sala ha expirado</h1>
            <p>La sala a la que intentas unirte ha expirado, por favor, intenta unirte a otra sala</p>
            <button id="botonSalaExpirada" class="boton" onclick="salaEliminada()">Salir</button>
        </div>
    </div>
    
    <script type="module" src="js/views/musica.js"></script>
    <script type="module" src="js/views/mostrarJugadores.js"></script>
    <script type="module" src="js/views/eliminarUsuarioPartida.js"></script>
    <script type="module" src="js/controllers/cPartida.js"></script>
    <script type="module" src="js/models/mPartida.js"></script>
</body>
</html>
