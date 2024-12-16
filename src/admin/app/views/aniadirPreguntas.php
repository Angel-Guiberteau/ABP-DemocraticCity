<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Añadir Preguntas</title>
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

                <a href="index.php?c=Usuarios&m=mostrarInicioSesionAdmin">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
                </a>
            </div>
        
        </nav>
        <div>
            <h1>Añadir pregunta</h1>
            <form enctype="multipart/form-data" id="formularioAniadirPreguntas">
                <?php
                    if(isset($_GET['operacion']) &&$_GET['operacion'] == 'correcto'){
                        echo '<div class="registroExistoso">';
                        echo 'La pregunta se ha añadido correctamente';
                        echo '</div>';
                    }
                ?>
                <p id="validacionImagenes"></p>
                <div class="validacionPregunta"></div> <!-- Agregado para validación -->
                <input type="text" placeholder="Introduce la pregunta" name="pregunta" id="pregunta">
                <input type="file" name="imagenPregunta" id="imagenPregunta" class="inputFile">
                
                <div class="validacionRespuesta1"></div>
                <input type="text" placeholder="Respuesta A" name="respuesta1" id="respuesta1">
                <input type="file" name="respuesta1file" id="respuesta1file" class="inputFile">

                <div>
                    <input type="number" placeholder="Educación" name="educacion1" id="educacion1">
                    <div class="validacionEducacion1"></div>
                    <input type="number" placeholder="Sanidad" name="sanidad1" id="sanidad1">
                    <div class="validacionSanidad1"></div>
                    <input type="number" placeholder="Seguridad" name="seguridad1" id="seguridad1">
                    <div class="validacionSeguridad1"></div>
                    <input type="number" placeholder="Economía" name="economia1" id="economia1">
                    <div class="validacionEconomia1"></div>
                </div>

                <div class="validacionRespuesta2"></div>
                <input type="text" placeholder="Respuesta B" name="respuesta2" id="respuesta2">
                <input type="file" name="respuesta2file" id="respuesta2file" class="inputFile">

                <div>
                    <input type="number" placeholder="Educación" name="educacion2" id="educacion2">
                    <div class="validacionEducacion2"></div>
                    <input type="number" placeholder="Sanidad" name="sanidad2" id="sanidad2">
                    <div class="validacionSanidad2"></div>
                    <input type="number" placeholder="Seguridad" name="seguridad2" id="seguridad2">
                    <div class="validacionSeguridad2"></div>
                    <input type="number" placeholder="Economía" name="economia2" id="economia2">
                    <div class="validacionEconomia2"></div>
                </div>

                <div class="validacionRespuesta3"></div>
                <input type="text" placeholder="Respuesta C" name="respuesta3" id="respuesta3">
                <input type="file" name="respuesta3file" id="respuesta3file" class="inputFile">

                <div>
                    <input type="number" placeholder="Educación" name="educacion3" id="educacion3">
                    <div class="validacionEducacion3"></div>
                    <input type="number" placeholder="Sanidad" name="sanidad3" id="sanidad3">
                    <div class="validacionSanidad3"></div>
                    <input type="number" placeholder="Seguridad" name="seguridad3" id="seguridad3">
                    <div class="validacionSeguridad3"></div>
                    <input type="number" placeholder="Economía" name="economia3" id="economia3">
                    <div class="validacionEconomia3"></div>
                </div>

                <div class="validacionRespuesta4"></div>
                <input type="text" placeholder="Respuesta D" name="respuesta4" id="respuesta4">
                <input type="file" name="respuesta4file" id="respuesta4file" class="inputFile">

                <div>
                    <input type="number" placeholder="Educación" name="educacion4" id="educacion4">
                    <div class="validacionEducacion4"></div>
                    <input type="number" placeholder="Sanidad" name="sanidad4" id="sanidad4">
                    <div class="validacionSanidad4"></div>
                    <input type="number" placeholder="Seguridad" name="seguridad4" id="seguridad4">
                    <div class="validacionSeguridad4"></div>
                    <input type="number" placeholder="Economía" name="economia4" id="economia4">
                    <div class="validacionEconomia4"></div>
                </div>

                <input type="submit" class="boton" value="Registrar" id="aniadirPregunta" disabled>
                <p><a href="index.php?c=Usuarios&m=mostrarPanelSuper">Panel Admin</a></p>
                <p><a href="index.php?c=Preguntas&m=cMostrarPreguntasyRespuestas">Volver atras</a></p>
            </form>
            <div class="alcaldes">
                <div><img src="img/alcalde1.png" alt=""></div>
                <div><img src="img/alcalde2.png" alt=""></div>
            </div>
        </div>
    </main>
    <script type="module" src="js/views/anadirPregunta.js"></script>
    <script type="module" src="js/controllers/cAnadirPregunta.js"></script>
    <script type="module" src="js/models/mAnadirPregunta.js"></script>
    <!-- <script src="js/musica.js"></script> -->
</body>
</html>
