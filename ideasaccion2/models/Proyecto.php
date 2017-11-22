<?php

namespace app\models;

use yii\db\Query;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "proyecto".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $resumen
 * @property string $justificacion
 * @property string $objetivo_general
 * @property string $beneficiario_directo_1
 * @property string $beneficiario_directo_2
 * @property string $beneficiario_directo_3
 * @property string $beneficiario_indirecto_1
 * @property string $beneficiario_indirecto_2
 * @property string $beneficiario_indirecto_3
 * @property integer $user_id
 *
 * @property ObjetivoEspecifico[] $objetivoEspecificos
 * @property Usuario $user
 */
class Proyecto extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public $archivo;
    public $archivo2;
    public $valorados;
    public $faltan_valorar;
    public $objetivo_especifico_1;
    public $objetivo_especifico_1_id;
    public $objetivo_especifico_2;
    public $objetivo_especifico_2_id;
    public $objetivo_especifico_3;
    public $objetivo_especifico_3_id;
    public $actividades_1;
    public $actividades_2;
    public $actividades_3;
    public $objetivo_especifico_id;
    public $actividad_id;
    public $actividades_ids_1;
    public $actividades_ids_2;
    public $actividades_ids_3;
    public $p1;
    public $p2;
    public $p3;
    public $p4;
    public $p5_1;
    public $p5_2;
    public $p5_3;
    public $p5_4;
    public $p5_5;
    public $p5_6;
    public $p5_7;
    public $p5_8;
    public $p6;
    public $p7_1;
    public $p7_2;
    public $p7_3;
    public $p7_4;
    public $p7_5;
    public $p7_6;
    public $p7_7;
    public $p7_8;
    public $p8;
    public $evaluacion;
    public $forum_url;
    public $tab_active_pro;
    /* plan presupuestal */
    public $planes_presupuestales_objetivos;
    public $planes_presupuestales_actividades;
    public $planes_presupuestales_recursos;
    public $planes_presupuestales_comos_conseguirlos;
    public $planes_presupuestales_precios_unitarios;
    public $planes_presupuestales_cantidades;
    public $planes_presupuestales_subtotales;
    public $planes_presupuestal_ids;
    public $planes_presupuestales_recursos_descripciones;
    public $planes_presupuestales_unidades;
    public $planes_presupuestales_dirigidos;
    public $descripcion_corta;

    /* cronograma */
    public $cronogramas_objetivos;
    public $cronogramas_actividades;
    public $cronogramas_tareas;
    public $cronogramas_responsables;
    public $cronogramas_fechas_inicios;
    public $cronogramas_fechas_fines;
    public $cronogramas_ids;

    /* Resultados */
    public $resultados_ids;
    public $resultados_esperados;

    /* dd */
    public $foro_id;
    public $ruta;
    public $denominacion;
    public $total_integrantes;
    public $foro_abierto;
    public $foro_asunto;
    public $proyecto_finalizado;
    public $video_check;
    public $reflexion_check;
    public $archivo_proyecto_check;
    public $seccion;
    public $total_monitor;
    public $total_estudiante;
    public $total_monitor_respuesta;
    public $voto;
    public $department_id;
    public $valor;
    public $department;
    public $codigo_modular;
    public $nombres;
    public $apellido_paterno;
    public $apellido_materno;
    public $email;
    public $celular;
    public $grado;
    public $descripcion_equipo;

    public static function tableName() {
        return 'proyecto';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cronogramas_objetivos', 'cronogramas_actividades', 'cronogramas_responsables', 'cronogramas_fechas_inicios',
            'cronogramas_fechas_fines', 'cronogramas_ids', 'resultados_ids', 'resultados_esperados',
            'planes_presupuestales_objetivos', 'planes_presupuestales_actividades', 'planes_presupuestales_recursos',
            'planes_presupuestales_comos_conseguirlos', 'planes_presupuestales_precios_unitarios',
            'planes_presupuestales_cantidades', 'planes_presupuestales_subtotales', 'planes_presupuestal_ids',
            'planes_presupuestales_dirigidos', 'planes_presupuestales_unidades', 'planes_presupuestales_recursos_descripciones'], 'safe'],
            [['id', 'actividades_1', 'actividades_2', 'actividades_3', 'actividades_ids_1', 'actividades_ids_2', 'actividades_ids_3', 'cronogramas_tareas'], 'safe'],
            [['seccion', 'user_id', 'asunto_id', 'objetivo_especifico_1_id', 'objetivo_especifico_2_id', 'objetivo_especifico_3_id', 'equipo_id', 'region_id', 'p4', 'p5_1', 'p5_2', 'p5_3', 'p5_4', 'p5_5', 'p5_6', 'p5_7', 'p5_8', 'p6', 'p7_1', 'p7_2', 'p7_3', 'p7_4', 'p7_5', 'p7_6', 'p7_7', 'p7_8', 'p8', 'total_monitor', 'total_estudiante', 'total_monitor_respuesta'], 'integer'],
            [['titulo', 'proyecto_archivo', 'proyecto_archivo2'], 'string', 'max' => 200],
            [['ruta', 'tab_active_pro', 'department_id'], 'string', 'max' => 250],
            [['resumen', 'beneficiario', 'evaluacion'], 'string', 'max' => 500],
            [['p1', 'p2', 'p3'], 'string', 'max' => 5000],
            [['forum_url', 'objetivo_general', 'objetivo_especifico_1', 'objetivo_especifico_2', 'objetivo_especifico_3'], 'string', 'max' => 300],
            [['archivo', 'archivo2'], 'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'resumen' => 'Resumen',
            'justificacion' => 'Justificacion',
            'objetivo_general' => 'Objetivo General',
            'user_id' => 'User ID',
            'total_monitor' => '# comentarios monitor',
            'total_estudiante' => '# comentarios de estudiantes',
            'total_monitor_respuesta' => '# de respuestas al monitor'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjetivoEspecificos() {
        return $this->hasMany(ObjetivoEspecifico::className(), ['proyecto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(Usuario::className(), ['id' => 'user_id']);
    }

    public function getEquipo() {
        return $this->hasOne(Equipo::className(), ['id' => 'equipo_id']);
    }

    public function beforeSave($insert) {
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $integrante = Integrante::find()
                        ->select('integrante.equipo_id,ubigeo.department_id')
                        ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                        ->innerJoin('institucion', 'institucion.id=estudiante.institucion_id')
                        ->innerJoin('ubigeo', 'ubigeo.district_id=institucion.ubigeo_id')
                        ->where('integrante.estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
        $equipo = Equipo::findOne($integrante->equipo_id);
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->region_id = $integrante->department_id;
                $this->asunto_id = $equipo->asunto_id;
                $this->user_id = \Yii::$app->user->id;
                $this->equipo_id = $integrante->equipo_id;
                $this->formato_proyecto = 0;
                $this->formato_proyecto2 = 0;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getProyectos($sort, $region) {

        //total_equipos province   total_alumnos  district  total_equipos_nofinalizado latitude  total_alumnos_nofinalizado longitud
        $query = new Query;
        if ($region) {
            $query
                    ->select(['
                        p.id,
                        p.asunto_id,
                        ins.denominacion,
                        p.titulo, 
                        COUNT( i.estudiante_id ) AS total_integrantes,
                        IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.id=2 and estudiante.grado!=6 and p.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_abierto,
                        IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.asunto_id=p.asunto_id and estudiante.grado!=6 and p.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_asunto,
                        IF((SELECT COUNT(video.proyecto_id) FROM video WHERE video.proyecto_id = p.id AND TRIM( video.ruta ) IS NOT NULL and TRIM( video.ruta )!="") >=1, 1, 0 ) AS video_check,
                        IF( ( SELECT COUNT( reflexion.proyecto_id ) FROM reflexion WHERE reflexion.proyecto_id = p.id AND TRIM( reflexion.p1 ) IS NOT NULL and TRIM( reflexion.p1 )!="" AND TRIM( reflexion.p2 ) IS NOT NULL and TRIM( reflexion.p2 )!="" AND TRIM( reflexion.p3 ) IS NOT NULL and TRIM( reflexion.p3 )!="") =1, 1, 0 ) AS reflexion_check,
                        IF(trim(p.proyecto_archivo)!="",1,0) as archivo_proyecto_check,
                        IF(e.etapa=1 || e.etapa=2,1,0) as proyecto_finalizado
                      '])
                    ->from('proyecto p')
                    ->innerJoin('equipo e', 'e.id = p.equipo_id')
                    ->innerJoin('integrante i', 'i.equipo_id = e.id')
                    ->innerJoin('estudiante es', 'es.id=i.estudiante_id')
                    ->innerJoin('institucion ins', 'ins.id=es.institucion_id')
                    ->innerJoin('ubigeo u', 'u.district_id=ins.ubigeo_id')
                    ->where('u.department_id=:department_id', [':department_id' => $region])
                    ->groupBy('p.id,p.titulo')
                    ->orderBy($sort);
        } else {
            $query
                    ->select(['
                        p.id,
                        p.asunto_id,
                        ins.denominacion,
                        p.titulo, 
                        COUNT( i.estudiante_id ) AS total_integrantes,
                        IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.id=2 and estudiante.grado!=6 and p.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_abierto,
                        IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.asunto_id=p.asunto_id and estudiante.grado!=6 and p.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_asunto,
                        IF((SELECT COUNT(video.proyecto_id) FROM video WHERE video.proyecto_id = p.id AND TRIM( video.ruta ) IS NOT NULL and TRIM( video.ruta )!="") =1, 1, 0 ) AS video_check,
                        IF( ( SELECT COUNT( reflexion.proyecto_id ) FROM reflexion WHERE reflexion.proyecto_id = p.id AND TRIM( reflexion.p1 ) IS NOT NULL and TRIM( reflexion.p1 )!="" AND TRIM( reflexion.p2 ) IS NOT NULL and TRIM( reflexion.p2 )!="" AND TRIM( reflexion.p3 ) IS NOT NULL and TRIM( reflexion.p3 )!="") =1, 1, 0 ) AS reflexion_check,
                        IF(trim(p.proyecto_archivo)!="",1,0) as archivo_proyecto_check,
                        IF(e.etapa=1 || e.etapa=2,1,0) as proyecto_finalizado
                      '])
                    ->from('proyecto p')
                    ->innerJoin('equipo e', 'e.id = p.equipo_id')
                    ->innerJoin('integrante i', 'i.equipo_id = e.id')
                    ->innerJoin('estudiante es', 'es.id=i.estudiante_id')
                    ->innerJoin('institucion ins', 'ins.id=es.institucion_id')
                    ->innerJoin('ubigeo u', 'u.district_id=ins.ubigeo_id')
                    ->groupBy('p.id,p.titulo')
                    ->orderBy($sort);
        }


        $result = Yii::$app->tools->Pagination($query, 10);

        return ['proyectos' => $result['result'], 'pages' => $result['pages']];
    }

    public function getProyectos2($sort, $region) {

        //total_equipos province   total_alumnos  district  total_equipos_nofinalizado latitude  total_alumnos_nofinalizado longitud
        $query = new Query;
        if ($region) {
            $query
                    ->select(['
                        p.id,
                        p.asunto_id,
                        ins.denominacion,
                        p.titulo, 
                        COUNT( i.estudiante_id ) AS total_integrantes,
                        IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.id=2 and estudiante.grado!=6 and p.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_abierto,
                        IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.asunto_id=p.asunto_id and estudiante.grado!=6 and p.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_asunto,
                        IF((SELECT COUNT(video.proyecto_id) FROM video WHERE video.etapa=2 and video.proyecto_id = p.id AND TRIM( video.ruta ) IS NOT NULL and TRIM( video.ruta )!="") >=1, 1, 0 ) AS video_check,
                        IF( ( SELECT COUNT( reflexion.proyecto_id ) FROM reflexion WHERE reflexion.proyecto_id = p.id AND TRIM( reflexion.p4 ) IS NOT NULL and TRIM( reflexion.p4 )!="" AND TRIM( reflexion.p6 ) IS NOT NULL and TRIM( reflexion.p6 )!="" AND TRIM( reflexion.p8 ) IS NOT NULL and TRIM( reflexion.p8 )!="") =1, 1, 0 ) AS reflexion_check,
                        IF(trim(p.proyecto_archivo2)!="",1,0) as archivo_proyecto_check,
                        IF(e.etapa=2,1,0) as proyecto_finalizado
                      '])
                    ->from('proyecto p')
                    ->innerJoin('equipo e', 'e.id = p.equipo_id')
                    ->innerJoin('integrante i', 'i.equipo_id = e.id')
                    ->innerJoin('estudiante es', 'es.id=i.estudiante_id')
                    ->innerJoin('institucion ins', 'ins.id=es.institucion_id')
                    ->innerJoin('ubigeo u', 'u.district_id=ins.ubigeo_id')
                    ->where('u.department_id=:department_id and e.etapa=2', [':department_id' => $region])
                    ->groupBy('p.id,p.titulo')
                    ->orderBy($sort);
        } else {
            $query
                    ->select(['
                        p.id,
                        p.asunto_id,
                        ins.denominacion,
                        p.titulo, 
                        COUNT( i.estudiante_id ) AS total_integrantes,
                        IF((SELECT COUNT(video.proyecto_id) FROM video WHERE video.etapa=2 and video.proyecto_id = p.id AND TRIM( video.ruta ) IS NOT NULL and TRIM( video.ruta )!="") =1, 1, 0 ) AS video_check,
                        IF( ( SELECT COUNT( reflexion.proyecto_id ) FROM reflexion WHERE reflexion.proyecto_id = p.id AND TRIM( reflexion.p4 ) IS NOT NULL and TRIM( reflexion.p4 )!="" AND TRIM( reflexion.p6 ) IS NOT NULL and TRIM( reflexion.p6 )!="" AND TRIM( reflexion.p8 ) IS NOT NULL and TRIM( reflexion.p8 )!="") =1, 1, 0 ) AS reflexion_check,
                        IF(trim(p.proyecto_archivo2)!="",1,0) as archivo_proyecto_check,
                        IF(e.etapa=2,1,0) as proyecto_finalizado
                      '])
                    ->from('proyecto p')
                    ->innerJoin('equipo e', 'e.id = p.equipo_id')
                    ->innerJoin('integrante i', 'i.equipo_id = e.id')
                    ->innerJoin('estudiante es', 'es.id=i.estudiante_id')
                    ->innerJoin('institucion ins', 'ins.id=es.institucion_id')
                    ->innerJoin('ubigeo u', 'u.district_id=ins.ubigeo_id')
                    ->where('e.etapa=2')
                    ->groupBy('p.id,p.titulo')
                    ->orderBy($sort);
        }


        $result = Yii::$app->tools->Pagination($query, 10);

        return ['proyectos' => $result['result'], 'pages' => $result['pages']];
    }

    public function getProyectoRegional($sort) {
        $query = new Query;
        if (count($sort) > 0) {

            $query->select(['DISTINCT
                            department,
                            ifnull((
                                SELECT count(u.department_id) FROM equipo e 
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                WHERE e.estado=1 AND i.rol=1 AND  i.estado=2 AND u.department_id=ubigeo.department_id 
                                GROUP BY u.department_id
                            ),0) AS province,
                            ifnull((
                                SELECT count(e.id) FROM proyecto p
                                    right JOIN equipo e ON e.id=p.equipo_id
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                WHERE e.estado=1 AND i.rol=1 AND  i.estado=2 AND p.id IS NULL AND u.department_id=ubigeo.department_id
                                GROUP BY u.department_id
                            ),0) AS district,
                            ifnull((
                                SELECT count(p.id) FROM proyecto p
                                    INNER JOIN equipo e ON e.id=p.equipo_id
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                    WHERE e.estado=1 AND i.rol=1 AND  i.estado=2  AND u.department_id=ubigeo.department_id AND (e.etapa IS NULL OR e.etapa="")
                                GROUP BY u.department_id
                            ),0) AS province_id,
                            ifnull((
                                SELECT count(p.id) FROM proyecto p
                                    INNER JOIN equipo e ON e.id=p.equipo_id
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                WHERE e.estado=1 AND i.rol=1 AND  i.estado=2  AND u.department_id=ubigeo.department_id AND e.etapa in (1,2) 
                                GROUP BY u.department_id
                            ),0) AS district_id
                            '])
                    ->from('{{%ubigeo}}')
                    ->orderBy($sort);
        } else {
            $query->select(['DISTINCT
                            department,
                             ifnull((
                                SELECT count(u.department_id) FROM equipo e 
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                WHERE e.estado=1 AND i.rol=1 AND  i.estado=2 AND u.department_id=ubigeo.department_id 
                                GROUP BY u.department_id
                            ),0) AS province,
                             ifnull((
                                SELECT count(e.id) FROM proyecto p
                                    right JOIN equipo e ON e.id=p.equipo_id
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                WHERE e.estado=1 AND i.rol=1 AND  i.estado=2 AND p.id IS NULL AND u.department_id=ubigeo.department_id
                                GROUP BY u.department_id
                            ),0) AS district,
                             ifnull((
                                SELECT count(p.id) FROM proyecto p
                                    INNER JOIN equipo e ON e.id=p.equipo_id
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                    WHERE e.estado=1 AND i.rol=1 AND  i.estado=2  AND u.department_id=ubigeo.department_id AND (e.etapa IS NULL OR e.etapa="")
                                GROUP BY u.department_id
                            ),0) AS province_id,
                             ifnull((
                                SELECT count(p.id) FROM proyecto p
                                    INNER JOIN equipo e ON e.id=p.equipo_id
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                WHERE e.estado=1 AND i.rol=1 AND  i.estado=2  AND u.department_id=ubigeo.department_id AND e.etapa in (1,2)
                                GROUP BY u.department_id
                            ),0) AS district_id
                            '])
                    ->from('{{%ubigeo}}')
                    ->orderBy('department asc');
        }
        $result = Yii::$app->tools->Pagination($query, 27);

        return ['proyectos' => $result['result'], 'pages' => $result['pages']];
    }

    public function Asuntos($asunto_id, $region) {

        $data = "";
        if ($region) {
            /* $countAsuntos = Resultados::find()
              ->select('a.id,a.descripcion_cabecera')
              ->innerJoin('asunto a', 'a.id=resultados.asunto_id')
              ->where('resultados.region_id=:region_id', [':region_id' => $region])->groupBy('a.id,a.descripcion_cabecera')->count();
              $asuntos = Resultados::find()->select('a.id,a.descripcion_cabecera')
              ->innerJoin('asunto a', 'a.id=resultados.asunto_id')
              ->where('resultados.region_id=:region_id', [':region_id' => $region])->groupBy('a.id,a.descripcion_cabecera')->orderBy('descripcion_cabecera')->all();
             */
            $countAsuntos = Proyecto::find()
                            ->select('b.id,b.descripcion_corta')
                            ->innerJoin('proyecto_copia a', 'a.id=proyecto.id')
                            ->innerJoin('asunto b', 'a.asunto_id=b.id')
                            ->where('a.etapa=1 and proyecto.region_id=:region_idx', [':region_idx' => $region])->groupBy('b.id,b.descripcion_corta')->all();

            $asuntos = Proyecto::find()
                            ->select('b.id,b.descripcion_corta')
                            ->innerJoin('proyecto_copia a', 'a.id=proyecto.id')
                            ->innerJoin('asunto b', 'a.asunto_id=b.id')
                            ->where('a.etapa=1 and proyecto.region_id=:region_idx', [':region_idx' => $region])->groupBy('b.id,b.descripcion_corta')->all();


            if ($countAsuntos > 0) {
                foreach ($asuntos as $asunto) {
                    if ($asunto->id == $asunto_id) {
                        $data = $data . "<option value='" . $asunto->id . "'  selected>" . htmlentities($asunto->descripcion_corta,ENT_QUOTES) . "</option>";
                    } else {
                        $data = $data . "<option value='" . $asunto->id . "'  >" . htmlentities($asunto->descripcion_corta,ENT_QUOTES) . "</option>";
                    }
                }
            }
        }

        return $data;
    }

    public function getProyectoRegional3($sort) {
        $query = new Query;
        if (count($sort) > 0) {

            $query->select(['DISTINCT
                            department,
                            ifnull((
                                SELECT count(e.id) FROM estudiante e
                                INNER JOIN institucion i ON i.id = e.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = i.ubigeo_id
                                WHERE u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ),0) AS province,
                            ifnull((
                                SELECT count(eq.id) FROM equipo eq
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE i.rol=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ),0) AS district,
                            ifnull((
                                SELECT count(eq.id) FROM equipo eq
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE eq.estado=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ),0) AS department_id,
                            ifnull((
                                SELECT count(p.id) FROM proyecto p
                                INNER JOIN equipo eq ON eq.id=p.equipo_id
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE eq.estado=1 AND i.rol=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ),0) AS province_id,
                            ifnull((
                                SELECT count(p.id) FROM proyecto p
                                INNER JOIN equipo eq ON eq.id=p.equipo_id
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE eq.estado=1 AND i.rol=1 AND eq.etapa=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ),0) AS district_id
                            
                            '])
                    ->from('ubigeo')
                    ->orderBy($sort);
        } else {
            $query->select(['DISTINCT
                            department,
                           ifnull( (
                                SELECT count(e.id) FROM estudiante e
                                INNER JOIN institucion i ON i.id = e.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = i.ubigeo_id
                                WHERE u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ),0) AS province,
                            ifnull((
                                SELECT count(eq.id) FROM equipo eq
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE i.rol=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ),0) AS district,
                            ifnull((
                                SELECT count(eq.id) FROM equipo eq
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE eq.estado=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ),0) AS department_id,
                            ifnull((
                                SELECT count(p.id) FROM proyecto p
                                INNER JOIN equipo eq ON eq.id=p.equipo_id
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE eq.estado=1 AND i.rol=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ),0) AS province_id,
                            ifnull((
                                SELECT count(p.id) FROM proyecto p
                                INNER JOIN equipo eq ON eq.id=p.equipo_id
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE eq.estado=1 AND i.rol=1 AND eq.etapa=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ),0) AS district_id
                            
                            '])
                    ->from('ubigeo')
                    ->orderBy('department asc');
        }
        $result = Yii::$app->tools->Pagination($query, 27);

        return ['proyectos' => $result['result'], 'pages' => $result['pages']];
    }

    public function getProyectoVotacion($titulo) {
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $estudiante = Estudiante::findOne($usuario->estudiante_id);
        $institucion = Institucion::findOne($estudiante->institucion_id);
        $ubigeo = Ubigeo::find()->where('district_id=:district_id', [':district_id' => $institucion->ubigeo_id])->one();

        $query = new Query;
        if ($titulo != "") {

            $query->select('
                            proyecto.id,
                            proyecto.titulo,
                            proyecto.resumen,
                            equipo.descripcion_equipo,
                            ubigeo.department,
                            proyecto.beneficiario,
                            proyecto.proyecto_archivo,
                            proyecto.proyecto_archivo2
                            ')
                    ->from('proyecto')
                    ->innerJoin('equipo', 'equipo.id=proyecto.equipo_id')
                    ->innerJoin('integrante', 'integrante.equipo_id=equipo.id')
                    ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                    ->innerJoin('institucion', 'institucion.id=estudiante.institucion_id')
                    ->innerJoin('ubigeo', 'ubigeo.district_id=institucion.ubigeo_id')
                    ->where('integrante.rol=1 and equipo.etapa=2  and ubigeo.department_id="' . $ubigeo->department_id . '"');
            $query->andFilterWhere(['like', 'proyecto.titulo', $titulo]);
        } else {
            $query->select('
                            proyecto.id,
                            proyecto.titulo,
                            proyecto.resumen,
                            equipo.descripcion_equipo,
                            ubigeo.department,
                            proyecto.beneficiario,
                            proyecto.proyecto_archivo,
                            proyecto.proyecto_archivo2
                            ')
                    ->from('proyecto')
                    ->innerJoin('equipo', 'equipo.id=proyecto.equipo_id')
                    ->innerJoin('integrante', 'integrante.equipo_id=equipo.id')
                    ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                    ->innerJoin('institucion', 'institucion.id=estudiante.institucion_id')
                    ->innerJoin('ubigeo', 'ubigeo.district_id=institucion.ubigeo_id')
                    ->where('integrante.rol=1 and equipo.etapa=2 and ubigeo.department_id="' . $ubigeo->department_id . '"');
        }
        $result = Yii::$app->tools->Pagination($query, 150);

        return ['votaciones' => $result['result'], 'pages' => $result['pages']];
    }

}
