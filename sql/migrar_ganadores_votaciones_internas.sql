select * from 
(
select IF(@region = region_id, @ctr := @ctr + 1, @ctr := 1) as rn,
@region := region_id, region_id, proyecto_id, votos,
resumen,equipo_id,tipo,ruta,votomaximo
from (
select 
votacion_interna.region_id,
votacion_interna.proyecto_id,
 count(votacion_interna.id) / (select count(votacion_interna.id) as votomaximo from votacion_interna group by  proyecto_id order by votomaximo desc limit 1) *0.6 + proyecto.valor_porcentual_administrador / 40 * 0.4 as votos,
proyecto.titulo,proyecto.resumen,institucion.denominacion,equipo.id as equipo_id,
video.tipo,video.ruta,
(select count(votacion_interna.id) as votostotal from votacion_interna group by  proyecto_id order by votostotal desc limit 1) votomaximo

from votacion_interna
JOIN (SELECT @ctr := 0) as a
inner join proyecto on proyecto.id=votacion_interna.proyecto_id
inner join equipo on equipo.id=proyecto.equipo_id
inner join video on video.proyecto_id=proyecto.id and video.etapa=2
inner join usuario on usuario.id=proyecto.user_id
inner join estudiante on estudiante.id=usuario.estudiante_id
inner join institucion on institucion.id=estudiante.institucion_id
group by votacion_interna.region_id, votacion_interna.proyecto_id
order by votacion_interna.region_id,votos desc
) as tb
order by region_id, rn
) as tbn2
where rn <= 3;
