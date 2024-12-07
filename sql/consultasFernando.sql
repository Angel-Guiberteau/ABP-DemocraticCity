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

