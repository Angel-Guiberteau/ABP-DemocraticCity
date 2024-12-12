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
    <div id="juego">
        <nav class="inicio">
            <button><svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="#000000"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-volume"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8a5 5 0 0 1 0 8" /><path d="M17.7 5a9 9 0 0 1 0 14" /><path d="M6 15h-2a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h2l3.5 -4.5a.8 .8 0 0 1 1.5 .5v14a.8 .8 0 0 1 -1.5 .5l-3.5 -4.5" /></svg></button>
        </nav>
        <div class="preguntas">
            <div>
                <p>Anfitrión Pregunta</p>
            </div>
            <div class="respuestas">
                <button>Respuesta 1</button>
                <button>Respuesta 2</button>
                <button>Respuesta 3</button>
                <button>Respuesta 4</button>
            </div>
            <div class="medidores">
                <button>Economía: 5</button>
                <button>Sanidad: 5</button>
                <button>Seguridad: 5</button>
                <button>Educación: 5</button>
            </div>
        </div>
        <div class="mapa">
            <div id="edificio1"></div>
            <div id="edificio2"></div>
        </div>
    </div>
</body>
</html>