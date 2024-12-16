<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Galería Multimedia</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
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

                    <a href="index.php?c=Usuarios&m=mostrarInicioSesionAdmin">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
                    </a>
                </div>
        
            </nav>
            <h1>Gestor de multimedia</h1>
            <section class="botones">
                <?php
                    if($_SESSION['superAdmin'] == '1'){
                        echo '<a href="index.php?c=Usuarios&m=mostrarPanelSuper">Panel Admin</a>';
                    }else {
                        echo '<a href="index.php?c=Usuarios&m=mostrarPanel">Panel Admin</a>';
                    }
                ?>
            </section>
            <!-- SECCION LOGROS -->
            <h2 class="tituloMultimedia">Logros</h2>
            <section class="containerMultimedia">
            <?php 
                foreach ($datos['logros'] as $logro) {
                    echo '<details class="detailsMultimedia">';
                    echo '    <summary class="summaryImg">';
                    echo '        <img src="'. $logro['ruta'].'" alt="' . $logro['nombreMultimedia'] . '">';
                    echo '    </summary>';
                    echo '    <div class="fondo">';
                    echo '        <div class="containerContenido">';
                    echo '            <div>';
                    echo '                <h4>Texto Logro</h4>';
                    echo '                <p>' . $logro['textoLogro'] . '</p>';
                    echo '            </div>';
                    echo '            <div>';
                    echo '                <h4>Nombre Archivo</h4>';
                    echo '                <p>' . $logro['nombreMultimedia'] . '</p>';
                    echo '            </div>';
                    echo '            <div>';
                    echo '                <h4>Ruta</h4>';
                    echo '                <p>' . $logro['ruta'] . '</p>';
                    echo '            </div>';
                    echo '        </div>';
                    echo '    </div>';
                    echo '</details>';
                }
            ?>
            </section>
            <!-- SECCION EDIFICIOS -->
            <h2 class="tituloMultimedia">Edificios</h2>
            <section class="containerMultimedia">
                <?php 
                    foreach ($datos['edificios'] as $edificio) {
                        echo '<details class="detailsMultimedia">';
                        echo '    <summary class="summaryImg">';
                        echo '        <img src="' . $edificio['ruta'] . '" alt="' . $edificio['nombreMultimedia'] . '">';
                        echo '    </summary>';
                        echo '    <div class="fondo">';
                        echo '        <div class="containerContenido">';
                        echo '            <div>';
                        echo '                <h4>Nombre Archivo</h4>';
                        echo '                <p>' . $edificio['nombreMultimedia'] . '</p>';
                        echo '            </div>';
                        echo '            <div>';
                        echo '                <h4>Ruta</h4>';
                        echo '                <p>' . $edificio['ruta'] . '</p>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '</details>';
                    }
                ?>
            </section>
            <!-- SECCION PREGUNTAS -->
            <h2 class="tituloMultimedia">Preguntas</h2>
            <section class="containerMultimedia">
                <?php 
                    foreach ($datos['preguntas'] as $pregunta) {
                        echo '<details class="detailsMultimedia">';
                        echo '    <summary class="summaryImg">';
                        echo '        <img src="' . $pregunta['ruta'] . '" alt="' . $pregunta['nombreMultimedia'] . '">';
                        echo '    </summary>';
                        echo '    <div class="fondo">';
                        echo '        <div class="containerContenido">';
                        echo '            <div>';
                        echo '                <h4>Texto Pregunta</h4>';
                        echo '                <p>' . $pregunta['texto'] . '</p>';
                        echo '            </div>';
                        echo '            <div>';
                        echo '                <h4>Nombre Archivo</h4>';
                        echo '                <p>' . $pregunta['nombreMultimedia'] . '</p>';
                        echo '            </div>';
                        echo '            <div>';
                        echo '                <h4>Ruta</h4>';
                        echo '                <p>' . $pregunta['ruta'] . '</p>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '</details>';
                    }
                ?>
        </section>
        </main>
        <div id="modalEliminar" class="modal">
            <div class="modal-content">
                <h2>¿Estás seguro de que quieres eliminar esta pregunta?</h2>
                <div class="modal-buttons">
                    <button id="confirmarEliminar" class="boton">Sí, eliminar</button>
                    <button id="cancelarEliminar" class="boton boton-cancelar">Cancelar</button>
                </div>
            </div>
        </div>
        <script type="module" src="js/views/eliminar.js"></script>
    </body>
</html>