<?php

namespace app\controllers;

use Yii;
use app\models\Institucion;
use app\models\Ubigeo;
use app\models\UbigeoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UbigeoController implements the CRUD actions for Ubigeo model.
 */
class UbigeoController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ubigeo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UbigeoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ubigeo model.
     * @param string $department_id
     * @param string $district_id
     * @return mixed
     */
    public function actionView($department_id, $district_id) {
        return $this->render('view', [
                    'model' => $this->findModel($department_id, $district_id),
        ]);
    }

    /**
     * Creates a new Ubigeo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Ubigeo();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'department_id' => $model->department_id, 'district_id' => $model->district_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ubigeo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $department_id
     * @param string $district_id
     * @return mixed
     */
    public function actionUpdate($department_id, $district_id) {
        $model = $this->findModel($department_id, $district_id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'department_id' => $model->department_id, 'district_id' => $model->district_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ubigeo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $department_id
     * @param string $district_id
     * @return mixed
     */
    public function actionDelete($department_id, $district_id) {
        $this->findModel($department_id, $district_id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Ubigeo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $department_id
     * @param string $district_id
     * @return Ubigeo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($department_id, $district_id) {
        if (($model = Ubigeo::findOne(['department_id' => $department_id, 'district_id' => $district_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionProvincias($departamento) {
        //var_dump($departamento);die;

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }

        $countProvincias = Ubigeo::find()
                        ->select('province_id,province')
                        ->innerJoin('institucion i', 'i.ubigeo_id=ubigeo.district_id')
                        ->where('department_id=:department_id', [':department_id' => $departamento])->groupBy('province_id,province')->count();
        $provincias = Ubigeo::find()->select('province_id,province')
                        ->innerJoin('institucion i', 'i.ubigeo_id=ubigeo.district_id')
                        ->where('department_id=:department_id', [':department_id' => $departamento])->groupBy('province_id,province')->orderBy('province')->all();

        if ($countProvincias > 0) {
            echo "<option value></option>";
            foreach ($provincias as $provincia) {
                echo "<option value='" . $provincia->province_id . "'>" . $provincia->province . "</option>";
            }
        } else {
            echo "<option value></option>";
        }
    }

    public function actionDistritos($provincia) {

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }

        $countDistritos = Ubigeo::find()
                ->select('district_id,district')
                ->innerJoin('institucion i', 'i.ubigeo_id=ubigeo.district_id')
                ->where('province_id=:province_id', [':province_id' => $provincia])
                ->groupBy('district_id,district')
                ->count();
        $distritos = Ubigeo::find()
                ->select('district_id,district')
                ->innerJoin('institucion i', 'i.ubigeo_id=ubigeo.district_id')
                ->where('province_id=:province_id', [':province_id' => $provincia])
                ->groupBy('district_id,district')
                ->orderBy('district')
                ->all();

        if ($countDistritos > 0) {
            echo "<option value></option>";
            foreach ($distritos as $distrito) {
                echo "<option value='" . $distrito->district_id . "'>" . $distrito->district . "</option>";
            }
        } else {
            echo "<option value></option>";
        }
    }

    public function actionInstituciones($distrito) {
        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }

        $countInstitucion = Institucion::find()
                        ->select('id,denominacion,codigo_modular')
                        ->where('ubigeo_id=:ubigeo_id and estado=1', [':ubigeo_id' => $distrito])
                        ->groupBy('id,denominacion,codigo_modular')->count();

        $instituciones = Institucion::find()
                        ->select('id,denominacion,codigo_modular')
                        ->where('ubigeo_id=:ubigeo_id and estado=1', [':ubigeo_id' => $distrito])
                        ->groupBy('id,denominacion,codigo_modular')
                        ->orderBy('denominacion asc')->all();

        if ($countInstitucion > 0) {
            echo "<option value></option>";
            foreach ($instituciones as $institucion) {
                echo "<option value='" . $institucion->id . "'>" . $institucion->denominacion . "</option>";
            }
        } else {
            echo "<option value></option>";
        }
    }

}
