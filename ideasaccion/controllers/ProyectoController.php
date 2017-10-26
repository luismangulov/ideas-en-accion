<?php

namespace app\controllers;

use Yii;
use app\models\Actividad;
use app\models\ObjetivoEspecifico;
use app\models\Proyecto;
use app\models\ProyectoCopia;
use app\models\Reflexion;
use app\models\ProyectoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Etapa;
use app\models\Equipo;
use app\models\Usuario;
use app\models\Integrante;
use app\models\Video;
use app\models\Evaluacion;
use app\models\VotacionInterna;
use app\models\Ubigeo;
use app\models\VotacionPublica;
use app\models\Estudiante;
use app\models\Resultados;
use app\models\Institucion;
use yii\db\Query;
use yii\web\UploadedFile;

/**
 * ProyectoController implements the CRUD actions for Proyecto model.
 */
class ProyectoController extends Controller {

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
        $usuario = Usuario::findOne(\Yii::$app->user->id);

        if ($usuario->name_temporal == "Monitor" || $usuario->name_temporal == "Adminitrador" || $usuario->status_registro == "1") {
            return $this->goHome();
        }
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $Comprobandolider = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();

        if ($Comprobandolider->rol == 2) {
            $this->redirect(['panel/ideas-accion']);
        }

        $this->layout = 'estandar';
        $proyecto = Proyecto::find()->where('user_id=:user_id', [':user_id' => \Yii::$app->user->id])->one();
        if ($proyecto) {
            return $this->redirect(['proyecto/actualizar']);
        }
        return $this->render('index');
    }

    /**
     * Displays a single Proyecto model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Proyecto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Proyecto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Proyecto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Proyecto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Proyecto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proyecto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Proyecto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionActualizar() {

        $this->layout = 'estandar';
        $etapa1 = Etapa::find()->where('etapa=1 and estado=1')->one();
        $etapa2 = Etapa::find()->where('etapa=2 and estado=1')->one();
        $usuario = Usuario::findOne(\Yii::$app->user->id);

        if ($usuario->name_temporal == "Monitor" || $usuario->name_temporal == "Adminitrador" || $usuario->status_registro == "1") {
            return $this->goHome();
        }

        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();

        $actualizar = Proyecto::find()->where('equipo_id=:equipo_id', [':equipo_id' => $integrante->equipo_id])->one();

        /*  print_r($actualizar);
          exit; */
        if ($actualizar) {
            $equipo = Equipo::findOne($integrante->equipo_id);

            if ($equipo->etapa == 1 && $etapa1) {

                //$this->layout = 'blank';
                return $this->redirect(array('entrega/primera'));

                //return Yii::$app->redirect(array('/entrega/primera'));
                //$this->redirect('entrega/primera');
            } else if ($equipo->etapa == 1 && $etapa2) {

                return $this->render('actualizar');
            }

            return $this->render('actualizar');
        } else {
            return $this->redirect(['proyecto/index']);
        }
    }

    public function actionEliminaractividad($id) {
        $actividad = Actividad::findOne($id);
        $actividad->estado = 0;
        $actividad->update();
    }

    public function actionFinalizarprimeraentrega() {

        if (empty($_SERVER['HTTP_REFERER'])) {

            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {

                exit;
            }
        }

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id and rol=1', [':estudiante_id' => $usuario->estudiante_id])->one();


        if (empty($integrante)) {
            echo 2;
            exit;
        }


        $etapa = Etapa::find()->where('estado=1')->one();
        $proyecto = new Proyecto;
        $proyecto->load(Yii::$app->request->post());
        $proyecto2 = Proyecto::find()->where('user_id=:user_id', [':user_id' => \Yii::$app->user->id])->one();

        if ($proyecto->id != $proyecto2->id) {
            echo 2;
            exit;
        }
        $proyectoexiste = ProyectoCopia::find()->where('id=:id and etapa=1', [':id' => $proyecto->id])->one();
        if (!$proyectoexiste) {
            $proyectocopia = 'insert into proyecto_copia (id,titulo,resumen,objetivo_general,beneficiario,user_id,asunto_id,equipo_id,etapa,proyecto_archivo,formato_proyecto)
                                select id,titulo,resumen,objetivo_general,beneficiario,user_id,asunto_id,equipo_id,1,proyecto_archivo,formato_proyecto from proyecto
                                where id=' . $proyecto->id . '  ';
            \Yii::$app->db->createCommand($proyectocopia)->execute();

            $objetivosespecificoscopia = 'insert into objetivo_especifico_copia (id,proyecto_id,descripcion,etapa)
                                select id,proyecto_id,descripcion,1 from objetivo_especifico
                                where proyecto_id=' . $proyecto->id . '  ';
            \Yii::$app->db->createCommand($objetivosespecificoscopia)->execute();

            $actividadcopia = 'insert into actividad_copia (id,objetivo_especifico_id,descripcion,resultado_esperado,estado,etapa)
                                select actividad.id,actividad.objetivo_especifico_id,actividad.descripcion,actividad.resultado_esperado,actividad.estado,1 from actividad
                                inner join objetivo_especifico on objetivo_especifico.id=actividad.objetivo_especifico_id
                                where objetivo_especifico.proyecto_id=' . $proyecto->id . ' and actividad.estado=1 ';
            \Yii::$app->db->createCommand($actividadcopia)->execute();


            $planpresupuestalcopia = 'insert into plan_presupuestal_copia
                                (id,actividad_id,dirigido,recurso,recurso_descripcion,unidad,como_conseguirlo,precio_unitario,cantidad,subtotal,estado,etapa)
                        select  plan_presupuestal.id,plan_presupuestal.actividad_id,plan_presupuestal.dirigido,plan_presupuestal.recurso,
                                plan_presupuestal.recurso_descripcion,plan_presupuestal.unidad,plan_presupuestal.como_conseguirlo,
                                plan_presupuestal.precio_unitario,plan_presupuestal.cantidad,plan_presupuestal.subtotal,plan_presupuestal.estado,1
                                from plan_presupuestal
                                inner join actividad on plan_presupuestal.actividad_id=actividad.id
                                inner join objetivo_especifico on objetivo_especifico.id=actividad.objetivo_especifico_id
                                where objetivo_especifico.proyecto_id=' . $proyecto->id . ' and plan_presupuestal.estado=1  ';
            \Yii::$app->db->createCommand($planpresupuestalcopia)->execute();

            $cronogramacopia = 'insert into cronograma_copia (id,actividad_id,tarea,fecha_inicio,fecha_fin,duracion,responsable_id,estado,etapa)
                                select cronograma.id,cronograma.actividad_id,cronograma.tarea,cronograma.fecha_inicio,cronograma.fecha_fin,
                                cronograma.duracion,cronograma.responsable_id,cronograma.estado,1
                                from cronograma
                                inner join actividad on cronograma.actividad_id=actividad.id
                                inner join objetivo_especifico on objetivo_especifico.id=actividad.objetivo_especifico_id
                                where objetivo_especifico.proyecto_id=' . $proyecto->id . ' and cronograma.estado=1 ';
            \Yii::$app->db->createCommand($cronogramacopia)->execute();

            $videocopia = 'insert into video_copia (id,proyecto_id,ruta,etapa,tipo)
                                select id,proyecto_id,ruta,1,tipo from video
                                where proyecto_id=' . $proyecto->id . ' and etapa=0 ';
            \Yii::$app->db->createCommand($videocopia)->execute();


            $usuario = Usuario::findOne(\Yii::$app->user->id);
            $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
            $video = Video::find()->where('proyecto_id=:proyecto_id and etapa=:etapa', [':proyecto_id' => $proyecto->id, ':etapa' => 0])->one();
            $video->etapa = 1;
            $video->update();
            /* $evaluacion = 'insert into evaluacion (evaluacion,proyecto_id,user_id)
              select "" , '.$proyecto->id.' , usuario.id from integrante
              inner join usuario on usuario.estudiante_id=integrante.estudiante_id
              inner join estudiante on estudiante.id=usuario.estudiante_id
              where estudiante.grado!=6 and integrante.equipo_id='.$integrante->equipo_id.' ';

              \Yii::$app->db->createCommand($evaluacion)->execute();
             */


            $proyectoetapa = Proyecto::findOne($proyecto->id);
            $equipo = Equipo::findOne($proyectoetapa->equipo_id);
            $equipo->etapa = $etapa->etapa;
            $equipo->update();

            echo 1;
        } else {
            echo 2;
        }
    }

    public function actionFinalizarsegundaentrega() {
        $etapa = Etapa::find()->where('estado=1')->one();
        $proyecto = new Proyecto;
        $proyecto->load(Yii::$app->request->post());
        $proyectoexiste = ProyectoCopia::find()->where('id=:id and etapa=2', [':id' => $proyecto->id])->one();
        if (!$proyectoexiste) {

            $proyectocopia = 'insert into proyecto_copia (id,titulo,resumen,objetivo_general,beneficiario,user_id,asunto_id,equipo_id,etapa,proyecto_archivo,formato_proyecto,proyecto_archivo2,formato_proyecto2)
                                select id,titulo,resumen,objetivo_general,beneficiario,user_id,asunto_id,equipo_id,2,proyecto_archivo,formato_proyecto,proyecto_archivo2,formato_proyecto2 from proyecto
                                where id=' . $proyecto->id . '  ';
            \Yii::$app->db->createCommand($proyectocopia)->execute();

            $objetivosespecificoscopia = 'insert into objetivo_especifico_copia (id,proyecto_id,descripcion,etapa)
                                select id,proyecto_id,descripcion,2 from objetivo_especifico
                                where proyecto_id=' . $proyecto->id . '  ';
            \Yii::$app->db->createCommand($objetivosespecificoscopia)->execute();

            $actividadcopia = 'insert into actividad_copia (id,objetivo_especifico_id,descripcion,resultado_esperado,estado,etapa)
                                select actividad.id,actividad.objetivo_especifico_id,actividad.descripcion,actividad.resultado_esperado,actividad.estado,2 from actividad
                                inner join objetivo_especifico on objetivo_especifico.id=actividad.objetivo_especifico_id
                                where objetivo_especifico.proyecto_id=' . $proyecto->id . ' and actividad.estado=1 ';
            \Yii::$app->db->createCommand($actividadcopia)->execute();

            $planpresupuestalcopia = 'insert into plan_presupuestal_copia
                                (id,actividad_id,dirigido,recurso,recurso_descripcion,unidad,como_conseguirlo,precio_unitario,cantidad,subtotal,estado,etapa)
                        select plan_presupuestal.id,plan_presupuestal.actividad_id,plan_presupuestal.dirigido,plan_presupuestal.recurso,
                                plan_presupuestal.recurso_descripcion,plan_presupuestal.unidad,plan_presupuestal.como_conseguirlo,
                                plan_presupuestal.precio_unitario,plan_presupuestal.cantidad,plan_presupuestal.subtotal,plan_presupuestal.estado,2
                                from plan_presupuestal
                                inner join actividad on plan_presupuestal.actividad_id=actividad.id
                                inner join objetivo_especifico on objetivo_especifico.id=actividad.objetivo_especifico_id
                                where objetivo_especifico.proyecto_id=' . $proyecto->id . ' and plan_presupuestal.estado=1  ';
            \Yii::$app->db->createCommand($planpresupuestalcopia)->execute();

            $cronogramacopia = 'insert into cronograma_copia (id,actividad_id,fecha_inicio,fecha_fin,duracion,responsable_id,estado,etapa,tarea)
                                select cronograma.id,cronograma.actividad_id,cronograma.fecha_inicio,cronograma.fecha_fin,
                                cronograma.duracion,cronograma.responsable_id,cronograma.estado,2,cronograma.tarea
                                from cronograma
                                inner join actividad on cronograma.actividad_id=actividad.id
                                inner join objetivo_especifico on objetivo_especifico.id=actividad.objetivo_especifico_id
                                where objetivo_especifico.proyecto_id=' . $proyecto->id . ' and cronograma.estado=1 ';
            \Yii::$app->db->createCommand($cronogramacopia)->execute();

            $videocopia = 'insert into video_copia (id,proyecto_id,ruta,etapa,tipo)
                                select id,proyecto_id,ruta,2,tipo from video
                                where proyecto_id=' . $proyecto->id . ' and etapa=0';
            \Yii::$app->db->createCommand($videocopia)->execute();


            $usuario = Usuario::findOne(\Yii::$app->user->id);
            $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
            $video = Video::find()->where('proyecto_id=:proyecto_id and etapa=:etapa', [':proyecto_id' => $proyecto->id, ':etapa' => 0])->one();
            $video->etapa = 2;
            $video->update();
            $proyectoetapa = Proyecto::findOne($proyecto->id);
            $equipo = Equipo::findOne($proyectoetapa->equipo_id);
            $equipo->etapa = 2;
            $equipo->update();

            echo 1;
        } else {
            echo 2;
        }
    }

    public function actionReflexion() {
        //var_dump($_REQUEST);die;
        $reflexion = new Reflexion;
        $reflexion->load(Yii::$app->request->post());

        $reflexiona = Reflexion::find()->where('proyecto_id=:proyecto_id and user_id=:user_id', [':proyecto_id' => $reflexion->proyecto_id, ':user_id' => $reflexion->user_id])->one();
        $reflexiona->reflexion = $reflexion->reflexion;
        $reflexiona->update();
        echo 1;
    }

    public function actionEvaluacion() {
        if (empty($_SERVER['HTTP_REFERER'])) {
            echo "";
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                echo "";
                exit;
            }
        }

        $evaluacion = new Evaluacion;
        $evaluacion->load(Yii::$app->request->post());
        $evaluaciona = Evaluacion::find()->where('proyecto_id=:proyecto_id and user_id=:user_id', [':proyecto_id' => $evaluacion->proyecto_id, ':user_id' => $evaluacion->user_id])->one();
        $evaluaciona->evaluacion = $evaluacion->evaluacion;
        $evaluaciona->update();
        echo 1;
    }

    public function actionCerrarprimeraentrega() {

        if (empty($_SERVER['HTTP_REFERER'])) {
            echo "";
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                echo "";
                exit;
            }
        }

        $proyectoexiste = ProyectoCopia::find()->where('etapa=1')->all();
        $etapa = Etapa::find()->where('estado=1 and etapa=1')->one();
        if ($proyectoexiste && $etapa) {
            $foros = 'insert into foro (titulo,descripcion,user_id,post_count,proyecto_id)
                    select proyecto.titulo,proyecto.resumen,1,0,proyecto.id from proyecto
                    inner join equipo on equipo.id=proyecto.equipo_id
                    where  equipo.etapa=1';
            \Yii::$app->db->createCommand($foros)->execute();
            $etapa->estado = 0;
            $etapa->update();
            $nuevaetapa = new Etapa;
            $nuevaetapa->etapa = 2;
            $nuevaetapa->estado = 1;
            $nuevaetapa->save();
            echo 1;
        } elseif (!$proyectoexiste) {
            echo 2;
        } else {
            echo 3;
        }
    }

    public function actionCerrarsegundaentrega() {

        if (empty($_SERVER['HTTP_REFERER'])) {
            echo "";
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                echo "";
                exit;
            }
        }

        $proyectoexiste = ProyectoCopia::find()->where('etapa=2')->all();
        $etapa = Etapa::find()->where('estado=1 and etapa=2')->one();
        if ($proyectoexiste && $etapa) {
            $etapa->estado = 0;
            $etapa->update();
            $nuevaetapa = new Etapa;
            $nuevaetapa->etapa = 3;
            $nuevaetapa->estado = 1;
            $nuevaetapa->save();
            echo 1;
        } elseif (!$proyectoexiste) {
            echo 2;
        } else {
            echo 3;
        }
    }

    public function actionBuscar() {
        $this->layout = 'estandar';
        $searchModel = new ProyectoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Proyecto;
        return $this->render('buscar', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model]);
    }

    public function actionBuscarMonitor() {
        $this->layout = 'administrador';
        $searchModel = new ProyectoSearch();
        $dataProvider = $searchModel->monitor(Yii::$app->request->queryParams);
        $model = new Proyecto;
        return $this->render('buscar-monitor', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model]);
    }

    public function actionAsunto($region) {
        if (empty($_SERVER['HTTP_REFERER'])) {

            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {

                exit;
            }
        }

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

//[':department_id' => $ubigeo->department_id]
        // echo $region;
        if ($countAsuntos > 0) {
            echo "<option value></option>";
            foreach ($asuntos as $asunto) {
                echo "<option value='" . $asunto->id . "'>" . htmlentities($asunto->descripcion_corta, ENT_QUOTES) . "</option>";
            }
        } else {
            echo "<option value></option>";
        }
    }

    public function actionVotacion() {

        $etapa3 = Etapa::find()->where('etapa=3 and estado=1')->one();
        $votacionpublica = VotacionPublica::find()->count();




        if (\Yii::$app->user->can('monitor') || \Yii::$app->user->can('administrador') || !$etapa3 || $votacionpublica > 0) {
            return $this->goHome();
        }

        $this->layout = 'estandar';
        $model = new Proyecto;
        $searchModel = new ProyectoSearch();
        $dataProvider = $searchModel->votacion(Yii::$app->request->queryParams);
        $votacionesinternas = VotacionInterna::find()
                ->where('user_id=:user_id and estado in (1,2)', [':user_id' => \Yii::$app->user->id])
                ->all();
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $estudiante = Estudiante::findOne($usuario->estudiante_id);
        $institucion = Institucion::findOne($estudiante->institucion_id);
        $ubigeo = Ubigeo::find()->where('district_id=:district_id', [':district_id' => $institucion->ubigeo_id])->one();

        $regionCount = Equipo::find()
                ->innerJoin('proyecto', 'proyecto.equipo_id=equipo.id')
                ->innerJoin('integrante', 'integrante.equipo_id=equipo.id')
                ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                ->innerJoin('institucion', 'institucion.id=estudiante.institucion_id')
                ->innerJoin('ubigeo', 'ubigeo.district_id=institucion.ubigeo_id')
                ->where('integrante.rol=1 and equipo.etapa=2 and ubigeo.department_id=:department_id', [':department_id' => $ubigeo->department_id])
                ->count();


        $votacionesinternasCount = VotacionInterna::find()
                ->where('user_id=:user_id and estado=1', [':user_id' => \Yii::$app->user->id])
                ->count();
        $votacionesinternasfinalizadasCount = VotacionInterna::find()
                ->where('user_id=:user_id and estado=2', [':user_id' => \Yii::$app->user->id])
                ->count();
        $votacion_publica = VotacionPublica::find()->all();
        return $this->render('votacion', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'votacionesinternas' => $votacionesinternas,
                    'votacionesinternasCount' => $votacionesinternasCount,
                    'votacionesinternasfinalizadasCount' => $votacionesinternasfinalizadasCount,
                    'votacion_publica' => $votacion_publica,
                    'regionCount' => $regionCount]);
    }

    public function actionVotacioninterna($id) {
        if (empty($_SERVER['HTTP_REFERER'])) {

            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {

                exit;
            }
        }
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();

        $proyectosession = Proyecto::find()->where('equipo_id=:equipo_id', [':equipo_id' => $integrante->equipo_id])->one();

        $proyecto = Proyecto::findOne($id);

        if ($proyecto->region_id != $proyectosession->region_id) {
            echo 3;
            exit;
        }


        $votacioninterna = VotacionInterna::find()
                ->where('proyecto_id=:proyecto_id and user_id=:user_id and estado=1', [':proyecto_id' => $proyecto->id, ':user_id' => \Yii::$app->user->id])
                ->one();

        $countvotacioninterna = VotacionInterna::find()
                ->where('user_id=:user_id', [':user_id' => \Yii::$app->user->id])
                ->count();

        if ($countvotacioninterna < 3 || $votacioninterna) {
            if (!$votacioninterna) {
                $votacioninterna = new VotacionInterna;
                $votacioninterna->proyecto_id = $proyecto->id;
                $votacioninterna->region_id = $proyecto->region_id;
                $votacioninterna->user_id = \Yii::$app->user->id;
                $votacioninterna->estado = 1;
                $votacioninterna->save();
                echo 1;
            }/*
              else
              {
              VotacionInterna::find()
              ->where('proyecto_id=:proyecto_id and user_id=:user_id and estado=1',
              [':proyecto_id'=>$proyecto->id,':user_id'=>\Yii::$app->user->id])
              ->one()
              ->delete();
              echo 2;
              } */
        } else {
            echo 3;
        }
    }

    public function actionVotacioninternaeliminar($id) {
        if (empty($_SERVER['HTTP_REFERER'])) {

            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {

                exit;
            }
        }


        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();

        $proyectosession = Proyecto::find()->where('equipo_id=:equipo_id', [':equipo_id' => $integrante->equipo_id])->one();

        $proyecto = Proyecto::findOne($id);

        if ($proyecto->region_id != $proyectosession->region_id) {
            echo 3;
            exit;
        }


        $votacioninterna = VotacionInterna::find()
                ->where('proyecto_id=:proyecto_id and user_id=:user_id and estado=1', [':proyecto_id' => $proyecto->id, ':user_id' => \Yii::$app->user->id])
                ->one();

        $countvotacioninterna = VotacionInterna::find()
                ->where('user_id=:user_id', [':user_id' => \Yii::$app->user->id])
                ->count();

        if ($countvotacioninterna < 3 || $votacioninterna) {
            if (!$votacioninterna) {
                $votacioninterna = new VotacionInterna;
                $votacioninterna->proyecto_id = $proyecto->id;
                $votacioninterna->region_id = $proyecto->region_id;
                $votacioninterna->user_id = \Yii::$app->user->id;
                $votacioninterna->estado = 1;
                $votacioninterna->save();
                echo 1;
            } else {
                VotacionInterna::find()
                        ->where('proyecto_id=:proyecto_id and user_id=:user_id and estado=1', [':proyecto_id' => $proyecto->id, ':user_id' => \Yii::$app->user->id])
                        ->one()
                        ->delete();
                echo 2;
            }
        } else {
            echo 3;
        }
    }

    public function actionFinalizarvotacioninterna() {
        $updatevotacioninterna = 'update votacion_interna set estado=2 where user_id=' . \Yii::$app->user->id . ' and estado=1';

        \Yii::$app->db->createCommand($updatevotacioninterna)->execute();

        echo 1;
    }

    public function actionValoraporcentualadministrador($proyecto_id, $valor, $resultatotal) {
        $updatevalorporcentual = 'update proyecto set valor_porcentual_administrador=' . $valor . ',resultado=' . $resultatotal . '
                                        where id=' . $proyecto_id . '';

        \Yii::$app->db->createCommand($updatevalorporcentual)->execute();

        echo 1;
    }

    public function actionCerrarvotacioninterna() {
        //$resultados=Resultados::find()->all();
        $connection = \Yii::$app->db;
        $ubigeos = Ubigeo::find()->select('department_id,department')->groupBy('department_id')->orderBy('department desc')->all();

        foreach ($ubigeos as $ubigeo) {
            $command = $connection->createCommand("
                insert into votacion_publica (proyecto_id,region_id,estado)
                select votacion_interna.proyecto_id,votacion_interna.region_id,1 from votacion_interna
                inner join proyecto on proyecto.id=votacion_interna.proyecto_id
                where votacion_interna.region_id='$ubigeo->department_id' and votacion_interna.estado=2
                group by votacion_interna.proyecto_id,votacion_interna.region_id,1
                order by proyecto.resultado desc
                limit 3;
            ");
            $command->execute();
        }
        echo 1;
    }

    public function actionPrueba() {
        $connection = \Yii::$app->db;
        $ubigeos = Ubigeo::find()->select('department_id,department')->groupBy('department_id')->orderBy('department desc')->all();

        foreach ($ubigeos as $ubigeo) {

            $query = new Query;
            $threads = $query->select('u.department_id,i.id')
                    ->from('{{%institucion}} as i')
                    ->join('INNER JOIN', '{{%ubigeo}} as u', 'u.district_id=i.ubigeo_id')
                    ->where('u.department_id=:id', [':id' => $ubigeo->department_id])
                    ->limit(3)
                    ->all();

            foreach ($threads as $thread) {
                echo $thread["department_id"] . "             " . $thread["id"] . "<br>";
                //var_dump($thread["id"]);
            }
        }
    }

    public function actionArchivo() {
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
        $estudiante = Estudiante::find()->where('id=:id', [':id' => $integrante->estudiante_id])->one();
        $equipo = Equipo::findOne($integrante->equipo_id);
        $proyecto = Proyecto::find()->where('equipo_id=:equipo_id', [':equipo_id' => $integrante->equipo_id])->one();

        $proyecto->archivo = UploadedFile::getInstance($proyecto, 'archivo');
        if ($proyecto->archivo) {

            $proyecto->proyecto_archivo = $proyecto->id . '.' . $proyecto->archivo->extension;
            $proyecto->formato_proyecto = 1; //formato en documento
            $proyecto->update();
            $proyecto->archivo->saveAs('proyectos/' . $proyecto->proyecto_archivo);
        }
    }

    public function actionArchivo2() {
        //var_dump("primero");die;x

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }


        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
        $estudiante = Estudiante::find()->where('id=:id', [':id' => $integrante->estudiante_id])->one();
        $equipo = Equipo::findOne($integrante->equipo_id);
        $proyecto = Proyecto::find()->where('equipo_id=:equipo_id', [':equipo_id' => $integrante->equipo_id])->one();

        $proyecto->archivo2 = UploadedFile::getInstance($proyecto, 'archivo2');

        $respuesta = "0";
        if ($proyecto->archivo2) {
            /* print_r($proyecto->archivo2);
              exit; */

            if (strtoupper($proyecto->archivo2->extension) != "PDF") {
                $respuesta = "0";
            } else {
                if ($proyecto->archivo2->size > 2097152) {
                    $respuesta = "2";
                } else {
                    $version = pdfVersion($proyecto->archivo2->tempName);

                    if ($version != 0) {


                        $proyecto->proyecto_archivo2 = $proyecto->id . '_2.' . $proyecto->archivo2->extension;
                        $proyecto->formato_proyecto2 = 1; //formato en documento
                        $proyecto->update();
                        $proyecto->archivo2->saveAs('proyectos/' . $proyecto->proyecto_archivo2);
                        $respuesta = "1";
                    }
                }
            }
        }

        echo $respuesta;
    }

    public function actionEliminarArchivo2() {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $proyecto = Proyecto::findOne($id);
            $proyecto->proyecto_archivo2 = NULL;
            $proyecto->formato_proyecto2 = NULL;
            $proyecto->update();
        }
    }

}

function pdfVersion($filename) {
    $fp = @fopen($filename, 'rb');

    if (!$fp) {
        return 0;
    }

    /* Reset file pointer to the start */
    fseek($fp, 0);

    /* Read 20 bytes from the start of the PDF */
    preg_match('/\d\.\d/', fread($fp, 20), $match);

    fclose($fp);

    if (isset($match[0])) {
        return $match[0];
    } else {
        return 0;
    }
}
