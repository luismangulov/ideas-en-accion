<?php

namespace app\controllers;

use Yii;
use app\models\Foro;
use app\models\Proyecto;
use app\models\ForoComentario;
use app\models\ForoComentarioSearch;
use app\models\Usuario;
use app\models\Estudiante;
use app\models\Institucion;
use app\models\Ubigeo;
use app\models\Integrante;
use app\models\Equipo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\HtmlPurifier;

/**
 * ForoComentarioController implements the CRUD actions for ForoComentario model.
 */
class ForoComentarioController extends Controller {

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
     * Lists all ForoComentario models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ForoComentarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ForoComentario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ForoComentario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ForoComentario();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ForoComentario model.
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
     * Deletes an existing ForoComentario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ForoComentario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ForoComentario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ForoComentario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionVisible() {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $ForoComentario = ForoComentario::findOne($id);
            if ($ForoComentario->estado == 1) {
                $ForoComentario->estado = 0;
            } else {
                $ForoComentario->estado = 1;
            }
            $ForoComentario->update();
            echo $ForoComentario->estado;
        } else {
            $this->redirect(['site/resultados']);
        }
    }

    public function actionComentario() {

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

        if (isset($_POST["id"]) && isset($_POST["seccion"])) {

            $data = "";
            $id = $_POST["id"];
            $seccion = $_POST["seccion"];
            //var_dump($id);die;
            $model = Foro::findOne($id);

            $posts = $model->getForo1Entrega($id, $seccion);
            $data = $data . '<section class="posts">';
            if (!empty($model->proyecto_id)) {
                $usuarioX = Usuario::findOne(\Yii::$app->user->id);
                $estudianteX = Estudiante::find()->where('id=:id', [':id' => $usuarioX->estudiante_id])->one();
                $integranteX = Integrante::find()->where('estudiante_id=:estudiante_id ', [':estudiante_id' => $estudianteX->id])->one();

                $proyectoX = Proyecto::findOne($model->proyecto_id);
                if ($integranteX->equipo_id == $proyectoX->equipo_id) {
                    $connectionx = Yii::$app->db;

                    $commandx = $connectionx->createCommand("update foro_comentario set leido='1' where   foro_id='" . $model->id . "' and seccion='" . $seccion . "'");

                    $rowx = $commandx->execute();
                }
            }




            foreach ($posts['posts'] as $post):

                $data = $data . '<div class="row post-item">';
                $data = $data . '<div class="col-sm-12 col-md-12">';
                if ($post['user_id'] >= 2 and $post['user_id'] <= 8) {
                    $data = $data . '<div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #4EB3C7">';
                    $data = $data . ' ' . HtmlPurifier::process($post['contenido']);
                    $data = $data . '<div class="post-meta">';
                    $data = $data . '<div class="col-sm-12 col-md-12"></div>';
                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '<div class="col-sm-12 col-md-12" style="padding-left:0px">';
                    $data = $data . '<div class="pull-left">';
                    $data = $data . '<span style="cursor: pointer" onclick="Responder(' . $post['id'] . ')">Responder</span>';
                    $data = $data . '</div>';
                    $data = $data . '<div class="pull-right">';
                    $data = $data . '<div class="col-sm-12 col-md-12">';
                    $data = $data . ' ' . $post['nombres'] . ' ' . zdateRelative($post['creado_at']);
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '</div>';
                } else {
                    $data = $data . '<div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1">';
                    $data = $data . HtmlPurifier::process($post['contenido']);
                    $data = $data . '<div class="post-meta">';
                    $data = $data . '<div class="col-sm-12 col-md-12"></div>';
                    $data = $data . '<div class="col-sm-12 col-md-12">';
                    $data = $data . '<div class="br-wrapper br-theme-fontawesome-stars pull-right">';
                    $data = $data . '<select class="disabled" disabled>';
                    $data = $data . '<option value></option>';
                    $data = $data . '<option value="1" ';
                    if ($post["valoracion"] == 1) {
                        $data = $data . "selected";
                    } else {
                        $data = $data . "";
                    } $data = $data . ' >1</option>';
                    $data = $data . '<option value="2" ';
                    if ($post["valoracion"] == 2) {
                        $data = $data . "selected";
                    } else {
                        $data = $data . "";
                    } $data = $data . ' >2</option>';
                    $data = $data . '<option value="3" ';
                    if ($post["valoracion"] == 3) {
                        $data = $data . "selected";
                    } else {
                        $data = $data . "";
                    } $data = $data . ' >3</option>';
                    $data = $data . '<option value="4" ';
                    if ($post["valoracion"] == 4) {
                        $data = $data . "selected";
                    } else {
                        $data = $data . "";
                    } $data = $data . ' >4</option>';
                    $data = $data . '<option value="5" ';
                    if ($post["valoracion"] == 5) {
                        $data = $data . "selected";
                    } else {
                        $data = $data . "";
                    } $data = $data . ' >5</option>';
                    $data = $data . '</select>';
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '<div class="col-sm-12 col-md-12" style="padding-left:0px">';
                    $data = $data . '<div class="pull-left">';
                    $data = $data . '<span style="cursor: pointer" onclick="Responder(' . $post['id'] . ')">Responder</span>';
                    $data = $data . '</div>';

                    $data = $data . '<div class="pull-right">';
                    $data = $data . 'Comentario de <span class="popover1" data-type="html" style="cursor: pointer"  data-title="Información" data-content="Región: ' . $post['department'] . ' <br> II.EE: ' . $post['denominacion'] . '" data-placement="top" >' . $post['nombres'] . ' ' . $post['apellido_paterno'] . '</span> ' . zdateRelative($post['creado_at']);
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '</div>';
                }
                $data = $data . '</div>';
                $data = $data . '</div>';
                $data = $data . '<div class="clearfix"></div>';

                $data = $data . '<div class="row post-item">';
                $data = $data . '<div class="col-sm-1 col-md-1">';
                $data = $data . '</div>';
                $data = $data . '<div class="col-sm-11 col-md-11">';
                $data = $data . '<div id="hijo_' . $post['id'] . '"></div>';
                $data = $data . '</div>';
                $data = $data . '</div>';
                $data = $data . '<div class="clearfix"></div>';
                $hijos = ForoComentario::find()
                                ->where('foro_comentario_hijo_id=:foro_comentario_hijo_id order by id desc', [':foro_comentario_hijo_id' => $post['id']])->all();


                foreach ($hijos as $hijo) {
                    $data = $data . '<div class="row post-item">';

                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '<div class="col-sm-1 col-md-1">';
                    $data = $data . '</div>';
                    $data = $data . '<div class="col-sm-11 col-md-11">';
                    $data = $data . '<div class="row post-item">';
                    $data = $data . '<div class="col-sm-12 col-md-12">';
                    if ($hijo->user_id >= 2 and $hijo->user_id <= 8) {
                        $data = $data . '<div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #4EB3C7">';
                        $data = $data . ' ' . HtmlPurifier::process($hijo->contenido);
                        $data = $data . '<div class="post-meta">';
                        $data = $data . '<div class="col-sm-12 col-md-12"></div>';
                        $data = $data . '<div class="clearfix"></div>';
                        $data = $data . '<div class="col-sm-12 col-md-12">';
                        $data = $data . '<div class="pull-right">';
                        $data = $data . '<div class="col-sm-12 col-md-12">';
                        $data = $data . ' Comentario de Monitor  ' . zdateRelative($hijo->creado_at);
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                        $data = $data . '<div class="clearfix"></div>';
                        $data = $data . '</div>';
                    } else {
                        $usuario = Usuario::findOne($hijo->user_id);
                        $estudiante = Estudiante::findOne($usuario->estudiante_id);
                        $institucion = Institucion::findOne($estudiante->institucion_id);
                        $ubigeo = Ubigeo::find()->where('district_id=:district_id', [':district_id' => $institucion->ubigeo_id])->one();
                        $data = $data . '<div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1">';
                        $data = $data . HtmlPurifier::process($hijo->contenido);
                        $data = $data . '<div class="post-meta">';
                        $data = $data . '<div class="col-sm-12 col-md-12"></div>';
                        $data = $data . '<div class="col-sm-12 col-md-12">';
                        $data = $data . '<div class="br-wrapper br-theme-fontawesome-stars pull-right">';
                        $data = $data . '<select class="disabled" disabled>';
                        $data = $data . '<option value></option>';
                        $data = $data . '<option value="1" ';
                        if ($hijo->valoracion == 1) {
                            $data = $data . "selected";
                        } else {
                            $data = $data . "";
                        } $data = $data . ' >1</option>';
                        $data = $data . '<option value="2" ';
                        if ($hijo->valoracion == 2) {
                            $data = $data . "selected";
                        } else {
                            $data = $data . "";
                        } $data = $data . ' >2</option>';
                        $data = $data . '<option value="3" ';
                        if ($hijo->valoracion == 3) {
                            $data = $data . "selected";
                        } else {
                            $data = $data . "";
                        } $data = $data . ' >3</option>';
                        $data = $data . '<option value="4" ';
                        if ($hijo->valoracion == 4) {
                            $data = $data . "selected";
                        } else {
                            $data = $data . "";
                        } $data = $data . ' >4</option>';
                        $data = $data . '<option value="5" ';
                        if ($hijo->valoracion == 5) {
                            $data = $data . "selected";
                        } else {
                            $data = $data . "";
                        } $data = $data . ' >5</option>';
                        $data = $data . '</select>';
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                        $data = $data . '<div class="clearfix"></div>';
                        $data = $data . '<div class="col-sm-12 col-md-12" style="padding-left:0px">';
                        $data = $data . '<div class="pull-left">';
                        //$data=$data.'<span style="cursor: pointer" onclick="Responder('.$hijo->id.')">Responder</span>';
                        $data = $data . '</div>';

                        $data = $data . '<div class="pull-right">';
                        $data = $data . 'Comentario de <span class="popover1"  data-type="html" style="cursor: pointer"  data-title="Información" data-content="Región: ' . $ubigeo->department . ' <br> II.EE: ' . $institucion->denominacion . '" data-placement="top" >' . $hijo->usuario->estudiante->nombres . ' ' . $hijo->usuario->estudiante->apellido_paterno . '</span> ' . zdateRelative($hijo->creado_at);
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                        $data = $data . '<div class="clearfix"></div>';
                        $data = $data . '</div>';
                    }
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '</div>';
                    $data = $data . '<div class="clearfix"></div>';

                    $data = $data . '</div>';
                }
                //$data=$data.$post['contenido'];
            endforeach;
            $data = $data . '</section>';
            echo $data;
        }
    }

    public function actionComentarioMonitor() {

        if (isset($_POST["id"]) && isset($_POST["seccion"])) {

            $data = "";
            $id = $_POST["id"];
            $seccion = $_POST["seccion"];
            //var_dump($id);die;
            $model = Foro::findOne($id);
            $posts = $model->getForo1Entrega($id, $seccion);
            $data = $data . '<section class="posts">';
            foreach ($posts['posts'] as $post):

                $data = $data . '<div class="row post-item">';
                $data = $data . '<div class="col-sm-12 col-md-12">';
                if ($post['user_id'] >= 2 and $post['user_id'] <= 8) {
                    $data = $data . '<div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #4EB3C7">';
                    $data = $data . ' ' . HtmlPurifier::process($post['contenido']);
                    $data = $data . '<div class="post-meta">';
                    $data = $data . '<div class="col-sm-12 col-md-12"></div>';
                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '<div class="col-sm-12 col-md-12" style="padding-left:0px">';
                    $data = $data . '<div class="pull-left">';
                    $data = $data . '<span style="cursor: pointer" onclick="Responder(' . $post['id'] . ')">Responder</span>';
                    $data = $data . '</div>';
                    $data = $data . '<div class="pull-right">';
                    $data = $data . '<div class="col-sm-12 col-md-12">';
                    $data = $data . ' ' . $post['nombres'] . ' ' . zdateRelative($post['creado_at']);
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '</div>';
                } else {
                    $usuario = Usuario::findOne($post['user_id']);
                    $estudiante = Estudiante::findOne($usuario->estudiante_id);
                    $institucion = Institucion::findOne($estudiante->institucion_id);
                    $ubigeo = Ubigeo::find()->where('district_id=:district_id', [':district_id' => $institucion->ubigeo_id])->one();


                    $data = $data . '<div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1">';
                    $data = $data . HtmlPurifier::process($post['contenido']);
                    $data = $data . '<div class="post-meta">';
                    if ($post['valoracion'] != 0 && $post['valoracion'] != '') {
                        $data = $data . '<div class="col-sm-12 col-md-12"></div>';
                        $data = $data . '<div class="col-sm-12 col-md-12">';
                        $data = $data . '<div class="br-wrapper br-theme-fontawesome-stars pull-right">';
                        $data = $data . '<select class="disabled" disabled>';
                        $data = $data . '<option value></option>';
                        $data = $data . '<option value="1" ';
                        if ($post["valoracion"] == 1) {
                            $data = $data . "selected";
                        } else {
                            $data = $data . "";
                        } $data = $data . ' >1</option>';
                        $data = $data . '<option value="2" ';
                        if ($post["valoracion"] == 2) {
                            $data = $data . "selected";
                        } else {
                            $data = $data . "";
                        } $data = $data . ' >2</option>';
                        $data = $data . '<option value="3" ';
                        if ($post["valoracion"] == 3) {
                            $data = $data . "selected";
                        } else {
                            $data = $data . "";
                        } $data = $data . ' >3</option>';
                        $data = $data . '<option value="4" ';
                        if ($post["valoracion"] == 4) {
                            $data = $data . "selected";
                        } else {
                            $data = $data . "";
                        } $data = $data . ' >4</option>';
                        $data = $data . '<option value="5" ';
                        if ($post["valoracion"] == 5) {
                            $data = $data . "selected";
                        } else {
                            $data = $data . "";
                        } $data = $data . ' >5</option>';
                        $data = $data . '</select>';
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                    } else {
                        if ($post['user_id'] >= 2 and $post['user_id'] <= 8) {
                            $data = $data . '<div class="col-sm-12 col-md-12">';
                            $data = $data . '</div>';
                        } else {
                            $data = $data . '<div class="col-sm-12 col-md-12">';
                            $data = $data . '<div class="br-wrapper br-theme-fontawesome-stars pull-right">';
                            $data = $data . '<select class="enable" onchange="Rating($(this).val(),' . $post['id'] . ')">';
                            $data = $data . '<option value></option>';
                            $data = $data . '<option value="1" ';
                            if ($post["valoracion"] == 1) {
                                $data = $data . "selected";
                            } else {
                                $data = $data . "";
                            } $data = $data . ' >1</option>';
                            $data = $data . '<option value="2" ';
                            if ($post["valoracion"] == 2) {
                                $data = $data . "selected";
                            } else {
                                $data = $data . "";
                            } $data = $data . ' >2</option>';
                            $data = $data . '<option value="3" ';
                            if ($post["valoracion"] == 3) {
                                $data = $data . "selected";
                            } else {
                                $data = $data . "";
                            } $data = $data . ' >3</option>';
                            $data = $data . '<option value="4" ';
                            if ($post["valoracion"] == 4) {
                                $data = $data . "selected";
                            } else {
                                $data = $data . "";
                            } $data = $data . ' >4</option>';
                            $data = $data . '<option value="5" ';
                            if ($post["valoracion"] == 5) {
                                $data = $data . "selected";
                            } else {
                                $data = $data . "";
                            } $data = $data . ' >5</option>';
                            $data = $data . '</select>';
                            $data = $data . '</div>';
                            $data = $data . '</div>';
                        }
                    }
                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '<div class="col-sm-12 col-md-12" style="padding-left:0px">';
                    $data = $data . '<div class="pull-left">';
                    $data = $data . '<span style="cursor: pointer" onclick="Responder(' . $post['id'] . ')">Responder</span>';
                    $data = $data . '</div>';

                    $data = $data . '<div class="pull-right">';
                    $data = $data . 'Comentario de <span class="popover1"  data-type="html" style="cursor: pointer"  data-title="Información" data-content="Región: ' . $ubigeo->department . ' <br> II.EE: ' . $institucion->denominacion . '" data-placement="top" >' . $post['nombres'] . ' ' . $post['apellido_paterno'] . '</span> ' . zdateRelative($post['creado_at']);

                    //$data=$data.'Comentario de '.$post['nombres'].' '.$post['apellido_paterno'] .' '. Yii::$app->formatter->asRelativeTime($post['creado_at']);
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '</div>';
                }
                $data = $data . '</div>';
                $data = $data . '</div>';
                $data = $data . '<div class="clearfix"></div>';

                $data = $data . '<div class="row post-item">';
                $data = $data . '<div class="col-sm-1 col-md-1">';
                $data = $data . '</div>';
                $data = $data . '<div class="col-sm-11 col-md-11">';
                $data = $data . '<div id="hijo_' . $post['id'] . '"></div>';
                $data = $data . '</div>';
                $data = $data . '</div>';
                $data = $data . '<div class="clearfix"></div>';
                $hijos = ForoComentario::find()
                                ->where('foro_comentario_hijo_id=:foro_comentario_hijo_id', [':foro_comentario_hijo_id' => $post['id']])->all();
                foreach ($hijos as $hijo) {
                    $data = $data . '<div class="row post-item">';

                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '<div class="col-sm-1 col-md-1">';
                    $data = $data . '</div>';
                    $data = $data . '<div class="col-sm-11 col-md-11">';
                    $data = $data . '<div class="row post-item">';
                    $data = $data . '<div class="col-sm-12 col-md-12">';
                    if ($hijo->user_id >= 2 and $hijo->user_id <= 8) {
                        $data = $data . '<div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #4EB3C7">';
                        $data = $data . ' ' . HtmlPurifier::process($hijo->contenido);
                        $data = $data . '<div class="post-meta">';
                        $data = $data . '<div class="col-sm-12 col-md-12"></div>';
                        $data = $data . '<div class="clearfix"></div>';
                        $data = $data . '<div class="col-sm-12 col-md-12">';
                        $data = $data . '<div class="pull-right">';
                        $data = $data . '<div class="col-sm-12 col-md-12">';
                        $data = $data . 'Comentario Monitor ' . zdateRelative($hijo->creado_at);
                        //$data=$data.' '.$hijo->usuario->estudiante->nombres.' '.Yii::$app->formatter->asRelativeTime($hijo->creado_at);
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                        $data = $data . '<div class="clearfix"></div>';
                        $data = $data . '</div>';
                    } else {

                        $usuario = Usuario::findOne($hijo->user_id);
                        $estudiante = Estudiante::findOne($usuario->estudiante_id);
                        $institucion = Institucion::findOne($estudiante->institucion_id);
                        $ubigeo = Ubigeo::find()->where('district_id=:district_id', [':district_id' => $institucion->ubigeo_id])->one();

                        $data = $data . '<div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1">';
                        $data = $data . HtmlPurifier::process($hijo->contenido);
                        $data = $data . '<div class="post-meta">';
                        if ($hijo->valoracion != 0 && $hijo->valoracion != '') {
                            $data = $data . '<div class="col-sm-12 col-md-12"></div>';
                            $data = $data . '<div class="col-sm-12 col-md-12">';
                            $data = $data . '<div class="br-wrapper br-theme-fontawesome-stars pull-right">';
                            $data = $data . '<select class="disabled" disabled>';
                            $data = $data . '<option value></option>';
                            $data = $data . '<option value="1" ';
                            if ($hijo->valoracion == 1) {
                                $data = $data . "selected";
                            } else {
                                $data = $data . "";
                            } $data = $data . ' >1</option>';
                            $data = $data . '<option value="2" ';
                            if ($hijo->valoracion == 2) {
                                $data = $data . "selected";
                            } else {
                                $data = $data . "";
                            } $data = $data . ' >2</option>';
                            $data = $data . '<option value="3" ';
                            if ($hijo->valoracion == 3) {
                                $data = $data . "selected";
                            } else {
                                $data = $data . "";
                            } $data = $data . ' >3</option>';
                            $data = $data . '<option value="4" ';
                            if ($hijo->valoracion == 4) {
                                $data = $data . "selected";
                            } else {
                                $data = $data . "";
                            } $data = $data . ' >4</option>';
                            $data = $data . '<option value="5" ';
                            if ($hijo->valoracion == 5) {
                                $data = $data . "selected";
                            } else {
                                $data = $data . "";
                            } $data = $data . ' >5</option>';
                            $data = $data . '</select>';
                            $data = $data . '</div>';
                            $data = $data . '</div>';
                        } else {
                            if ($hijo->user_id >= 2 and $hijo->user_id <= 8) {
                                $data = $data . '<div class="col-sm-12 col-md-12">';
                                $data = $data . '</div>';
                            } else {
                                $data = $data . '<div class="col-sm-12 col-md-12">';
                                $data = $data . '<div class="br-wrapper br-theme-fontawesome-stars pull-right">';
                                $data = $data . '<select class="enable" onchange="Rating($(this).val(),' . $hijo->id . ')">';
                                $data = $data . '<option value></option>';
                                $data = $data . '<option value="1" ';
                                if ($hijo->valoracion == 1) {
                                    $data = $data . "selected";
                                } else {
                                    $data = $data . "";
                                } $data = $data . ' >1</option>';
                                $data = $data . '<option value="2" ';
                                if ($hijo->valoracion == 2) {
                                    $data = $data . "selected";
                                } else {
                                    $data = $data . "";
                                } $data = $data . ' >2</option>';
                                $data = $data . '<option value="3" ';
                                if ($hijo->valoracion == 3) {
                                    $data = $data . "selected";
                                } else {
                                    $data = $data . "";
                                } $data = $data . ' >3</option>';
                                $data = $data . '<option value="4" ';
                                if ($hijo->valoracion == 4) {
                                    $data = $data . "selected";
                                } else {
                                    $data = $data . "";
                                } $data = $data . ' >4</option>';
                                $data = $data . '<option value="5" ';
                                if ($hijo->valoracion == 5) {
                                    $data = $data . "selected";
                                } else {
                                    $data = $data . "";
                                } $data = $data . ' >5</option>';
                                $data = $data . '</select>';
                                $data = $data . '</div>';
                                $data = $data . '</div>';
                            }
                        }
                        $data = $data . '<div class="clearfix"></div>';
                        $data = $data . '<div class="col-sm-12 col-md-12" style="padding-left:0px">';
                        $data = $data . '<div class="pull-left">';
                        //$data=$data.'<span style="cursor: pointer" onclick="Responder('.$hijo->id.')">Responder</span>';
                        $data = $data . '</div>';

                        $data = $data . '<div class="pull-right">';
                        $data = $data . 'Comentario de <span class="popover1"  data-type="html" style="cursor: pointer"  data-title="Información" data-content="Región: ' . $ubigeo->department . ' <br> II.EE: ' . $institucion->denominacion . '" data-placement="top" >' . $hijo->usuario->estudiante->nombres . ' ' . $hijo->usuario->estudiante->apellido_paterno . '</span> ' . zdateRelative($hijo->creado_at);
                        //$data=$data.'Comentario de '.$hijo->usuario->estudiante->nombres.' '.$hijo->usuario->estudiante->apellido_paterno .' '. Yii::$app->formatter->asRelativeTime($hijo->creado_at);
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                        $data = $data . '</div>';
                        $data = $data . '<div class="clearfix"></div>';
                        $data = $data . '</div>';
                    }
                    $data = $data . '</div>';
                    $data = $data . '</div>';
                    $data = $data . '<div class="clearfix"></div>';
                    $data = $data . '</div>';
                    $data = $data . '<div class="clearfix"></div>';

                    $data = $data . '</div>';
                }
                //$data=$data.$post['contenido'];
            endforeach;
            $data = $data . '</section>';
            echo $data;
        }
    }

    public function actionInsertarComentario() {

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
        if (isset($_POST["id"]) && isset($_POST["seccion"]) && isset($_POST["contenido"])) {
            $id = $_POST["id"];
            $seccion = $_POST["seccion"];
            $contenido = $_POST["contenido"];
            $foro = Foro::findOne($id);
            $newComentario = new ForoComentario();
            $newComentario->seccion = $seccion;
            $newComentario->foro_id = $foro->id;
            $newComentario->contenido = $contenido;
            $newComentario->save();

            $usuario = Usuario::findOne(\Yii::$app->user->id);
            $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();

            echo $estudiante->nombres . " " . $estudiante->apellido_paterno;
        }
    }

    public function actionInsertarComentarioMonitor() {
        if (isset($_POST["id"]) && isset($_POST["seccion"]) && isset($_POST["contenido"])) {
            $id = $_POST["id"];
            $seccion = $_POST["seccion"];
            $contenido = $_POST["contenido"];
            $foro = Foro::findOne($id);
            $newComentario = new ForoComentario();
            $newComentario->seccion = $seccion;
            $newComentario->foro_id = $foro->id;
            $newComentario->contenido = $contenido;
            $newComentario->save();

            $usuario = Usuario::findOne(\Yii::$app->user->id);
            $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();

            echo "Monitor";
        }
    }

    public function actionInsertarComentarioHijo() {


        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();
        //$integrante = Integrante::find()->where('estudiante_id=:estudiante_id and rol=1', [':estudiante_id' => $estudiante->id])->one();
        //var_dump($_REQUEST);
        if (isset($_POST["id"]) && isset($_POST["contenido"]) && isset($_POST["padre"])) {
            //var_dump($_REQUEST);
            $id = $_POST["id"];
            $contenido = $_POST["contenido"];
            $padre = $_POST["padre"];
            $foro = Foro::findOne($id);
            $forocomentario = ForoComentario::find()->where('id=:estudiante_id', [':estudiante_id' => $padre])->one();

            if ($forocomentario->foro_id != $foro->id) {

                exit;
            }
            if ($usuario->status_registro == "1") {

                exit;
            }
            if ($usuario->name_temporal == "Monitor" || $usuario->name_temporal == "Adminitrador") {
                
            } else {

                if ($foro->id > 2) {

                    $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();

                    $equipo = Equipo::findOne($integrante->equipo_id);

                    $forox = Foro::find()->where('asunto_id=:id', [':id' => $equipo->asunto_id])->one();

                    if (!empty($foro->asunto_id)) {


                        if ($forox->asunto_id != $foro->asunto_id) {
                            exit;
                        }
                    }
                }
            }





            if (empty($_POST["seccion"])) {
                $seccion = null;
            } else {
                $seccion = $_POST["seccion"];
            }


            $newComentario = new ForoComentario();
            $newComentario->foro_id = $foro->id;
            $newComentario->foro_comentario_hijo_id = $padre;

            $newComentario->seccion = $seccion;

            $newComentario->contenido = $contenido;
            $newComentario->save();

            $usuario = Usuario::findOne(\Yii::$app->user->id);
            if ($usuario->id >= 2 and $usuario->id <= 8) {
                echo $usuario->name_temporal;
            } else {
                $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();

                echo $estudiante->nombres . " " . $estudiante->apellido_paterno;
            }
        }
    }

    public function actionInsertarComentarioHijoMonitor() {
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        //var_dump($_REQUEST);
        if (isset($_POST["id"]) && isset($_POST["contenido"]) && isset($_POST["padre"])) {
            $id = $_POST["id"];
            /* if($id != "2"){

              } */
            $contenido = $_POST["contenido"];
            $padre = $_POST["padre"];
            $foro = Foro::findOne($id);

            $newComentario = new ForoComentario();
            $newComentario->foro_id = $foro->id;
            $newComentario->foro_comentario_hijo_id = $padre;
            $newComentario->contenido = $contenido;
            $newComentario->save();

            $usuario = Usuario::findOne(\Yii::$app->user->id);
            $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();

            echo "Monitor";
        }
    }

}
