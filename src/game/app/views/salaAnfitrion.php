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
    <main>
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
        <div>
            <?php
                if(isset($_SESSION['nombreCiudad'])){
                    echo "<h1 id='tituloJuego'>".$_SESSION['nombreCiudad']."</h1>";
                }
            ?>
            <div class="botones-inicio">
                <h2 class="tituloSala">Código de la sala</h2>
                <?php
                    if(isset($_SESSION['codSala'])){
                        echo "<h3 class='valorSala'>".$_SESSION['codSala']."</h3>";
                    }
                ?>
                <h2 class="tituloSala">Jugadores actuales</h2>
                <h3 class="valorSala">12</h3>
                <div class="enlacesSala">
                    <a href="index.php?c=Usuarios&m=mostrarInicio" class="enlace">Salir de la sala</a>
                    <a href="" class="enlace">Comenzar partida</a>
                </div>
            </div>
            <div class="alcaldes">
                <div><img src="img/alcalde1.png" alt=""></div>
                <div><img src="img/alcalde2.png" alt=""></div>
            </div>
        </div>
    </main>
</body>
</html>
