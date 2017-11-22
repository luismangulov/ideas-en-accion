<?php

namespace app\controllers;

use Yii;
use app\models\Cronograma;
use app\models\Proyecto;
use app\models\PlanPresupuestal;
use app\models\Actividad;
use app\models\Integrante;
use app\models\Usuario;

use app\models\ActividadSearch;
use app\models\ObjetivoEspecifico;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ActividadController implements the CRUD actions for Actividad model.
 */
class ActividadController extends Controller {

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
     * Lists all Actividad models.
     * @return mixed
     */
    public function actionIndex($id) {
        $this->layout = 'equipo';
        $actividad = Actividad::findOne($id);
        if ($actividad->estado == 1) {
            return $this->render('index', ['id' => $id]);
        } else {
            return $this->redirect(['panel/index']);
        }
    }

    public function actionIndexc($id) {
        $this->layout = 'equipo';
        $actividad = Actividad::findOne($id);
        return $this->render('indexc', ['id' => $id]);
    }

    /**
     * Displays a single Actividad model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Actividad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Actividad();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Actividad model.
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
     * Deletes an existing Actividad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Actividad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Actividad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Actividad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEliminarplanpresupuestal($id) {

        if (empty($_SERVER['HTTP_REFERER'])) {
            echo 0;
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                echo 0;
                exit;
            }
        }

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id and rol=1', [':estudiante_id' => $usuario->estudiante_id])->one();

        if (empty($integrante)) {
            echo 0;
            exit;
        }

        //$user = Usuario::findOne(\Yii::$app->user->id);
        $proyecto = Proyecto::find()->where('user_id=:user_id', [':user_id' => \Yii::$app->user->id])->one();


        $planpresupuestal = PlanPresupuestal::findOne($id);


        $actividad = Actividad::findOne($planpresupuestal->actividad_id);

        $objetivo = ObjetivoEspecifico::findOne($actividad->objetivo_especifico_id);

        if ($objetivo->proyecto_id != $proyecto->id) {
            echo 0;
            exit;
        }

        $planpresupuestal->estado = 0;
        $planpresupuestal->update();
        echo 1;
    }

    public function actionEliminarcronograma() {
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
        //print_r($integrante);exit;
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id and rol=1', [':estudiante_id' => $usuario->estudiante_id])->one();

        if (empty($integrante)) {
            echo 0;
            exit;
        }

        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $cronograma = Cronograma::findOne($id);
            $proyecto = Proyecto::find()->where('user_id=:user_id', [':user_id' => \Yii::$app->user->id])->one();
            $actividad = Actividad::findOne($cronograma->actividad_id);
            $objetivo = ObjetivoEspecifico::findOne($actividad->objetivo_especifico_id);

            if ($objetivo->proyecto_id != $proyecto->id) {
                echo 0;
                exit;
            }

            $cronograma->estado = 0;
            $cronograma->update();
            echo 1;
        } else {
            echo 0;
        }
    }

    public function actionValidaractividad($id) {
        $actividad = Actividad::findOne($id);
        if ($actividad->estado == 1) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
