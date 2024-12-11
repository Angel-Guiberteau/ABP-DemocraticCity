<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Democratic City</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="icons">
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
            </svg>
        </button>
        
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-volume">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M15 8a5 5 0 0 1 0 8"/>
                <path d="M17.7 5a9 9 0 0 1 0 14"/>
                <path d="M6 15h-2a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h2l3.5 -4.5a.8 .8 0 0 1 1.5 .5v14a.8 .8 0 0 1 -1.5 .5l-3.5 -4.5"/>
            </svg>
        </button>
        <a href="index.php?c=Usuarios&m=cerrarSesionUser">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"/>
                <path d="M9 12h12l-3 -3"/>
                <path d="M18 15l3 -3"/>
            </svg>
        </a>
    </nav>
    <main>
        <nav class="icons">
            <!-- Botones de navegación existentes -->
        </nav>
        <div>
            <h1 id="tituloJuego">Democratic City</h1>
            <div class="botones-inicio">
                <a href="#" class="boton" id="crearSalaButton">Crear Sala</a>
                <a href="#" class="boton" id="unirseSalaButton">Unirse a una sala</a>
                <a href="index.php?c=Usuarios&m=mostrarInicio" class="enlace">Volver al inicio</a>
            </div>
            <div class="alcaldes">
                <div><img src="img/alcalde1.png" alt=""></div>
                <div><img src="img/alcalde2.png" alt=""></div>
            </div>
        </div>
    </main>

    <!-- Modal para Crear Sala -->
    <div id="modalCrearSala">
        <div class="modal-content">
            <span class="close" id="closeModalCrearSala">&times;</span>
            <h1>Crear Sala</h1>
            <form id="crearSalaForm">
                <label for="nombreCiudad">Introduce el nombre de la ciudad</label>
                <?php
                    echo '<input type="number" hidden id="idAnfitrion" name="idAnfitrion" value="'.$_SESSION['idUsuario'].'">';
                ?>
                <input type="text" id="nombreCiudad" name="nombreCiudad" required>
                <button type="submit" class="boton">Crear</button>
            </form>
        </div>
    </div>

    <!-- Modal para Unirse a Sala -->
    <div id="modalUnirseSala">
        <div class="modal-content">
            <span class="close" id="closeModalUnirseSala">&times;</span>
            <h1>Unirse a Sala</h1>
            <form id="unirseSalaForm">
                <?php
                    echo '<input type="number" hidden id="idUsuario" name="idUsuario" value="'.$_SESSION['idUsuario'].'">';
                ?>
                <label for="codigoSala">Introduce el código de la sala</label>
                <input type="text" id="codigoSala" name="codigoSala" required>
                <button type="submit" class="boton">Unirse</button>
            </form>
        </div>
    </div>

    <script type="module" src="js/views/unirseSala.js"></script>
    <script type="module" src="js/views/crearSala.js"></script>
    <script type="module" src="js/controllers/cPartida.js"></script>
    <script type="module" src="js/models/mPartida.js"></script>
</body>
</html>
