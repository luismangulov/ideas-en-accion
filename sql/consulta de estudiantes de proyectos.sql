SELECT a.id AS codigo_proyecto,c.descripcion_equipo AS nombre_equipo,a.titulo AS titulo_proyecto,b.ruta AS ruta_video,f.department AS region,
e.nombres,e.apellido_paterno AS apellidos, e.email,e.celular,
(CASE WHEN d.rol = 1 THEN 'Estudiante Coordinador'  
WHEN d.reportero=1 THEN 'Estudiante Reportero' 
WHEN e.grado=6 THEN 'Docente' 
ELSE 'Estudiante'
END) AS Tipo_usuario,
d.rol,d.reportero,e.grado,
(CASE WHEN c.etapa IS NULL THEN 'Equipo no finalizado'  WHEN c.etapa=0 THEN 'Equipo finalizado' WHEN c.etapa=1 THEN 'Equipo con proyecto finalizado' END) AS estado


FROM
equipo c


INNER JOIN proyecto a ON a.equipo_id=c.id
INNER JOIN video b ON a.id=b.proyecto_id
INNER JOIN integrante d ON c.id=d.equipo_id
INNER JOIN estudiante e ON  e.id=d.estudiante_id
INNER JOIN ubigeo f ON f.department_id=a.region_id
WHERE c.etapa=1

GROUP BY e.id

/*
having count(e.id) <3
select * from equipo a
inner join proyecto b on a.id=b.equipo_id

where a.etapa is null or a.etapa=0
*/
SELECT * FROM estudiante