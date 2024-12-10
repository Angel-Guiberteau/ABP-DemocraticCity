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
                <label for="nombreSala">Introduce el nombre de la ciudad</label>
                <input type="text" id="nombreSala" name="nombreSala" required>
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
                <label for="codigoSala">Introduce el código de la sala</label>
                <input type="text" id="codigoSala" name="codigoSala" required>
                <button type="submit" class="boton">Unirse</button>
            </form>
        </div>
    </div>

    <script type="module" src="js/views/crearSala.js"></script>
    <script type="module" src="js/views/unirseSala.js"></script>
</body>
</html>
