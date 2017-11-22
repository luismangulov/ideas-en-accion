<?php

namespace app\controllers;

use Yii;
use app\models\Cronograma;
use app\models\CronogramaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Actividad;
use app\models\ObjetivoEspecifico;
use app\models\Proyecto;
use app\models\Usuario;
use app\models\Integrante;
use yii\filters\AccessControl;

/**
 * CronogramaController implements the CRUD actions for Cronograma model.
 */
class CronogramaController extends Controller {

    public $proyecto_id;
    public $disabled;

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
     * Lists all Cronograma models.
     * @return mixed
     */
    public function actionIndex() {
        $disabled = false;
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
        $responsables = Integrante::find()->where('equipo_id=:equipo_id', [':equipo_id' => $integrante->equipo_id])->all();
        $proyecto = Proyecto::findOne(1);
        $objetivos = ObjetivoEspecifico::find()->where('proyecto_id=:proyecto_id', [':proyecto_id' => $proyecto->id])->all();
        $actividades = Actividad::find()
                ->innerJoin('objetivo_especifico', 'objetivo_especifico.id=actividad.objetivo_especifico_id')
                ->where('objetivo_especifico.proyecto_id=:proyecto_id', [':proyecto_id' => $proyecto->id])
                ->all();

        $cronogramas = Cronograma::find()
                ->select('  cronograma.id,cronograma.fecha_inicio,cronograma.fecha_fin,
                                cronograma.duracion,cronograma.responsable_id,cronograma.estado,
                                cronograma.actividad_id,objetivo_especifico.id objetivo_especifico_id')
                ->innerJoin('actividad', 'actividad.id=cronograma.actividad_id')
                ->innerJoin('objetivo_especifico', 'objetivo_especifico.id=actividad.objetivo_especifico_id')
                ->where('objetivo_especifico.proyecto_id=:proyecto_id and actividad.estado=1 and cronograma.estado=1', [':proyecto_id' => $proyecto->id])
                ->all();

        return $this->render('index', ['proyecto' => $proyecto,
                    'objetivos' => $objetivos,
                    'actividades' => $actividades,
                    'cronogramas' => $cronogramas,
                    'disabled' => $disabled,
                    'responsables' => $responsables]);
    }

    /**
     * Displays a single Cronograma model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cronograma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Cronograma();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cronograma model.
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
     * Deletes an existing Cronograma model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cronograma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cronograma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Cronograma::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCargatablacronograma($valor) {

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }
        $dataTabla = [];
        $cronogramaArray = [];
        $cronogramas = Cronograma::find()
                ->where('actividad_id=:actividad_id and estado=1', [':actividad_id' => $valor])
                ->all();

        $countcronogramas = Cronograma::find()
                ->where('actividad_id=:actividad_id and estado=1', [':actividad_id' => $valor])
                ->count();
        array_push($dataTabla, $countcronogramas);
        foreach ($cronogramas as $cronograma) {
            array_push($dataTabla, ['id' => $cronograma->id, 'tarea' => $cronograma->tarea, 'responsable' => $cronograma->responsable_id, 'fecha_inicio' => date("d/m/Y", strtotime($cronograma->fecha_inicio)), 'fecha_fin' => date("d/m/Y", strtotime($cronograma->fecha_fin))]);
        }

        //array_push($dataTabla,['cronograma'=>$cronogramaArray]);
        echo json_encode($dataTabla, JSON_UNESCAPED_UNICODE);
    }

}
