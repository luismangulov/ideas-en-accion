<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\VotacionPublica;
use app\models\VotacionFinal;
use app\models\VistaResultado;

Yii::setAlias('video', '@web/video_carga/');
class VotacionPublicaController extends Controller
{
    
    public function behaviors()
    {
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout='votacionpublica';
        /*
        $resultados=VotacionPublica::find()
                    ->select(['votacion_publica.proyecto_id','proyecto.titulo','proyecto.resumen','institucion.denominacion','equipo.id as equipo_id','video.tipo','video.ruta','(select count(proyecto_id) from votacion_final where proyecto_id=proyecto.id) as votos'])
                    ->innerJoin('proyecto','proyecto.id=votacion_publica.proyecto_id')
                    ->innerJoin('equipo','equipo.id=proyecto.equipo_id')
                    ->innerJoin('video','video.proyecto_id=proyecto.id and video.etapa=2')
                    ->innerJoin('usuario','usuario.id=proyecto.user_id')
                    ->innerJoin('estudiante','estudiante.id=usuario.estudiante_id')
                    ->innerJoin('institucion','institucion.id=estudiante.institucion_id')
                    ->where('votacion_publica.region_id=:region_id',[':region_id'=>16])
                    ->orderBy('votos desc')
                    ->all();
                    */
        $resultados=VistaResultado::find()
                    ->select(['vista_resultado.proyecto_id','vista_resultado.titulo','vista_resultado.resumen','vista_resultado.denominacion','vista_resultado.equipo_id','vista_resultado.tipo','vista_resultado.ruta','vista_resultado.voto','vista_resultado.puesto','vista_resultado.voto_nuevo'])
                    ->where('region_id=:region_id',[':region_id'=>16])
                    ->orderBy('voto_nuevo desc')
                    ->all();
        return $this->render('index',['resultados'=>$resultados]);
    }
    
    public function actionRegistrar()
    {
        if(isset($_POST["dni"]) && isset($_POST["region"]) && isset($_POST["v1"]) && isset($_POST["v2"])  && isset($_POST["v2"]) )
        {
            $dni=$_POST["dni"];
            $fecha_nacimiento=$_POST["fecha_nacimiento"];
            $captcha=$_POST["captcha"];
            $region=$_POST["region"];
            $Countdni=strlen(trim($_POST["dni"]));
            $v1=$_POST["v1"];
            $v2=$_POST["v2"];
            $v3=$_POST["v3"];
            $bandera=0;

            session_start();

            if (isset($_SESSION["captcha_code"])) {
                if ($_SESSION["captcha_code"] != $captcha) {
                    $bandera=-1;
                    
                }
            }
            if($bandera == 0){
            
                $existe=VotacionFinal::find()->select("dni")->where('dni=:dni',[':dni'=>$dni])->one();
                if(!$existe && $Countdni==8)
                {
                    if($v1==$v2 || $v1==$v3 || $v2==$v3)
                    {
                        $bandera=2;
                    }
                    else
                    {
                        $model1=new VotacionFinal;
                        $model1->dni=$dni;
                        $model1->fecha_nacimiento=$fecha_nacimiento;
                        $model1->region=$region;
                        $model1->proyecto_id=$v1;
                        $model1->estado=1;
                        $model1->fecha_registro=date("Y-m-d H:i:s");
                        $model1->save();
                        
                        $model2=new VotacionFinal;
                        $model2->dni=$dni;
                        $model2->fecha_nacimiento=$fecha_nacimiento;
                        $model2->region=$region;
                        $model2->proyecto_id=$v2;
                        $model2->estado=1;
                        $model2->fecha_registro=date("Y-m-d H:i:s");
                        $model2->save();
                        
                        $model3=new VotacionFinal;
                        $model3->dni=$dni;
                        $model3->fecha_nacimiento=$fecha_nacimiento;
                        $model3->region=$region;
                        $model3->proyecto_id=$v3;
                        $model3->estado=1;
                        $model3->fecha_registro=date("Y-m-d H:i:s");
                        $model3->save();
                        $bandera=1;
                    }
                    
                    
                }
            }
            echo $bandera;
            
        }
    }
    public function actionValidarDni($dni)
    {
        if(isset($_POST["dni"]) && $_POST["dni"]!="")
        {
            //$dni=$_POST["dni"];
            $existe=VotacionFinal::find()->select("dni")->where('dni=:dni',[':dni'=>$dni])->one();
            $bandera=0;
            if($existe)
            {
                $bandera=1;
            }
            echo $bandera;
        }
    }
    
}
