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
            <h1>Registrar Administrador</h1>
            <form id="formularioRegistroAdmin">
                <?php
                    if(isset($_GET['registro']) == 'correcto'){
                        echo '<div class="registroExistoso">';
                        echo 'El registro se ha completado correctamente';
                        echo '</div>';
                    }
                ?>
                <p class="registrarseIncorrecto"></p>
                <p class="nombreUsuarioValidacion">Introduce un nombre de usuario correcto</p>
                <input type="text" placeholder="Nombre de usuario" name="usuario" id="nombre" blur="validarFormulario">
                <p class="passwUsuarioValidacion">Introduce una contraseña correcta</p>
                <input type="password" placeholder="Contraseña" name="passw" id="passw">
                <p class="rpasswUsuarioValidacion"></p>
                <input type="password" placeholder="Repetir contraseña" name="rpassw" id="rpassw">
                <label id="mostrarpassw">
                    <input id="verPassw" type="checkbox" onclick="mostrarPassw()">
                    Mostrar contraseña
                </label>
                <input type="submit" class="boton" value="Registrar" disabled id="registroAdmin">
                <p><a href="index.php?c=Usuarios&m=mostrarPanelSuper">Panel Admin</a></p>
            </form>
            <div class="alcaldes">
                <div><img src="img/alcalde1.png" alt=""></div>
                <div><img src="img/alcalde2.png" alt=""></div>
            </div>
            
        </div>
    </main>
    <script type="module" src="js/views/registrarse.js"></script>
    <script type="module" src="js/controllers/cRegistrarse.js"></script>
    <script type="module" src="js/models/mRegistrarse.js"></script>
    <!-- <script src="js/musica.js"></script> -->
</body>
</html>