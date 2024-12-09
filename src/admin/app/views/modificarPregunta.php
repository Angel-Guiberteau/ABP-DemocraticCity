<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <audio src="audio/musicaInicio.mp3" preload="auto" id="audio"></audio>
    <main>
        <div class="icons">
            <button id="musica" class="unmute"><svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="#000000"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-volume"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8a5 5 0 0 1 0 8" /><path d="M17.7 5a9 9 0 0 1 0 14" /><path d="M6 15h-2a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h2l3.5 -4.5a.8 .8 0 0 1 1.5 .5v14a.8 .8 0 0 1 -1.5 .5l-3.5 -4.5" /></svg></button>
            <button id="musica2" class="mute"><svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-volume-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8a5 5 0 0 1 1.912 4.934m-1.377 2.602a5 5 0 0 1 -.535 .464" /><path d="M17.7 5a9 9 0 0 1 2.362 11.086m-1.676 2.299a9 9 0 0 1 -.686 .615" /><path d="M9.069 5.054l.431 -.554a.8 .8 0 0 1 1.5 .5v2m0 4v8a.8 .8 0 0 1 -1.5 .5l-3.5 -4.5h-2a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h2l1.294 -1.664" /><path d="M3 3l18 18" /></svg></button>
        </div>
        <div>
            <h1>Modificar pregunta</h1>
            <form id="formularioModificarPregunta" action="index.php?c=Preguntas&m=cGuardarModificacionPregunta" method="POST">
            <?php
                echo '<input type="number" placeholder="Introduce la pregunta" name="idPregunta" id="idPregunta" value="'.$datos['idPregunta'].'" hidden>';
                echo '<input type="text" placeholder="Introduce la pregunta" name="pregunta" id="pregunta" value="'.$datos['texto'].'">';
                
                $contador = 1; // Contador para nombres e IDs únicos
                foreach ($datos['respuestas'] as $respuesta) {
                    echo ' <input type="text" placeholder="Respuesta '.$contador.'" name="respuesta'.$contador.'" id="respuesta'.$contador.'" value="'.$respuesta['respuesta'].'">';
                    echo '<div>';
                    echo '<input type="number" placeholder="Educación" name="educacion'.$contador.'" id="educacion'.$contador.'" value="'.$respuesta['educacion'].'">';
                    echo '<input type="number" placeholder="Sanidad" name="sanidad'.$contador.'" id="sanidad'.$contador.'" value="'.$respuesta['sanidad'].'">';
                    echo '<input type="number" placeholder="Seguridad" name="seguridad'.$contador.'" id="seguridad'.$contador.'" value="'.$respuesta['seguridad'].'">';
                    echo '<input type="number" placeholder="Economía" name="economia'.$contador.'" id="economia'.$contador.'" value="'.$respuesta['economia'].'">';
                    echo '</div>';
                    $contador++; // Incrementar para la siguiente respuesta
                }
            ?>

                
                    
                    
                    
                    
                
                <!-- <input type="text" placeholder="Respuesta B" name="respuesta2" id="respuesta2">
                <div>
                    <input type="number" placeholder="Educación" name="educacion2" id="educacion2">
                    <input type="number" placeholder="Sanidad" name="sanidad2" id="sanidad2">
                    <input type="number" placeholder="Seguridad" name="seguridad2" id="seguridad2">
                    <input type="number" placeholder="Economía" name="economia2" id="economia2">
                </div>
                <input type="text" placeholder="Respuesta C" name="respuesta3" id="respuesta3">
                <div>
                    <input type="number" placeholder="Educación" name="educacion3" id="educacion3">
                    <input type="number" placeholder="Sanidad" name="sanidad3" id="sanidad3">
                    <input type="number" placeholder="Seguridad" name="seguridad3" id="seguridad3">
                    <input type="number" placeholder="Economía" name="economia3" id="economia3">
                </div>
                <input type="text" placeholder="Respuesta D" name="respuesta4" id="respuesta4">
                <div>
                    <input type="number" placeholder="Educación" name="educacion4" id="educacion4">
                    <input type="number" placeholder="Sanidad" name="sanidad4" id="sanidad4">
                    <input type="number" placeholder="Seguridad" name="seguridad4" id="seguridad4">
                    <input type="number" placeholder="Economía" name="economia4" id="economia4">
                </div> -->
                <input type="submit" class="boton" value="Añadir">
                <p><a href="index.php?c=Usuarios&m=mostrarPanelSuper">Panel Admin</a></p>
            </form>
            <div class="alcaldes">
                <div><img src="img/alcalde1.png" alt=""></div>
                <div><img src="img/alcalde2.png" alt=""></div>
            </div>
            
        </div>
    </main>
    
    <!-- <script src="js/musica.js"></script> -->
</body>
</html>