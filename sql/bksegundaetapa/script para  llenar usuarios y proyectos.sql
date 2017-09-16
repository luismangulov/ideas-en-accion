USE ideasenaccion;

-- Tabla estudiante
INSERT INTO estudiante VALUES(20,5836,'RODOLFO','MORI','LOPEZ',NULL,'M','75678901','2001/09/11','alumno06@gmail.com',991125809,3);
INSERT INTO estudiante VALUES(21,5836,'KATIA','SOLIS','INFANTE',NULL,'F','78976434','2000/09/21','alumno07@gmail.com',992765863,3);
INSERT INTO estudiante VALUES(22,5836,'LUIS','ROSAS','RETES',NULL,'M','78627422','2000/09/22','alumno08@gmail.com',994100278,3);
INSERT INTO estudiante VALUES(23,5836,'JAIME','MEIER','CASAS',NULL,'M','78626425','2000/08/12','alumno09@gmail.com',954667271,3);
INSERT INTO estudiante VALUES(24,5836,'LORENA','CARO','MOLINA',NULL,'F','78629920','2000/07/16','alumno10@gmail.com',986670455,3);
INSERT INTO estudiante VALUES(25,5836,'HENRY','SOTO','TELLO',NULL,'M','19176498','1979/02/16','docente2@gmail.com',999456783,6);

-- Tabla usuario
INSERT INTO usuario VALUES(111,'alumno06@gmail.com','',1,NULL,NULL,20,NULL,NULL,'2017/09/16',NULL,2,'2017/09/16');
INSERT INTO usuario VALUES(112,'alumno07@gmail.com','',1,NULL,NULL,21,NULL,NULL,'2017/09/16',NULL,2,'2017/09/16');
INSERT INTO usuario VALUES(113,'alumno08@gmail.com','',1,NULL,NULL,22,NULL,NULL,'2017/09/16',NULL,2,'2017/09/16');
INSERT INTO usuario VALUES(114,'alumno09@gmail.com','',1,NULL,NULL,23,NULL,NULL,'2017/09/16',NULL,2,'2017/09/16');
INSERT INTO usuario VALUES(115,'alumno10@gmail.com','',1,NULL,NULL,24,NULL,NULL,'2017/09/16',NULL,2,'2017/09/16');
INSERT INTO usuario VALUES(116,'docente2@gmail.com','',1,NULL,NULL,25,NULL,NULL,'2017/09/16',NULL,2,'2017/09/16');

-- Tabla equipo
INSERT INTO equipo VALUES(3,5,'Tercer Equipo','Proyecto Increíble',1,'2017/08/14',1,NULL);

-- Tabla integrante
INSERT INTO integrante VALUES(12,3,20,1,2,0);
INSERT INTO integrante VALUES(13,3,21,2,2,0);
INSERT INTO integrante VALUES(14,3,22,2,2,0);
INSERT INTO integrante VALUES(15,3,23,2,2,1);
INSERT INTO integrante VALUES(16,3,24,2,2,0);
INSERT INTO integrante VALUES(17,3,25,2,2,0);

-- Tabla proyecto
INSERT INTO proyecto VALUES(3,'Proyecto Increíble','resumen resumido',NULL,'Barrio',111,5,3,NULL,15,NULL,NULL,NULL,0,NULL,0,NULL,NULL,NULL,0);


-- Tabla objetivos_especificos
INSERT INTO objetivo_especifico VALUES(3,3,'Objetivo específico');

-- Tabla objetivo_especifico_copia
INSERT INTO objetivo_especifico_copia VALUES(3,3,'Objetivo específico',1);

-- Tabla actividad
INSERT INTO actividad VALUES(3,3,'Actividad Paranormal',NULL,1);

-- Tabla actividad_copia
INSERT INTO actividad_copia VALUES(3,3,'Actividad Paranormal',NULL,1,1);

-- Tabla video
INSERT INTO video VALUES(3,3,'https://www.youtube.com/watch?v=ChV5BZ8SmS0',1,1);

-- Tabla video_copia
INSERT INTO video_copia VALUES(3,3,'https://www.youtube.com/watch?v=ChV5BZ8SmS0',1,1)

SELECT * FROM estudiante


INSERT INTO `ideasenaccion`.`reflexion`(`id`,`proyecto_id`,`user_id`,`p1`,`p2`,`p3`,`p4`,`p5_1`,`p5_2`,`p5_3`,`p5_4`,`p5_5`,`p5_6`,`p5_7`,`p5_8`,`p6`,`p7_1`,`p7_2`,`p7_3`,`p7_4`,`p7_5`,`p7_6`,`p7_7`,`p7_8`,`p8`) VALUES ( NULL,'2','9',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ideasenaccion`.`reflexion`(`id`,`proyecto_id`,`user_id`,`p1`,`p2`,`p3`,`p4`,`p5_1`,`p5_2`,`p5_3`,`p5_4`,`p5_5`,`p5_6`,`p5_7`,`p5_8`,`p6`,`p7_1`,`p7_2`,`p7_3`,`p7_4`,`p7_5`,`p7_6`,`p7_7`,`p7_8`,`p8`) VALUES ( NULL,'3','9',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

