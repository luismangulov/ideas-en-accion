<?php

namespace app\controllers;

use Yii;
use app\models\PlanPresupuestal;
use app\models\PlanPresupuestalSearch;
use app\models\Actividad;
use app\models\ActividadCopia;
use app\models\PlanPresupuestalCopia;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PlanPresupuestalController implements the CRUD actions for PlanPresupuestal model.
 */
class PlanPresupuestalController extends Controller {

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
     * Lists all PlanPresupuestal models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PlanPresupuestalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlanPresupuestal model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PlanPresupuestal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PlanPresupuestal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PlanPresupuestal model.
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
     * Deletes an existing PlanPresupuestal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PlanPresupuestal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PlanPresupuestal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PlanPresupuestal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionActividades($id) {

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }
        $countActividades = Actividad::find()
                ->select('actividad.id,actividad.descripcion')
                ->innerJoin('objetivo_especifico', 'objetivo_especifico.id=actividad.objetivo_especifico_id')
                ->where('objetivo_especifico.id=:id and actividad.estado=1', [':id' => $id])
                ->groupBy('actividad.id,actividad.descripcion')
                ->count();

        $actividades = Actividad::find()
                ->select('actividad.id,actividad.descripcion')
                ->innerJoin('objetivo_especifico', 'objetivo_especifico.id=actividad.objetivo_especifico_id')
                ->where('objetivo_especifico.id=:id and actividad.estado=1', [':id' => $id])
                ->groupBy('actividad.id,actividad.descripcion')
                ->orderBy('actividad.descripcion')
                ->all();

        if ($countActividades > 0) {
            echo "<option value>Seleccionar</option>";
            foreach ($actividades as $actividad) {
                echo "<option value='" . $actividad->id . "'>" . htmlentities($actividad->descripcion, ENT_QUOTES) . "</option>";
            }
        } else {
            echo "<option value>Seleccionar</option>";
        }
    }

    public function actionActividades1($id) {
        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }
        $countActividades = ActividadCopia::find()
                ->select('actividad_copia.id,actividad_copia.descripcion')
                ->innerJoin('objetivo_especifico_copia', 'objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                ->where('objetivo_especifico_copia.id=:id and actividad_copia.estado=1 and actividad_copia.etapa=1', [':id' => $id])
                ->groupBy('actividad_copia.id,actividad_copia.descripcion')
                ->count();

        $actividades = ActividadCopia::find()
                ->select('actividad_copia.id,actividad_copia.descripcion')
                ->innerJoin('objetivo_especifico_copia', 'objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                ->where('objetivo_especifico_copia.id=:id and actividad_copia.estado=1 and actividad_copia.etapa=1', [':id' => $id])
                ->groupBy('actividad_copia.id,actividad_copia.descripcion')
                ->orderBy('actividad_copia.descripcion')
                ->all();

        if ($countActividades > 0) {
            echo "<option value>Seleccionar</option>";
            foreach ($actividades as $actividad) {
                echo "<option value='" . $actividad->id . "'>" . htmlentities($actividad->descripcion, ENT_QUOTES) . "</option>";
            }
        } else {
            echo "<option value>Seleccionar</option>";
        }
    }

    public function actionActividades2($id) {
        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }
        $countActividades = ActividadCopia::find()
                ->select('actividad_copia.id,actividad_copia.descripcion')
                ->innerJoin('objetivo_especifico_copia', 'objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                ->where('objetivo_especifico_copia.id=:id and actividad_copia.estado=1 and actividad_copia.etapa=2', [':id' => $id])
                ->groupBy('actividad_copia.id,actividad_copia.descripcion')
                ->count();

        $actividades = ActividadCopia::find()
                ->select('actividad_copia.id,actividad_copia.descripcion')
                ->innerJoin('objetivo_especifico_copia', 'objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                ->where('objetivo_especifico_copia.id=:id and actividad_copia.estado=1 and actividad_copia.etapa=2', [':id' => $id])
                ->groupBy('actividad_copia.id,actividad_copia.descripcion')
                ->orderBy('actividad_copia.descripcion')
                ->all();

        if ($countActividades > 0) {
            echo "<option value>Seleccionar</option>";
            foreach ($actividades as $actividad) {
                echo "<option value='" . $actividad->id . "'>" . htmlentities($actividad->descripcion, ENT_QUOTES) . "</option>";
            }
        } else {
            echo "<option value>Seleccionar</option>";
        }
    }

    public function actionCargatablapresupuesto($valor) {
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
        $planespresupuestales = PlanPresupuestal::find()
                ->where('actividad_id=:actividad_id and estado=1', [':actividad_id' => $valor])
                ->all();

        $countplanespresupuestales = PlanPresupuestal::find()
                ->where('actividad_id=:actividad_id and estado=1', [':actividad_id' => $valor])
                ->count();
        array_push($dataTabla, $countplanespresupuestales);
        foreach ($planespresupuestales as $planpresupuestal) {
            array_push($dataTabla, $planpresupuestal->attributes);
        }
        echo json_encode($dataTabla, JSON_UNESCAPED_UNICODE);
    }

    public function actionCargatablapresupuesto1($valor) {

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
        $planespresupuestales = PlanPresupuestalCopia::find()
                ->where('actividad_id=:actividad_id and estado=1 and etapa=1', [':actividad_id' => $valor])
                ->all();

        $countplanespresupuestales = PlanPresupuestalCopia::find()
                ->where('actividad_id=:actividad_id and estado=1 and etapa=1', [':actividad_id' => $valor])
                ->count();
        array_push($dataTabla, $countplanespresupuestales);
        foreach ($planespresupuestales as $planpresupuestal) {
            array_push($dataTabla, $planpresupuestal->attributes);
        }
        echo json_encode($dataTabla, JSON_UNESCAPED_UNICODE);
    }

    public function actionCargatablapresupuesto2($valor) {

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
        $planespresupuestales = PlanPresupuestalCopia::find()
                ->where('actividad_id=:actividad_id and estado=1 and etapa=2', [':actividad_id' => $valor])
                ->all();

        $countplanespresupuestales = PlanPresupuestalCopia::find()
                ->where('actividad_id=:actividad_id and estado=1 and etapa=2', [':actividad_id' => $valor])
                ->count();
        array_push($dataTabla, $countplanespresupuestales);
        foreach ($planespresupuestales as $planpresupuestal) {
            array_push($dataTabla, $planpresupuestal->attributes);
        }
        echo json_encode($dataTabla, JSON_UNESCAPED_UNICODE);
    }

}
