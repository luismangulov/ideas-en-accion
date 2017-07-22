<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\Integrante;
use app\models\Invitacion;
use app\models\Equipo;
use app\models\Asunto;
use app\models\Estudiante;
use app\models\EquipoSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EquipoController implements the CRUD actions for Equipo model.
 */
class EquipoController extends Controller {

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
     * Lists all Equipo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new EquipoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Equipo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Equipo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Equipo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Equipo model.
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
     * Deletes an existing Equipo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Equipo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Equipo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Equipo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUnirme() {

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }

        if (isset($_POST["id"]) && $_POST["id"] != "") {
            $id = $_POST["id"];
            $invitacion = Invitacion::findOne($id);

            $usuario = Usuario::findOne(\Yii::$app->user->id);

            if ($invitacion->estudiante_invitado_id != $usuario->estudiante_id) {
                exit;
            }

            $invitacion->estado = 2;
            $invitacion->fecha_aceptacion = date("Y-m-d H:i:s");
            $invitacion->update();
            $equipo = Equipo::find()->where('id=:id', [':id' => $invitacion->equipo_id])->one();
            Invitacion::updateAll(['estado' => 0], 'estado = 1 and estudiante_invitado_id=:estudiante_invitado_id and not id=:id', [':estudiante_invitado_id' => $invitacion->estudiante_invitado_id, ':id' => $id]);


            $validarIntegrante = Integrante::find()
                    ->where('equipo_id=:equipo_id and estudiante_id=:estudiante_id and rol=2 and estado=1', [':equipo_id' => $invitacion->equipo_id, ':estudiante_id' => $invitacion->estudiante_invitado_id])
                    ->one();
            if (!$validarIntegrante) {

                $integrante = new Integrante;
                $integrante->equipo_id = $invitacion->equipo_id;
                $integrante->estudiante_id = $invitacion->estudiante_invitado_id;
                $integrante->rol = 2;
                $integrante->estado = 1;
                $integrante->save();
            }
            echo $equipo->descripcion_equipo;
        }
    }

    public function actionRechazar() {

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }

        if (isset($_POST["id"]) && $_POST["id"] != "") {
            $id = $_POST["id"];
            $invitacion = Invitacion::findOne($id);


            $lider = Usuario::findOne(\Yii::$app->user->id);

            if ($invitacion->estudiante_invitado_id != $lider->estudiante_id) {
                exit;
            }

            $invitacion->estado = 0;
            $invitacion->fecha_rechazo = date("Y-m-d H:i:s");
            $invitacion->update();
            $equipo = Equipo::find()->where('id=:id', [':id' => $invitacion->equipo_id])->one();
            echo $equipo->descripcion_equipo;
        }
    }

    public function actionDejarequipo() {

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }

        if (isset($_POST["id"]) && $_POST["id"] != "") {
            $id = $_POST["id"];

            $usuario = Usuario::findOne(\Yii::$app->user->id);
            $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();




            $lider = Integrante::find()->where('estudiante_id=:estudiante_id and rol=1', [':estudiante_id' => $id])->one();


            if ($lider) {
                //Integrante::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$lider->equipo_id])->one()->deleteAll();

                if ($lider->estudiante_id == $estudiante->id) {
                    Invitacion::updateAll(['estado' => 0], 'equipo_id=:equipo_id', [':equipo_id' => $lider->equipo_id]);

                    Integrante::deleteAll('equipo_id=:equipo_id', [':equipo_id' => $lider->equipo_id]);

                    Equipo::find()->where('id=:id', [':id' => $lider->equipo_id])->one()->delete();
                }
            } else {

                if ($id == $estudiante->id) {
                    Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $id])->one()->delete();
                    Invitacion::updateAll(['estado' => 0], 'estudiante_invitado_id=:estudiante_invitado_id', [':estudiante_invitado_id' => $id]);
                }
            }
            echo 1;
        }
    }

    public function actionValidarintegrante($id) {
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $id])->one();
        if ($integrante) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function actionEliminarinvitado() {
        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }



        if (isset($_POST["id"]) && $_POST["id"] != "" && isset($_POST["equipo"]) && $_POST["equipo"] != "") {
            $id = $_POST["id"];

            $equipo = $_POST["equipo"];
            $integrante = Integrante::find()->where('estudiante_id=:estudiante_id and equipo_id=:equipo_id', [':estudiante_id' => $id, ':equipo_id' => $equipo])->one();
            if ($integrante) {
                Integrante::find()->where('estudiante_id=:estudiante_id and equipo_id=:equipo_id', [':estudiante_id' => $id, ':equipo_id' => $equipo])->one()->delete();
                echo 1;
            } else {
                $invitacion = Invitacion::find()
                                ->where('estudiante_invitado_id=:estudiante_invitado_id and estado=1 and equipo_id=:equipo_id', [':estudiante_invitado_id' => $id, ':equipo_id' => $equipo])->one();
                if ($invitacion) {
                    $invitacion->estado = 0;
                    $invitacion->fecha_rechazo = date("Y-m-d H:i:s");
                    $invitacion->update();
                }
                echo 0;
            }
        }
    }

    public function actionEliminarintegrante() {

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }

        if (isset($_POST["id"]) && $_POST["id"] != "") {
            $id = $_POST["id"];
            $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $id])->one();
            if ($integrante) {
                $integrante->delete();

                Invitacion::updateAll(['estado' => 0], 'estudiante_invitado_id=:estudiante_invitado_id and estado=2', [':estudiante_invitado_id' => $id]);
                echo 1;
            } else {
                echo 2;
            }
        }
    }

    public function actionValidarunirme() {
        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }

        if (isset($_POST["id"]) && $_POST["id"] != "") {
            $id = $_POST["id"];
            $invitacion = Invitacion::find()->where('id=:id and estado=1', [':id' => $id])->one();

            if ($invitacion) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    public function actionValidarequipo() {

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }

        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $id])->one();

            if (!$integrante) {
                echo 1;
            }

            if ($integrante && $integrante->estado == 1) {
                echo 2;
            } elseif ($integrante && $integrante->estado == 2) {
                echo 3;
            }
        }
    }

    public function actionFinalizarequipo() {
        if (empty($_SERVER['HTTP_REFERER'])) {

            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {

                exit;
            }
        }


        $estudiante_id_reportero = $_POST["id"];
        $lider = Usuario::findOne(\Yii::$app->user->id);

        $lider_integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $lider->estudiante_id])->one();
        // $integrante_reportero = Integrante::find()->where('estudiante_id=:estudiante_id and equipo_id:equipo_id', [':estudiante_id' => $estudiante_id_reportero],[':equipo_id' => $lider_integrante->equipo_id])->one();
        $integrante_reportero = Integrante::find()->where('estudiante_id=:estudiante_id and equipo_id=:equipo_id', [ ':estudiante_id' => $estudiante_id_reportero, ':equipo_id' => $lider_integrante->equipo_id])->one();

        if ($lider_integrante->rol != 1) {

            echo 3;
            exit;
        }


        if (!$integrante_reportero || $integrante_reportero->rol != 2) {

            echo 3;
            exit;
        } if (isset($_POST["id"]) && $_POST["id"] != "") {
            $id = $lider_integrante->equipo_id;

            /* if($id != $_POST["id"]){
              echo $_POST["id"]."<br>";
              echo $id;
              exit;
              }
             */

            $integrante_reportero->reportero = "1";
            $integrante_reportero->update();


            $integrantesEstudiantes = Integrante::find()
                            ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                            ->where('integrante.equipo_id=:equipo_id and estudiante.grado!=6', [':equipo_id' => $id])->count();
            $integrantesDocentes = Integrante::find()
                            ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                            ->where('integrante.equipo_id=:equipo_id and estudiante.grado=6', [':equipo_id' => $id])->count();
            if ($integrantesEstudiantes >= 4 && $integrantesEstudiantes <= 6 && $integrantesDocentes == 1) {
                $equipo = Equipo::findOne($id);
                if ($equipo->foto == "") {
                    $equipo->foto = "no_disponible.png";
                }

                $equipo->estado = 1;
                $equipo->etapa = 0;
                $equipo->update();

                Integrante::updateAll([ 'estado' => 2], 'estado = 1 and equipo_id=:equipo_id', [ ':equipo_id' => $id]);

                Invitacion::updateAll(['estado' => 0,
                    'fecha_rechazo' => date("Y-m-d H:i:s")], 'estado = 1 and equipo_id=:equipo_id', [':equipo_id' => $id]);

                echo 1;
            } elseif ($integrantesEstudiantes < 4) {
                echo 2;
            } elseif ($integrantesEstudiantes > 6) {
                echo 4;
            } elseif ($integrantesDocentes < 1) {
                echo 3;
            } elseif ($integrantesDocentes > 1) {
                echo 5;
            }
        }
    }

    public function actionFinalizarequipovalidar($id) {
        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }



        $lider = Usuario::findOne(\Yii::$app->user->id);

        $lider_integrante = Integrante::find()->where('estudiante_id=:estudiante_id  and rol=1', [':estudiante_id' => $lider->estudiante_id])->one();
        if (empty($lider_integrante)) {
            exit;
        } else {
            $equipo = Equipo::find()->where('id=:id', [':id' => $lider_integrante->equipo_id])->one();
            if ($equipo->estado == 0) {
                $id = $lider_integrante->equipo_id;
            }else{
                exit;
            }
        }




        $bandera = 0;
        $integrantesEstudiantes = Integrante::find()
                        ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                        ->where('integrante.equipo_id=:equipo_id and estudiante.grado!=6', [':equipo_id' => $id])->count();

        $integrantesDocentes = Integrante::find()
                        ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                        ->where('integrante.equipo_id=:equipo_id and estudiante.grado=6', [':equipo_id' => $id])->count();

        if ($integrantesEstudiantes >= 4 && $integrantesDocentes == 1) {

            $bandera = 1;
        } elseif ($integrantesEstudiantes < 4 && $integrantesDocentes < 1) {
            $bandera = 4;
        } elseif ($integrantesEstudiantes < 4) {
            $bandera = 2;
        } elseif ($integrantesDocentes < 1) {
            $bandera = 3;
        }

        echo $bandera;
    }

    public function actionValidarintegrante2() {
        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }


        $datos[] = [ "bandera" => 0];
        if (isset($_REQUEST['Invitacion'])) {
            foreach ($_REQUEST['Invitacion'] as $invitados => $key) {

                $integrante = Integrante::find()
                                ->select('estudiante.nombres_apellidos')
                                ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                                ->where('estudiante_id=:estudiante_id', [':estudiante_id' => (integer) $key])->one();
                if ($integrante) {
                    $datos[
                            ] = ["bandera" => 1, "nombres_apellidos" => $integrante->nombres_apellidos];
                }
            }
        }
        echo json_encode($datos);
    }

    public function actionValidarinvitacioneintegrante($estudiante, $equipo) {
        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }


        $lider = Usuario::findOne(\Yii::$app->user->id);

        $lider_integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $lider->estudiante_id])->one();

        if ($lider_integrante && $equipo == 0) {
            $equipo = $lider_integrante->equipo_id;
        }

        $integrante = Integrante::find()
                ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                ->where('integrante.estudiante_id=:estudiante_id and estudiante.grado!=6', [':estudiante_id' => $estudiante])
                ->one();

        $invitacion = Invitacion::find()
                        ->innerJoin('estudiante', 'estudiante.id=invitacion.estudiante_id')
                        ->where('invitacion.estudiante_invitado_id=:estudiante_invitado_id and
                            invitacion.estado=1 and invitacion.equipo_id=:equipo_id and estudiante.grado!=6', [ ':estudiante_invitado_id' => (integer) $estudiante, ':equipo_id' => (integer) $equipo])->one();

        $invitacionContador = Invitacion::find()
                        ->innerJoin('estudiante', 'estudiante.id=invitacion.estudiante_invitado_id')
                        ->where('invitacion.estado=1 and invitacion.equipo_id=:equipo_id and estudiante.grado!=6', [':equipo_id' => (integer) $equipo])->count();

        $integranteContador = Integrante::find()
                        ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_invitado_id')
                        ->where('integrante.equipo_id=:equipo_id and estudiante.grado!=6', [':equipo_id' => (integer) $equipo])->count();

        $invitacionContador = $invitacionContador + $integranteContador;
        $bandera = 0;
        if ($integrante) {
            $bandera = 1;
        }

        if ($invitacion) {
            $bandera = 2;
        }
        if ($invitacionContador >= 6) {
            $bandera = 3;
        }

        echo $bandera;
    }

    public function actionValidarinvitacioneintegrantedocente($docente, $equipo) {

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }

        $lider = Usuario::findOne(\Yii::$app->user->id);

        $lider_integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $lider->estudiante_id])->one();

        if ($lider_integrante && $equipo == 0) {
            $equipo = $lider_integrante->equipo_id;
        }

        $integrante = Integrante::find()
                ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                ->where('integrante.estudiante_id=:estudiante_id and estudiante.grado=6', [':estudiante_id' => $docente])
                ->one();
        $invitacion = Invitacion::find()
                        ->innerJoin('estudiante', 'estudiante.id=invitacion.estudiante_id')
                        ->where('invitacion.estudiante_invitado_id=:estudiante_invitado_id and
                            invitacion.estado=1 and invitacion.equipo_id=:equipo_id and estudiante.grado=6', [ ':estudiante_invitado_id' => (integer) $docente, ':equipo_id' => (integer) $equipo])->one();

        $invitacionContador = Invitacion::find()
                        ->innerJoin('estudiante', 'estudiante.id=invitacion.estudiante_id')
                        ->where('invitacion.estado=1 and equipo_id=:equipo_id and estudiante.grado=6', [':equipo_id' => (integer) $equipo])->count();

        $integranteContador = Integrante::find()
                        ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                        ->where('integrante.equipo_id=:equipo_id and estudiante.grado=6', [':equipo_id' => (integer) $equipo])->count();

        $invitacionContador = $invitacionContador + $integranteContador;
        $bandera = 0;
        if ($integrante) {
            $bandera = 1;
        }

        if ($invitacion) {
            $bandera = 2;
        }
        if ($invitacionContador >= 1) {
            $bandera = 3;
        }

        echo $bandera;
    }

    public function actionValidarinvitacioneintegrante2() {

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }


        $error = "";
        $bandera = 0;
        $equipo = new Equipo;
        $equipo->load(Yii::$app->request->post());
        $countEstudiantes = count($equipo->invitaciones);
        //var_dump($countEstudiantes);
        for ($i = 0; $i < $countEstudiantes; $i++) {
            $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $equipo->invitaciones[$i]])->one();

            $invitacion = Invitacion::find()->where('estudiante_invitado_id=:estudiante_invitado_id and estado=1 and equipo_id=:equipo_id ', [':estudiante_invitado_id' => $equipo->invitaciones[$i], ':equipo_id' => $equipo->id])->one();
            //var_dump($equipo->invitaciones[$i]);die;
            if ($integrante) {
                $bandera = 1;
                $error = $integrante->estudiante->nombres_apellidos . " ya pertenece a un equipo <br>" . $error;
            }

            if ($invitacion) {
                $error = $invitacion->estudianteInvitado->nombres_apellidos .
                        " ya ha recibido una invitación tuya <br>" . $error;
                $bandera = 1;
            }
        }

        $datos[] = [ "bandera" => 0];



        //var_dump($equipo->tipo);die;
        if ($equipo->tipo == 1 && $bandera == 1) {
            $datos[] = ["bandera" => 1, "error" => $error];
        }
        if ($equipo->tipo == 2) {
            echo $error;
        }
        echo json_encode($datos);
    }

    public function actionExisteequipo() {

        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }

        $bandera = 0;
        $lider = Usuario::findOne(\Yii::$app->user->id);
        $lider_integrante = Integrante::find()->where('estudiante_id=:estudiante_id and rol=1', [':estudiante_id' =>
                    $lider->estudiante_id])->one();


        if (empty($lider_integrante)) {

            echo $bandera;
            exit;
        }
        $equipo = Equipo::findOne($lider_integrante->equipo_id);

        if ($equipo) {
            $bandera = 1;
        }
        echo $bandera;
    }

    public function actionValidarinvitacioneintegrante5($equipo) {
        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }




        $bandera = 0;
        $invitacionContador = Invitacion::find()
                        ->innerJoin('estudiante', 'estudiante.id=invitacion.estudiante_id')
                        ->where('estado=1 and equipo_id=:equipo_id  and estudiante.grado!=6', [':equipo_id' => (integer) $equipo])->count();

        $integranteContador = Integrante::find()
                        ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                        ->where('equipo_id=:equipo_id  and estudiante.grado!=6', [':equipo_id' => (integer) $equipo])->count();
        $invitacionContador = $invitacionContador + $integranteContador;

        $invitacionContadorDocente = Invitacion::find()
                        ->innerJoin('estudiante', 'estudiante.id=invitacion.estudiante_id')
                        ->where('estado=1 and equipo_id=:equipo_id  and estudiante.grado=6', [':equipo_id' => (integer) $equipo])->count();

        $integranteContadorDocente = Integrante::find()
                        ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                        ->where('equipo_id=:equipo_id  and estudiante.grado=6', [':equipo_id'
                            => (integer) $equipo])->count();
        $invitacionContadorDocente = $invitacionContadorDocente + $integranteContadorDocente;

        if ($invitacionContador == 6 && $invitacionContadorDocente == 1) {
            $bandera = 1;
        }

        echo $bandera;
    }

    public function actionValidarparafinalizar($id) {
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
        $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id and rol=1', [':estudiante_id' => $estudiante->id])->one();


        //$integranteContador=Integrante::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$id])->count();
        $invitacionContador = Invitacion::find()->where('estado=1 and equipo_id=:equipo_id ', [

                    ':equipo_id' => $integrante->equipo_id])->count();
        if ($invitacionContador > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function actionTextoasunto($asunto_id) {
        //$asunto = Asunto::findOne($asunto_id);
        // $connectionx = Yii::$app->dbperueduca;
        
        if (empty($_SERVER['HTTP_REFERER'])) {
            exit;
        } else {
            $parts = parse_url($_SERVER['HTTP_REFERER']);

            //print_r($parts);
            if ($parts["host"] != Yii::$app->params["host"]) {
                exit;
            }
        }
        $asuntos = Asunto::find()->where('categoria_id=:categoria_id', [':categoria_id' => $asunto_id])->all();
        $dataTabla = [];
        foreach ($asuntos as $asunto) {

            array_push($dataTabla, ['id' => $asunto->id, 'descripcion_corta' => $asunto->descripcion_cabecera]);
        }

        //echo print_r(Yii::$app->params["host"]);
        //print_r( $_SERVER['HTTP_REFERER']); 
        echo json_encode($dataTabla, JSON_UNESCAPED_UNICODE);
        //echo $asunto;
    }

    public function actionFinalizarEquipo2() {
        $this->layout = 'administrador';
        $model = new Equipo;
        $mensaje = "";
        if ($model->load(Yii::$app->request->post())) {
            //var_dump();die;
            $lider = Estudiante::find()->where('email=:email', [':email' => $model->email])->one();
            $integrante = Integrante::find()->where('estudiante_id=:estudiante_id and rol=1', [':estudiante_id' => $lider->id])->one();
            if ($integrante->estado == 1) {
                $id = $integrante->equipo_id;
                $integrantesEstudiantes = Integrante::find()
                                ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                                ->where('integrante.equipo_id=:equipo_id and estudiante.grado!=6', [':equipo_id' => $id])->count();
                $integrantesDocentes = Integrante::find()
                                ->innerJoin('estudiante', 'estudiante.id=integrante.estudiante_id')
                                ->where('integrante.equipo_id=:equipo_id and estudiante.grado=6', [':equipo_id' => $id])->count();
                if ($integrantesEstudiantes >= 4 && $integrantesDocentes == 1) {
                    $equipo = Equipo::findOne($id);
                    if ($equipo->foto = "") {
                        $equipo->foto = "no_disponible.png";
                    }

                    $equipo->estado = 1;
                    $equipo->etapa = 0;
                    $equipo->update();

                    Integrante::updateAll([ 'estado' => 2], 'estado = 1 and equipo_id=:equipo_id', [ ':equipo_id' => $id]);

                    Invitacion::updateAll(['estado' => 0, 'fecha_rechazo' => date("Y-m-d H:i:s")], 'estado = 1 and equipo_id=:equipo_id', [':equipo_id' => $id]);

                    $mensaje = "Finalizado correctamente";
                } elseif ($integrantesEstudiantes < 4) {
                    $mensaje = "Muy poco integrantes";
                } elseif ($integrantesDocentes < 1) {
                    $mensaje = "Le falta docente";
                }
            } elseif ($integrante->estado == 2) {
                $mensaje = "Su equipo ya ha sido finalizado";
            }
        }

        return $this->render('finalizar-equipo2', ['model' => $model, 'mensaje' => $mensaje]);
    }

}
