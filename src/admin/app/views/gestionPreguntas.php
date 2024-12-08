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
                <a href="index.php?c=Usuarios&m=cerrarSesionAdmin">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
                </a>
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
                <button>Buscar</button>
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
                                echo '<a class="boton" href="">Eliminar</a> ';
                                echo '<a class="boton" href="">Modificar</a> ';
                            echo '</div>';
                        echo '</details>';

                                    
                    }
                    
                }else{
                    echo '<p>No hay preguntas para mostrar, trate de añadir alguna.</p>';
                }
                
            ?>

            </section>
        </main>
    </body>
</html>