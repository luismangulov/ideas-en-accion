<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Equipo;
use app\models\Usuario;
use app\models\Integrante;
use app\models\Etapa;
use app\models\Estudiante;
use app\models\Institucion;
use app\models\Ubigeo;
use app\models\Resultados;
use app\models\Proyecto;
use app\models\Video;
use app\models\Reflexion;




/**
 * ActividadController implements the CRUD actions for Actividad model.
 */
class RutaController extends Controller
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
     * Lists all Actividad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='equipo';
        $etapa=Etapa::find()->where('estado=1')->one();
        $usuario=Usuario::find()->where('id=:id',[':id'=>\Yii::$app->user->id])->one();
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        $equipo=Equipo::find()->where('id=:id',[':id'=>$integrante->equipo_id])->one();
        $integrantes=Integrante::find()
                            ->select('usuario.id user_id,estudiante.id,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno')
                            ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                            ->innerJoin('usuario','usuario.estudiante_id=estudiante.id')
                            ->where('equipo_id=:equipo_id',[':equipo_id'=>$equipo->id])
                            ->all();
        
        
        
        
        return $this->render('index',['equipo'=>$equipo,'integrantes'=>$integrantes,'etapa'=>$etapa]);
        
        
    }
    
    public function actionPrimero()
    {
        
    }
    
    public function actionSegundo($usuario)
    {
        $data=[];
        $usuario=Usuario::findOne($usuario);
        $estudiante=Estudiante::find()->where('id=:id',[':id'=>$usuario->estudiante_id])->one();
        $institucion=Institucion::find()->where('id=:id',[':id'=>$estudiante->institucion_id])->one();
        $ubigeo=Ubigeo::find()->where('district_id=:district_id',[':district_id'=>$institucion->ubigeo_id])->one();
        $resultados=Resultados::find()
                    ->select('descripcion_cabecera')
                    ->where('region_id=:region_id',[':region_id'=>$ubigeo->department_id])
                    ->innerJoin('asunto','asunto.id=resultados.asunto_id')
                    ->all();
        foreach( $resultados as $resultado)
        {
            array_push($data,['descripcion_cabecera'=>$resultado->descripcion_cabecera]);
        }
        
        echo json_encode($data,JSON_UNESCAPED_UNICODE); 
    }
    
    public function actionTercero($usuario)
    {
        $data=[];
        $usuario=Usuario::findOne($usuario);
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        if($integrante)
        {
            array_push($data,['estado'=>$integrante->estado]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE); 
        }
        
    }
    
    public function actionCuarto($usuario)
    {
        $data=[];
        $usuario=Usuario::findOne($usuario);
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        
        if($integrante)
        {
            array_push($data,['estado'=>$integrante->estado]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE); 
        }
    }
    public function actionQuinto($usuario)
    {
        $data=[];
        $foroAsuntoArray=[];
        $foroAbiertoArray=[];
        $usuario=Usuario::findOne($usuario);
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        if($integrante)
        {
            $equipo=Equipo::findOne($integrante->equipo_id);
            if($equipo)
            {
                $Countintegrante=Integrante::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$equipo->id])->count();
                /*Asuntos*/
                $foroAsuntos=Integrante::find()
                                ->select(['CONCAT(estudiante.nombres," ",estudiante.apellido_paterno," ",estudiante.apellido_materno) nombres_apellidos',
                                          '(select count(*) from foro_comentario where foro_comentario.foro_id=foro.id and foro_comentario.user_id=usuario.id) entrada'])
                                ->innerJoin('equipo','equipo.id=integrante.equipo_id')
                                ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                                ->innerJoin('usuario','usuario.estudiante_id=estudiante.id')
                                ->innerJoin('foro','foro.asunto_id=equipo.asunto_id')
                                ->where('equipo.id=:equipo and estudiante.grado!=6',
                                        [':equipo'=>$equipo->id])
                                ->all();
                $CountAsuntos=1;
                foreach($foroAsuntos as $foroAsunto)
                {
                    array_push($foroAsuntoArray,['nombres_apellidos_asunto'=>$foroAsunto->nombres_apellidos,'entradas_asunto'=>$foroAsunto->entrada]);
                    if($foroAsunto->entrada==0)
                    {
                        $CountAsuntos=0;
                    }
                }
                array_push($data,['foro_asunto'=>$foroAsuntoArray]);
                /*Abierto*/
                $foroAbiertos=Integrante::find()
                                ->select(['CONCAT(estudiante.nombres," ",estudiante.apellido_paterno," ",estudiante.apellido_materno) nombres_apellidos',
                                          '(select count(*) from foro_comentario where foro_comentario.foro_id=2 and foro_comentario.user_id=usuario.id) entrada'])
                                ->innerJoin('equipo','equipo.id=integrante.equipo_id')
                                ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                                ->innerJoin('usuario','usuario.estudiante_id=estudiante.id')
                                ->where('equipo.id=:equipo and estudiante.grado!=6',
                                        [':equipo'=>$equipo->id])
                                ->all();
                $CountAbierto=1;
                foreach($foroAbiertos as $foroAbierto)
                {
                    array_push($foroAbiertoArray,['nombres_apellidos_abierto'=>$foroAbierto->nombres_apellidos,'entradas_abierto'=>$foroAbierto->entrada]);
                    if($foroAbierto->entrada==0)
                    {
                        $CountAbierto=0;
                    }
                }
                array_push($data,['foro_abierto'=>$foroAbiertoArray]);
            }
            
        }
        
        
        if($integrante && $equipo && $equipo->estado==1)
        {
            array_push($data,['checkasunto'=>$CountAsuntos,'checkabierto'=>$CountAbierto]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE); 
        }
    }
    
    public function actionSexto($usuario)
    {
        $data=[];
        //$reflexionArray=[];
        $usuario=Usuario::findOne($usuario);
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        $etapa=Etapa::find()->where('estado=1')->one();
        if($integrante)
        {
            $equipo=Equipo::findOne($integrante->equipo_id);
            if($equipo)
            {
                $proyecto=Proyecto::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$equipo->id])->one();
                if($proyecto)
                {
                    $video=Video::find()->where('proyecto_id=:proyecto_id and etapa in (0,1)',[':proyecto_id'=>$proyecto->id])->one();
                    $videoregistrado=0;
                    if($video){
                        $videoregistrado=1;
                    }
                }
                
                if($proyecto)
                {
                    $reflexion=Reflexion::find()->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])->one();
                    $reflexionregistrado=1;
                    if($reflexion && (trim($reflexion->p1)=="" || trim($reflexion->p2)=="" || trim($reflexion->p3)=="")){
                        $reflexionregistrado=0;
                    }
                }
                
                    
                
                $proyectoregistrado=0;
                if($proyecto){
                    $proyectoregistrado=1;
                }
                
                /*Reflexion*/
                /*$reflexiones=Integrante::find()
                                ->select([''])
                                ->innerJoin('equipo','equipo.id=integrante.equipo_id')
                                ->where('equipo.id=:equipo and estudiante.grado!=6',
                                        [':equipo'=>$equipo->id])
                                ->all();*/
                /*$CountReflexion=1;
                foreach($reflexiones as $reflexion)
                {
                    array_push($reflexionArray,['nombres_apellidos'=>$reflexion->nombres_apellidos,'entradas'=>$reflexion->entrada]);
                    if($reflexion->entrada==0)
                    {
                        $CountReflexion=0;
                    }
                }
                
                array_push($data,['reflexiones'=>$reflexionArray]);*/
            }
            
        }
        
        if($integrante && $equipo && $equipo->estado==1 && $proyecto && ($etapa->etapa==1 || $etapa->etapa==2 || $etapa->etapa==3))
        {
            array_push($data,['proyecto_registrado'=>$proyectoregistrado,'checkreflexion'=>$reflexionregistrado,'checkvideo'=>$videoregistrado]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE); 
        }
    }
    
    public function actionSeptimo($usuario)
    {
        $data=[];
        $aporteArray=[];
        $usuario=Usuario::findOne($usuario);
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        $etapa=Etapa::find()->where('estado=1')->one();
        if($integrante)
        {
            $equipo=Equipo::findOne($integrante->equipo_id);
            if($equipo)
            {
                $proyecto=Proyecto::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$equipo->id])->one();
                
                /*Aportes*/
                $aportes=Integrante::find()
                                ->select(['CONCAT(estudiante.nombres," ",estudiante.apellido_paterno," ",estudiante.apellido_materno) nombres_apellidos',
                                          '(select count(*) from foro_comentario inner join foro f on f.id=foro_comentario.foro_id where foro_comentario.foro_id>33 and f.proyecto_id!=proyecto.id and foro_comentario.user_id=usuario.id) entrada'])
                                ->innerJoin('equipo','equipo.id=integrante.equipo_id')
                                ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                                ->innerJoin('usuario','usuario.estudiante_id=estudiante.id')
                                ->innerJoin('proyecto','proyecto.equipo_id=equipo.id')
                                ->where('equipo.id=:equipo and estudiante.grado!=6',
                                        [':equipo'=>$equipo->id])
                                ->all();
                $CountAporte=1;
                foreach($aportes as $aporte)
                {
                    array_push($aporteArray,['nombres_apellidos'=>$aporte->nombres_apellidos,'entradas'=>$aporte->entrada]);
                    if($aporte->entrada==0)
                    {
                        $CountAporte=0;
                    }
                }
                
                array_push($data,['aportes'=>$aporteArray]);
            }
            
        }
        
        if($integrante && $equipo && $equipo->estado==1 && $proyecto && ($etapa->etapa==2 || $etapa->etapa==3))
        {
            array_push($data,['checkaporte'=>$CountAporte]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE); 
        }
    }
    
    public function actionOctavo($usuario)
    {
        $data=[];
        $evaluacionArray=[];
        $usuario=Usuario::findOne($usuario);
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        $etapa=Etapa::find()->where('estado=1')->one();
        if($integrante)
        {
            $equipo=Equipo::findOne($integrante->equipo_id);
            if($equipo)
            {
                $proyecto=Proyecto::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$equipo->id])->one();
                if($proyecto)
                {
                
                $video=Video::find()->where('proyecto_id=:proyecto_id and etapa in (0,2)',[':proyecto_id'=>$proyecto->id])->one();
                $videoregistrado=0;
                if($video){
                    $videoregistrado=1;
                }
                
                /*Evaluación*/
                $evaluaciones=Integrante::find()
                                ->select(['CONCAT(estudiante.nombres," ",estudiante.apellido_paterno," ",estudiante.apellido_materno) nombres_apellidos',
                                          '(select case when trim(evaluacion.evaluacion)=""  then 0 else 1 end from evaluacion where evaluacion.user_id=usuario.id and evaluacion.proyecto_id=proyecto.id) entrada'])
                                ->innerJoin('equipo','equipo.id=integrante.equipo_id')
                                ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                                ->innerJoin('usuario','usuario.estudiante_id=estudiante.id')
                                ->innerJoin('proyecto','proyecto.equipo_id=equipo.id')
                                ->where('equipo.id=:equipo and estudiante.grado!=6',
                                        [':equipo'=>$equipo->id])
                                ->all();
                $CountEvaluacion=1;
                foreach($evaluaciones as $evaluacion)
                {
                    array_push($evaluacionArray,['nombres_apellidos'=>$evaluacion->nombres_apellidos,'entradas'=>$evaluacion->entrada]);
                    if($evaluacion->entrada==0)
                    {
                        $CountEvaluacion=0;
                    }
                }
                
                array_push($data,['evaluaciones'=>$evaluacionArray]);
                }
            }
            
        }
        
        
        if($integrante && $equipo && $equipo->estado==1 && $proyecto && ($etapa->etapa==2 || $etapa->etapa==3))
        {
            array_push($data,['checkvideo'=>$videoregistrado,'checkevaluacion'=>$CountEvaluacion]);
            echo json_encode($data,JSON_UNESCAPED_UNICODE); 
        }
    }
}
