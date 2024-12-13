<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modificación de preguntas</title>
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
            <h1>Gestor de preguntas</h1>
            <section class="botones">
                <?php
                    // if($_SESSION['superAdmin'] == '1'){
                    //     echo '<a href="index.php?c=Usuarios&m=mostrarPanelSuper">Panel Admin</a>';
                    // }else {
                    //     echo '<a href="index.php?c=Usuarios&m=mostrarPanel">Panel Admin</a>';
                    // }
                ?>
                <a href="index.php?c=Usuarios&m=mostrarPanelSuper">Panel Admin</a>
                <a href="index.php?c=Preguntas&m=mostrarAniadirPreguntas">Añadir preguntas</a>
            </section>
            <section>

            <?php
                if($datos){
                    foreach ($datos as $pregunta) {
                        echo '<details>';
                            echo '<summary>'.$pregunta['texto'].'</summary>';
                                foreach($pregunta['respuestas'] as $respuesta){
                                    echo '<div class="summaryContainer">';
                                        echo '<div>';
                                        echo '<table>';
                                            echo '<tr>';
                                                echo '<td rowspan="2" colspan="2" class="center">';
                                                    echo '<h2>'.$respuesta['letraRespuesta'].' - '.$respuesta['respuesta'].'</h2>';
                                                echo '</td>';
                                                echo '<td>Educacion</td>';
                                                echo '<td>Sanidad</td>';
                                                echo '<td>Seguridad</td>';
                                                echo '<td>Economia</td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                                echo '<td class="center">'.$respuesta['educacion'].'</td>';
                                                echo '<td class="center">'.$respuesta['sanidad'].'</td>';
                                                echo '<td class="center">'.$respuesta['seguridad'].'</td>';
                                                echo '<td class="center">'.$respuesta['economia'].'</td>';
                                            echo '</tr>';
                                        echo '</table>';
                                    echo '</div>';
                                echo '</div>';
                            }
                            echo '<div class="botonesPreguntas">';
                                echo '<form class="sinnada2" action="index.php?c=Preguntas&m=cEliminarPregunta" method="POST" id="formEliminar">';
                                    echo '<input type="number" value="'.$pregunta['idPregunta'].'" hidden name="idPregunta">';
                                    echo '<button type="button" class="boton eliminar" data-id="'.$pregunta['idPregunta'].'">Eliminar</button>';
                                echo '</form>';
                            
                                echo '<form  class="sinnada" action="index.php?c=Preguntas&m=cModificarPregunta" method="POST">';
                                    echo '<input type="number" value="'.$pregunta['idPregunta'].'" hidden name="idPregunta">';
                                    echo '<input type="submit" class="boton" value="Modificar">';
                                echo '</form>';
                            echo '</div>';
                        echo '</details>';

                                    
                    }
                    
                }else{
                    echo '<p>No hay preguntas para mostrar, trate de añadir alguna.</p>';
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