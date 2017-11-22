<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use app\models\Voto;
use app\models\Estudiante;
use app\models\Foro;
use app\models\Equipo;
use app\models\Usuario;
use app\models\Proyecto;
use app\models\Ubigeo;
use yii\data\Sort;

/**
 * ProyectoController implements the CRUD actions for Proyecto model.
 */
class ReporteController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Proyecto models.
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = 'administrador';

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        /* $sort = new Sort([
          'attributes' => [
          'voto_emitido' => [
          'label' => 'Votos emitidos',
          ],
          'descripcion_cabecera' => [
          'label' => 'Asunto público',
          ],

          ],
          ]);

          $model = new Voto();
          $model->load(Yii::$app->request->queryParams);
          return $this->render('index', [
          'model' => $model,
          'sort' => $sort,
          ]); */
        return $this->redirect(['panel/foros']);
    }

    public function actionRegion() {
        $this->layout = 'administrador';

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        $sort = new Sort([
            'attributes' => [
                'voto_emitido' => [
                    'label' => 'Votos emitidos',
                ],
                'region_id' => [
                    'label' => 'Región',
                ],
            ],
        ]);

        $model = new Voto();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('region', [
                    'model' => $model,
                    'sort' => $sort,
        ]);
    }

    public function actionIndex_descargar($region = null) {
        
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        return $this->render('index_descargar', [
                    'region' => $region,
        ]);
    }

    public function actionRegion_descargar($region = null) {
        
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        
        return $this->render('region_descargar', [
                    'region' => $region,
        ]);
    }

    public function actionRegistrados() {
        $this->layout = 'administrador';
        
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }

        $sort = new Sort([
            'attributes' => [
                'department' => [
                    'label' => 'Región',
                ],
                'total_estudiantes' => [
                    'label' => 'Total',
                ],
                'estudiantes_finalizaron_equipo' => [
                    'label' => 'Finalizaron equipos',
                ],
                'estudiantes_aceptaron_invitacion' => [
                    'label' => 'Falta finalizar equipo',
                ],
                'estudiantes_invitaciones_pendientes' => [
                    'label' => 'Invitaciones pendientes',
                ],
                'estudiantes_huerfanos' => [
                    'label' => 'Sin equipo',
                ],
            ],
        ]);

        $model = new Estudiante();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('registrados', [
                    'model' => $model,
                    'sort' => $sort,
        ]);
    }

    public function actionRegistrados_descargar() {
        
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        return $this->render('registrados_descargar');
    }

    public function actionRegistradosDetalles() {
        $this->layout = 'administrador';

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }

        $sort = new Sort([
            'attributes' => [
            /* 'department' => [
              'label' => 'Región',
              ],
              'total_estudiantes' => [
              'label' => 'Total',
              ],
              'estudiantes_finalizaron_equipo' => [
              'label' => 'Finalizaron equipos',
              ],
              'estudiantes_aceptaron_invitacion' => [
              'label' => 'Falta finalizar equipo',
              ],
              'estudiantes_invitaciones_pendientes' => [
              'label' => 'Invitaciones pendientes',
              ],
              'estudiantes_huerfanos' => [
              'label' => 'Sin equipo',
              ], */
            ],
        ]);

        $model = new Estudiante();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('registrados-detalles', [
                    'model' => $model,
                    'sort' => $sort,
        ]);
    }

    public function actionRegistradosDetalles_descargar($region = null, $estado = null) {
        
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        return $this->render('registrados-detalles_descargar', ['region' => $region, 'estado' => $estado]);
    }

    public function actionEquipo() {
        $this->layout = 'administrador';

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }

        $sort = new Sort([
            'attributes' => [
                'department' => [
                    'label' => 'Región',
                ],
                'province' => [
                    'label' => 'Total de equipos finalizados',
                ],
                'district' => [
                    'label' => 'Total integrantes de equipos finalizados',
                ],
                'latitude' => [
                    'label' => 'Total de equipos no finalizados',
                ],
                'longitud' => [
                    'label' => 'Total integrantes de equipos no finalizados',
                ],
            ],
        ]);

        $model = new Equipo();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('equipo', [
                    'model' => $model,
                    'sort' => $sort,
        ]);
    }

    public function actionEquipoDescargar() {
        $this->layout = 'administrador';

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        $sort = new Sort([
            'attributes' => [
                'department' => [
                    'label' => 'Región',
                ],
                'province' => [
                    'label' => 'Total de equipos finalizados',
                ],
                'district' => [
                    'label' => 'Total integrantes de equipos finalizados',
                ],
                'latitude' => [
                    'label' => 'Total de equipos no finalizados',
                ],
                'longitud' => [
                    'label' => 'Total integrantes de equipos no finalizados',
                ],
            ],
        ]);

        $model = new Equipo();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('equipo-descargar', [
                    'model' => $model,
                    'sort' => $sort,
        ]);
    }

    public function actionForo_descargar($region = null) {
        
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        
        $forospublicos = Foro::find()
                ->select([
                    'foro.id',
                    'foro.titulo',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id) total',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion!=0) valorado',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and not foro_comentario.user_id between 2 and 8) pendiente',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and foro_comentario.user_id between 2 and 8) emitido'
                ])
                ->innerJoin('asunto', 'foro.asunto_id=asunto.id')
                ->innerJoin('resultados', 'resultados.asunto_id=foro.asunto_id')
                ->groupBy('foro.titulo,total')
                ->orderBy('total DESC,pendiente DESC,valorado DESC')
                ->all();

        $foroparticipacion = Foro::find()
                ->select([
                    'foro.id',
                    'foro.titulo',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id) total',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion!=0) valorado',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and not foro_comentario.user_id between 2 and 8) pendiente',
                    '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.valoracion=0 and foro_comentario.user_id between 2 and 8) emitido'
                ])
                ->where('foro.id=2')
                ->groupBy('foro.titulo,total')
                ->orderBy('total DESC,pendiente DESC,valorado DESC')
                ->one();

        return $this->render('foro_descargar', [
                    'forospublicos' => $forospublicos,
                    'foroparticipacion' => $foroparticipacion
        ]);
    }

    public function actionProyecto() {
        $this->layout = 'administrador';
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        $sort = new Sort([
            'attributes' => [
            /* 'department' => [
              'label' => 'Región',
              ], */
            ],
        ]);

        $model = new Proyecto();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('proyecto', [
                    'model' => $model,
                    'sort' => $sort,
        ]);
    }

    public function actionProyecto2entrega() {
        $this->layout = 'administrador';

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        $sort = new Sort([
            'attributes' => [
            /* 'department' => [
              'label' => 'Región',
              ], */
            ],
        ]);

        $model = new Proyecto();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('proyecto2entrega', [
                    'model' => $model,
                    'sort' => $sort,
        ]);
    }

    public function actionProyecto2entregaDescargar($region = null) {
        $this->layout = 'administrador';

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        if ($region) {
            $proyectos = Proyecto::find()->select('
                    u.department,
                    ins.codigo_modular,
                    ins.denominacion,
                    es.nombres,
                    es.apellido_paterno,
                    es.apellido_materno,
                    es.email,
                    es.celular,
                    es.grado,
                    proyecto.titulo,
                    e.descripcion_equipo
                  ')
                    ->innerJoin('equipo e', 'e.id = proyecto.equipo_id')
                    ->innerJoin('integrante i', 'i.equipo_id = e.id')
                    ->innerJoin('estudiante es', 'es.id=i.estudiante_id')
                    ->innerJoin('institucion ins', 'ins.id=es.institucion_id')
                    ->innerJoin('ubigeo u', 'u.district_id=ins.ubigeo_id')
                    ->where('u.department_id=:department_id and e.etapa=2', [':department_id' => $region])
                    ->all();
        } else {
            $proyectos = Proyecto::find()->select('
                    u.department,
                    ins.codigo_modular,
                    ins.denominacion,
                    es.nombres,
                    es.apellido_paterno,
                    es.apellido_materno,
                    es.email,
                    es.celular,
                    es.grado,
                    proyecto.titulo,
                    e.descripcion_equipo
                  ')
                    ->innerJoin('equipo e', 'e.id = proyecto.equipo_id')
                    ->innerJoin('integrante i', 'i.equipo_id = e.id')
                    ->innerJoin('estudiante es', 'es.id=i.estudiante_id')
                    ->innerJoin('institucion ins', 'ins.id=es.institucion_id')
                    ->innerJoin('ubigeo u', 'u.district_id=ins.ubigeo_id')
                    ->where('e.etapa=2')
                    ->all();
        }

        return $this->render('proyecto2entrega-descargar', [
                    'proyectos' => $proyectos,
        ]);
    }

    public function actionProyectoDescargar($region = null) {
        
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        
        if ($region) {
            $proyectos = Proyecto::find()->select(['
                    proyecto.id,
                    proyecto.asunto_id,
                    proyecto.titulo, 
                    COUNT( i.estudiante_id ) AS total_integrantes,
                    IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.id=2 and estudiante.grado!=6 and proyecto.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_abierto,
                    IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.asunto_id=proyecto.asunto_id and estudiante.grado!=6 and proyecto.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_asunto,
                    IF((SELECT COUNT(video.proyecto_id) FROM video WHERE video.proyecto_id = proyecto.id AND TRIM( video.ruta ) IS NOT NULL and TRIM( video.ruta )!="") =1, 1, 0 ) AS video_check,
                    IF( ( SELECT COUNT( reflexion.proyecto_id ) FROM reflexion WHERE reflexion.proyecto_id = proyecto.id AND TRIM( reflexion.p1 ) IS NOT NULL and TRIM( reflexion.p1 )!="" AND TRIM( reflexion.p2 ) IS NOT NULL and TRIM( reflexion.p2 )!="" AND TRIM( reflexion.p3 ) IS NOT NULL and TRIM( reflexion.p3 )!="") =1, 1, 0 ) AS reflexion_check,
                    IF(trim(proyecto.proyecto_archivo)!="",1,0) as archivo_proyecto_check,
                    IF(e.etapa=1,1,0) as proyecto_finalizado
                  '])
                    ->innerJoin('equipo e', 'e.id = proyecto.equipo_id')
                    ->innerJoin('integrante i', 'i.equipo_id = e.id')
                    ->innerJoin('estudiante es', 'es.id=i.estudiante_id')
                    ->innerJoin('institucion ins', 'ins.id=es.institucion_id')
                    ->innerJoin('ubigeo u', 'u.district_id=ins.ubigeo_id')
                    ->where('u.department_id=:department_id', [':department_id' => $region])
                    ->groupBy('proyecto.id,proyecto.titulo')
                    ->all();
        } else {
            $proyectos = Proyecto::find()->select(['
                    proyecto.id,
                    proyecto.asunto_id,
                    proyecto.titulo, 
                    COUNT( i.estudiante_id ) AS total_integrantes,
                    IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.id=2 and estudiante.grado!=6 and proyecto.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_abierto,
                    IF((select count(DISTINCT integrante.estudiante_id) from foro inner join foro_comentario on foro_comentario.foro_id=foro.id  inner join usuario on usuario.id=foro_comentario.user_id inner join estudiante on estudiante.id=usuario.estudiante_id inner join integrante on integrante.estudiante_id=estudiante.id inner join equipo on equipo.id=integrante.equipo_id where foro.asunto_id=proyecto.asunto_id and estudiante.grado!=6 and proyecto.equipo_id=equipo.id )=(COUNT( i.estudiante_id )-1),1,0) as foro_asunto,
                    IF((SELECT COUNT(video.proyecto_id) FROM video WHERE video.proyecto_id = proyecto.id AND TRIM( video.ruta ) IS NOT NULL and TRIM( video.ruta )!="") =1, 1, 0 ) AS video_check,
                    IF( ( SELECT COUNT( reflexion.proyecto_id ) FROM reflexion WHERE reflexion.proyecto_id = proyecto.id AND TRIM( reflexion.p1 ) IS NOT NULL and TRIM( reflexion.p1 )!="" AND TRIM( reflexion.p2 ) IS NOT NULL and TRIM( reflexion.p2 )!="" AND TRIM( reflexion.p3 ) IS NOT NULL and TRIM( reflexion.p3 )!="") =1, 1, 0 ) AS reflexion_check,
                    IF(trim(proyecto.proyecto_archivo)!="",1,0) as archivo_proyecto_check,
                    IF(e.etapa=1,1,0) as proyecto_finalizado
                  '])
                    ->innerJoin('equipo e', 'e.id = proyecto.equipo_id')
                    ->innerJoin('integrante i', 'i.equipo_id = e.id')
                    ->innerJoin('estudiante es', 'es.id=i.estudiante_id')
                    ->innerJoin('institucion ins', 'ins.id=es.institucion_id')
                    ->innerJoin('ubigeo u', 'u.district_id=ins.ubigeo_id')
                    ->groupBy('proyecto.id,proyecto.titulo')
                    ->all();
        }
        return $this->render('proyecto-descargar', [
                    'proyectos' => $proyectos
        ]);
    }

    public function actionProyecto2() {
        $this->layout = 'administrador';

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }

        $sort = new Sort([
            'attributes' => [
                'department' => [
                    'label' => 'Región',
                ],
                'province' => [
                    'label' => 'Equipos finalizados',
                ],
                'district' => [
                    'label' => 'Equipos sin proyectos',
                ],
                'province_id' => [
                    'label' => 'Proyectos no finalizados',
                ],
                'district_id' => [
                    'label' => 'Proyectos finalizados',
                ],
            ],
        ]);
        $model = new Proyecto();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('proyecto2', [
                    'model' => $model,
                    'sort' => $sort,
        ]);
    }

    public function actionProyecto2Descargar($region = null) {
        
        
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        $proyectos = Ubigeo::find()->select(['
                            DISTINCT
                            department,
                            (
                                SELECT count(u.department_id) FROM equipo e 
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                WHERE e.estado=1 AND i.rol=1 AND  i.estado=2 AND u.department_id=ubigeo.department_id 
                                GROUP BY u.department_id
                            ) AS province,
                            (
                                SELECT count(e.id) FROM proyecto p
                                    right JOIN equipo e ON e.id=p.equipo_id
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                WHERE e.estado=1 AND i.rol=1 AND  i.estado=2 AND p.id IS NULL AND u.department_id=ubigeo.department_id
                                GROUP BY u.department_id
                            ) AS district,
                            (
                                SELECT count(p.id) FROM proyecto p
                                    INNER JOIN equipo e ON e.id=p.equipo_id
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                    WHERE e.estado=1 AND i.rol=1 AND  i.estado=2  AND u.department_id=ubigeo.department_id AND (e.etapa IS NULL OR e.etapa="")
                                GROUP BY u.department_id
                            ) AS province_id,
                            (
                                SELECT count(p.id) FROM proyecto p
                                    INNER JOIN equipo e ON e.id=p.equipo_id
                                    INNER JOIN integrante i ON i.equipo_id=e.id 
                                    INNER JOIN estudiante es ON es.id=i.estudiante_id
                                    INNER JOIN institucion a ON a.id=es.institucion_id
                                    INNER JOIN ubigeo u ON u.district_id=a.ubigeo_id
                                WHERE e.estado=1 AND i.rol=1 AND  i.estado=2  AND u.department_id=ubigeo.department_id AND e.etapa=1 
                                GROUP BY u.department_id
                            ) AS district_id
                    '])
                ->all();

        return $this->render('proyecto2-descargar', [
                    'proyectos' => $proyectos
        ]);
    }

    public function actionProyecto3() {
        $this->layout = 'administrador';

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        
        $sort = new Sort([
            'attributes' => [
                'department' => [
                    'label' => 'Región',
                ],
                'province' => [
                    'label' => '# de estudiantes registrados',
                ],
                'district' => [
                    'label' => '# de equipos',
                ],
                'department_id' => [
                    'label' => '# de estudiantes en equipos finalizados',
                ],
                'province_id' => [
                    'label' => '# de proyectos creados',
                ],
                'district_id' => [
                    'label' => '# de proyecto finalizados',
                ],
            ],
        ]);
        $model = new Proyecto();
        $model->load(Yii::$app->request->queryParams);
        return $this->render('proyecto3', [
                    'model' => $model,
                    'sort' => $sort,
        ]);
    }

    public function actionProyecto3Descargar($region = null) {
        
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        if (!$usuario->name_temporal == "Monitor" && !$usuario->name_temporal == "Adminitrador") {
            return $this->goHome();
        }
        
        $proyectos = Ubigeo::find()->select(['DISTINCT
                            department,
                            (
                                SELECT count(e.id) FROM estudiante e
                                INNER JOIN institucion i ON i.id = e.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = i.ubigeo_id
                                WHERE u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ) AS province,
                            (
                                SELECT count(eq.id) FROM equipo eq
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE i.rol=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ) AS district,
                            (
                                SELECT count(eq.id) FROM equipo eq
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE eq.estado=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ) AS department_id,
                            (
                                SELECT count(p.id) FROM proyecto p
                                INNER JOIN equipo eq ON eq.id=p.equipo_id
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE eq.estado=1 AND i.rol=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ) AS province_id,
                            (
                                SELECT count(p.id) FROM proyecto p
                                INNER JOIN equipo eq ON eq.id=p.equipo_id
                                INNER JOIN integrante i ON i.equipo_id=eq.id
                                INNER JOIN estudiante es ON es.id = i.estudiante_id
                                INNER JOIN institucion it ON it.id = es.institucion_id
                                INNER JOIN ubigeo u ON u.district_id = it.ubigeo_id
                                WHERE eq.estado=1 AND i.rol=1 AND eq.etapa=1 AND u.department_id=ubigeo.department_id
                                GROUP BY u.department
                            ) AS district_id
                            
                            '])
                ->all();

        return $this->render('proyecto3-descargar', [
                    'proyectos' => $proyectos
        ]);
    }

}
