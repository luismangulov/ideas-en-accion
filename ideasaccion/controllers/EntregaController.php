<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Usuario;
use app\models\Integrante;
use app\models\Proyecto;
use app\models\ProyectoCopia;
use app\models\Actividad;
use app\models\ObjetivoEspecifico;
use app\models\Cronograma;
use app\models\Reflexion;
use app\models\Video;
use app\models\Etapa;
use app\models\Evaluacion;
use app\models\PlanPresupuestal;
use app\models\Equipo;
use app\models\ForoComentario;
use app\models\Foro;

/**
 * ActividadController implements the CRUD actions for Actividad model.
 */
class EntregaController extends Controller {

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
    public function actionIndex() {
        $this->layout = 'estandar';
        $etapa = Etapa::find()->where('estado=1')->one();
        $etapa1 = Etapa::find()->where('estado=1 and etapa=1')->one();
        $etapa2 = Etapa::find()->where('estado=1 and etapa=2')->one();
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
        $equipo = Equipo::findOne($integrante->equipo_id);


        return $this->render('index', ['equipo' => $equipo]);
    }

    public function actionPrimera() {
        $this->layout = 'estandar';
        $etapa = Etapa::find()->where('estado=1')->one();
        $etapa1 = Etapa::find()->where('estado=1 and etapa=1')->one();
        $etapa2 = Etapa::find()->where('estado=1 and etapa=2')->one();
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        // $usuario = Usuario::find()->where("id=:estudiante_id and status_registro=2", [':estudiante_id' => $usuario->estudiante_id])->one();
        if ($usuario->name_temporal == "Monitor" || $usuario->name_temporal == "Adminitrador" || $usuario->status_registro == "1") {
            return $this->goHome();
        }



        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
        $equipo = Equipo::findOne($integrante->equipo_id);

        $proyecto = Proyecto::find()->where('equipo_id=:equipo_id', [':equipo_id' => $equipo->id])->one();
        $newComentario = new ForoComentario();
        $model = Foro::find()->where('proyecto_id=:proyecto_id', [':proyecto_id' => $proyecto->id])->one();
        $seccion = new Proyecto;
        $seccion->load(Yii::$app->request->queryParams);

        if ($model && $newComentario->load(Yii::$app->request->post()) && trim($newComentario->contenido) != '') {


            $newComentario->seccion = $seccion->seccion;
            $newComentario->foro_id = $model->id;
            if ($newComentario->save()) {
                return $this->refresh();
            }
        }



        return $this->render('primera', ['equipo' => $equipo, 'seccion' => $seccion->seccion]);
    }

    public function actionSegunda() {
        $this->layout = 'estandar';
        $etapa = Etapa::find()->where('estado=1')->one();
        $etapa1 = Etapa::find()->where('estado=1 and etapa=1')->one();
        $etapa2 = Etapa::find()->where('estado=1 and etapa=2')->one();
        $usuario = Usuario::findOne(\Yii::$app->user->id);
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
        $equipo = Equipo::findOne($integrante->equipo_id);


        return $this->render('segunda', ['equipo' => $equipo]);
    }

}
