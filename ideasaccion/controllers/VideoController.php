<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use app\models\Video;
use app\models\Proyecto;
use app\models\Etapa;
use app\models\Integrante;
use app\models\Usuario;
use app\models\Equipo;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

Yii::setAlias('video', '@web/video_carga/');


/**
 * VotoController implements the CRUD actions for Voto model.
 */
class VideoController extends Controller
{
    public function behaviors()
    {
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
     * Lists all Voto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='equipo';
        $etapa=Etapa::find()->where('estado=1')->one();
        $usuario=Usuario::findOne(\Yii::$app->user->id);
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',
                                              [':estudiante_id'=>$usuario->estudiante_id])->one();
        $equipo=Equipo::findOne($integrante->equipo_id);
        $proyecto=Proyecto::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$integrante->equipo_id])->one();
        
        
        
        $video=Video::find()->where('proyecto_id=:proyecto_id and etapa=:etapa',
                                    [':proyecto_id'=>$proyecto->id,':etapa'=>0])->one();
        if(!$video)
        {
            $video=new Video;
        }
        
        
        if (Yii::$app->request->isPost) {
            $video->archivo = UploadedFile::getInstance($video, 'archivo');
            
            if($video->archivo) {
                //$video->ruta=\Yii::$app->user->id. '.' . $video->archivo->extension;
                $video->proyecto_id=$proyecto->id;
                $video->etapa=0;
                $video->save();
                $videoup=Video::findOne($video->id);
                $videoup->ruta=$video->id. '.' . $video->archivo->extension;
                $videoup->update();
                
                $video->archivo->saveAs('video_carga/' . $videoup->id . '.' . $video->archivo->extension);
            }
            return $this->refresh();
        }
        return $this->render('index',['video'=>$video,'integrante'=>$integrante,'equipo'=>$equipo]);
    }
    public function actionDescargar($archivo)
    {
        
        
    }

}
