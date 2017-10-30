UPDATE `ideasenaccion`.`etapa` SET `estado`='1' WHERE `id`='1';
DELETE FROM `ideasenaccion`.`etapa` WHERE `id` != '1';

UPDATE `ideasenaccion`.`equipo` SET `etapa`='0' WHERE etapa='1' OR etapa='2';


DELETE FROM actividad_copia;
DELETE FROM objetivo_especifico_copia;
DELETE FROM cronograma_copia;

DELETE FROM plan_presupuestal_copia ;
DELETE FROM proyecto_copia;
DELETE FROM video;
DELETE FROM video_copia;



DELETE FROM `ideasenaccion`.`foro_comentario` WHERE `foro_id` IN (SELECT id FROM foro WHERE proyecto_id IS NOT NULL);
DELETE FROM `ideasenaccion`.`foro` WHERE proyecto_id IS NOT NULL;

/*
select * from proyecto
SELECT * FROM equipo
*/