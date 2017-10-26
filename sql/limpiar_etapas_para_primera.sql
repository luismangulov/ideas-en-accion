UPDATE `ideasenaccion`.`etapa` SET `estado`='1' WHERE `id`='1';
DELETE FROM `ideasenaccion`.`etapa` WHERE `id` != '1';

UPDATE `ideasenaccion`.`equipo` SET `etapa`='1' WHERE `id`='1';
UPDATE `ideasenaccion`.`equipo` SET `etapa`='1' WHERE `id`='2';


DELETE FROM actividad_copia WHERE etapa=2;
DELETE FROM objetivo_especifico_copia WHERE etapa=2;
DELETE FROM cronograma_copia WHERE etapa=2;

DELETE FROM plan_presupuestal_copia WHERE etapa=2;
DELETE FROM proyecto_copia WHERE etapa=2;
DELETE FROM video WHERE etapa=2;
DELETE FROM video_copia WHERE etapa=2;

DELETE FROM reflexion;

DELETE FROM `ideasenaccion`.`foro_comentario` WHERE `foro_id` IN (SELECT id FROM foro WHERE proyecto_id IS NOT NULL);
DELETE FROM `ideasenaccion`.`foro` WHERE proyecto_id IS NOT NULL;

