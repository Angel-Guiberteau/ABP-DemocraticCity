INSERT INTO Respuestas
(idPregunta, letraRespuesta, respuesta, educacion, sanidad, seguridad,economia)
VALUES (1, 'a', 'Cebedonnalds', -1,0,-2,2);
INSERT INTO Respuestas
(idPregunta, letraRespuesta, respuesta, educacion, sanidad, seguridad,economia)
VALUES (1, 'b', 'Policía local', 0, 0,2,-1);
INSERT INTO Respuestas
(idPregunta, letraRespuesta, respuesta, educacion, sanidad, seguridad,economia)
VALUES (1, 'c', 'Centro de salud', 0, 2,1,-1);
INSERT INTO Respuestas
(idPregunta, letraRespuesta, respuesta, educacion, sanidad, seguridad,economia)
VALUES (1, 'd', 'Colegio', 2, 0,0,0);

SELECT * from Preguntas INNER JOIN Respuestas ON Preguntas.idPregunta = Respuestas.idPregunta;



DROP TABLE IF EXISTS Respuestas;
DROP TABLE IF EXISTS Partidas_preguntas;
DROP TABLE IF EXISTS Preguntas;
DROP TABLE IF EXISTS Partidas_logros;
DROP TABLE IF EXISTS Logros;
DROP TABLE IF EXISTS Edificios;
DROP TABLE IF EXISTS Usuarios_partidas;
DROP TABLE IF EXISTS Partidas;
DROP TABLE IF EXISTS Usuarios;
DROP TABLE IF EXISTS Administradores;
DROP TABLE IF EXISTS Multimedia;