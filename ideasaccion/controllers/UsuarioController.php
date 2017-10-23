<?php

namespace app\controllers;

use Yii;
use app\models\Estudiante;
use app\models\Registrar;
use app\models\Usuario;
use app\models\Institucion;
use app\models\Ubigeo;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller {

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
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex() {

        return $this->redirect(['usuario/configuracion']);

        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Usuario();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Usuario model.
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
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionConfiguracion() {

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'configurar';
        //$usuario = Usuario::findOne(\Yii::$app->user->id);

        $usuario = Usuario::findOne(\Yii::$app->user->id);
        // $usuario = Usuario::find()->where("id=:estudiante_id and status_registro=2", [':estudiante_id' => $usuario->estudiante_id])->one();
        if (\Yii::$app->user->can('monitor') || \Yii::$app->user->can('administrador') || $usuario->status_registro == "1") {
            return $this->goHome();
        }
       $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();
        $institucion = Institucion::find()->where('id=:id', [':id' => $estudiante->institucion_id])->one();
        $ubigeo = Ubigeo::find()->where('district_id=:district_id', [':district_id' => $institucion->ubigeo_id])->one();
        $registrar = new Registrar;
        $registrar->nombres = $estudiante->nombres;
        $registrar->apellido_paterno = $estudiante->apellido_paterno;
        $registrar->apellido_materno = $estudiante->apellido_materno;
        $registrar->sexo = $estudiante->sexo;
        $registrar->grado = $estudiante->grado;
        $registrar->fecha_nac = date('d/m/Y', strtotime($estudiante->fecha_nac));
        $registrar->celular = $estudiante->celular;
        $registrar->avatar = $usuario->avatar;
        if ($registrar->load(Yii::$app->request->post())) {

            //$fecha_nacimiento=str_replace("/", "-", $registrar->fecha_nac);
            $registrar->foto = UploadedFile::getInstance($registrar, 'foto');
            //$estudiante->nombres=$registrar->nombres;
            //$estudiante->apellido_paterno=$registrar->apellido_paterno;
            //$estudiante->apellido_materno=$registrar->apellido_materno;
            //$estudiante->sexo=$registrar->sexo;

            if ($registrar->foto) {

                if (strtoupper($registrar->foto->extension) != "JPG" && strtoupper($registrar->foto->extension) != "PNG") {
                    Yii::$app->session->setFlash('error_file');
                    return $this->refresh();
                }
                //print_r($registrar->foto);exit;

                if (!empty($registrar->foto->tempName)) {
                    if ($registrar->foto->size / 1024 / 1024 > 1) {
                        Yii::$app->session->setFlash('error_file_size');
                        return $this->refresh();
                    }

                    $exif = exif_imagetype($registrar->foto->tempName);


                    $types = array(
                        2 => "JPEG",
                        3 => "PNG"
                    );

                    if (array_key_exists($exif, $types)) {
                        //  echo "Image type is: " . $types[$exif];
                    } else {
                        //echo "Not a valid image type";
                        Yii::$app->session->setFlash('error_file');
                        return $this->refresh();
                    }
                } else {
                    Yii::$app->session->setFlash('error_file');
                    return $this->refresh();
                }
            }


            if ($estudiante->grado != "6") {
                $estudiante->grado = $registrar->grado;
            }

            $estudiante->celular = $registrar->celular;
            //$estudiante->fecha_nac=date('Y-m-d',strtotime($fecha_nacimiento));
            $estudiante->update();

            if ($registrar->foto) {
                $registrar->foto->saveAs('foto_personal/' . $usuario->id . '.' . $registrar->foto->extension);
                $usuario->avatar = $usuario->id . '.' . $registrar->foto->extension;
            }

            Yii::$app->session->setFlash('mensajesuccess', "Se actualizó correctamente");
            $usuario->update();
            return $this->refresh();
        } else {
            return $this->render('configuracion', ['registrar' => $registrar, 'ubigeo' => $ubigeo, 'institucion' => $institucion]);
        }
    }

    public function actionCambiar() {
        $this->layout = 'administrador';
        $model = Usuario::findOne(\Yii::$app->user->id);
        if ($model->load(Yii::$app->request->post())) {
            $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password); //crypt($model->password,"ideasenaccion");
            $model->update();
            Yii::$app->session->setFlash('contrasena');
            return $this->refresh();
        }
        return $this->render('cambiar', ['model' => $model]);
    }

}
