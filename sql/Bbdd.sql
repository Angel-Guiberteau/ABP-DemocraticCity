
CREATE TABLE Administradores (
    idUsuario TINYINT UNSIGNED AUTO_INCREMENT,
    nombreUsuario VARCHAR(255) NOT NULL,
    passAdmin VARCHAR(255) NOT NULL,
    superAdmin char(1) NOT NULL,
    CONSTRAINT pk_admin PRIMARY KEY (idUsuario),
    CONSTRAINT csu_admin UNIQUE (nombreUsuario)
);

CREATE TABLE Multimedia (
    idMultimedia TINYINT UNSIGNED AUTO_INCREMENT,
    nombreMultimedia VARCHAR(50) NOT NULL,
    ruta VARCHAR(100) NOT NULL,
    tipo CHAR (1) NOT NULL,
    hasheo VARCHAR (255) NULL,
    CONSTRAINT pk_multimedia PRIMARY KEY (idMultimedia),
    CONSTRAINT check_tipo CHECK (tipo IN ('E', 'P', 'U', 'L')) 
);

CREATE TABLE Usuarios (
    idUsuario SMALLINT UNSIGNED AUTO_INCREMENT,
    nombreUsuario VARCHAR(255) NOT NULL,
    passUsuario VARCHAR(255) NOT NULL,
    idMultimedia TINYINT UNSIGNED NULL,
    CONSTRAINT pk_usuario PRIMARY KEY (idUsuario),
    CONSTRAINT fk_usuario FOREIGN KEY (idMultimedia) REFERENCES Multimedia (idMultimedia),
    CONSTRAINT csu_usuario UNIQUE (nombreUsuario)
);

CREATE TABLE Partidas (
    idPartida SMALLINT UNSIGNED AUTO_INCREMENT,
    codSala CHAR(6) NOT NULL,
    puntuacion TINYINT UNSIGNED NOT NULL,
    nombreCiudad VARCHAR(100) NOT NULL,
    vEducacion TINYINT NOT NULL,
    vSanidad TINYINT NOT NULL,
    vSeguridad TINYINT NOT NULL,
    vEconomia TINYINT NOT NULL,
    empezada CHAR(1) NOT NULL,
    idAnfitrion SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT pk_partida PRIMARY KEY (idPartida),
    CONSTRAINT fk_partida FOREIGN KEY (idAnfitrion) REFERENCES Usuarios (idUsuario),
    CONSTRAINT chk_empezada CHECK (empezada IN ('s', 'n', 't')),
    CONSTRAINT chk_vEducacion CHECK (vEducacion BETWEEN -10 AND 10),
    CONSTRAINT chk_vSanidad CHECK (vSanidad BETWEEN -10 AND 10),
    CONSTRAINT chk_vSeguridad CHECK (vSeguridad BETWEEN -10 AND 10),
    CONSTRAINT chk_vEconomia CHECK (vEconomia BETWEEN -10 AND 10)
);

CREATE TABLE Usuarios_partidas (
    idPartida SMALLINT UNSIGNED,
    idUsuario SMALLINT UNSIGNED,
    CONSTRAINT pk_usuario_partida PRIMARY KEY (idUsuario, idPartida),
    CONSTRAINT fk_Usuario_usuario_partida FOREIGN KEY (idUsuario) REFERENCES Usuarios (idUsuario),
    CONSTRAINT fk_Partida_usuario_partida FOREIGN KEY (idPartida) REFERENCES Partidas (idPartida) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Edificios (
    idEdificio TINYINT UNSIGNED AUTO_INCREMENT,
    nombreEdificio VARCHAR(255) NOT NULL,
    idMultimedia TINYINT UNSIGNED NULL,
    CONSTRAINT pk_edificio PRIMARY KEY (idEdificio),
    CONSTRAINT fk_edificio FOREIGN KEY (idMultimedia) REFERENCES Multimedia (idMultimedia) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Logros(
    idLogro TINYINT UNSIGNED AUTO_INCREMENT,
    textoLogro VARCHAR(255) NOT NULL,
    idMultimedia TINYINT UNSIGNED NULL,
    CONSTRAINT pk_logro PRIMARY KEY (idLogro),
    CONSTRAINT fk_logro FOREIGN KEY (idMultimedia) REFERENCES Multimedia (idMultimedia)
);

CREATE TABLE Partidas_logros(
    idPartida SMALLINT UNSIGNED,
    idLogro TINYINT UNSIGNED,
    CONSTRAINT pk_partida_logro PRIMARY KEY (idPartida, idLogro),
    CONSTRAINT fk_partida_partida_logro FOREIGN KEY (idPartida) REFERENCES Partidas (idPartida),
    CONSTRAINT fk_logro_partida_logro FOREIGN KEY (idLogro) REFERENCES Logros (idLogro)
);

CREATE TABLE Preguntas(
    idPregunta TINYINT UNSIGNED AUTO_INCREMENT,
    texto VARCHAR(255) NOT NULL,
    idMultimedia TINYINT UNSIGNED NULL,
    CONSTRAINT pk_pregunta PRIMARY KEY (idPregunta),
    CONSTRAINT fk_pregunta FOREIGN KEY (idMultimedia) REFERENCES Multimedia (idMultimedia) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Partidas_preguntas(
    idPartida SMALLINT UNSIGNED,
    idPregunta TINYINT UNSIGNED,
    CONSTRAINT pk_partida_pregunta PRIMARY KEY (idPartida, idPregunta),
    CONSTRAINT fk_partida_partida_pregunta FOREIGN KEY (idPartida) REFERENCES Partidas (idPartida) ON DELETE CASCADE ON UPDATE CASCADE, 
    CONSTRAINT fk_pregunta_partida_pregunta FOREIGN KEY (idPregunta) REFERENCES Preguntas (idPregunta) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Respuestas(
    idPregunta TINYINT UNSIGNED,
    letraRespuesta CHAR(1) NOT NULL,
    educacion TINYINT NOT NULL,
    sanidad TINYINT NOT NULL,
    seguridad TINYINT NOT NULL,
    economia TINYINT NOT NULL,
    idEdificio TINYINT UNSIGNED NULL,    
    respuesta VARCHAR(255) NOT NULL,
    CONSTRAINT pk_respuesta PRIMARY KEY (idPregunta, letraRespuesta),
    CONSTRAINT fk_respuesta_pregunta FOREIGN KEY (idPregunta) REFERENCES Preguntas (idPregunta) ON UPDATE CASCADE ON DELETE CASCADE, 
    CONSTRAINT fk_respuesta_edificio FOREIGN KEY (idEdificio) REFERENCES Edificios (idEdificio),
    CONSTRAINT chk_letraRespuesta CHECK (letraRespuesta IN ('A', 'B', 'C', 'D')),
    CONSTRAINT chk_educacion CHECK (educacion BETWEEN -10 AND 10),
    CONSTRAINT chk_sanidad CHECK (sanidad BETWEEN -10 AND 10),
    CONSTRAINT chk_seguridad CHECK (seguridad BETWEEN -10 AND 10),
    CONSTRAINT chk_economia CHECK (economia BETWEEN -10 AND 10)
);