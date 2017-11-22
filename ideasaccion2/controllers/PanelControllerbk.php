<?php

namespace app\controllers;

use Yii;
use app\models\Equipo;
use app\models\Estudiante;
use app\models\Integrante;
use app\models\Usuario;
use app\models\Voto;
use app\models\Ubigeo;
use app\models\Participante;
use app\models\Invitacion;
use app\models\ParticipanteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Resultados;
use app\models\Etapa;
use app\models\VotacionInternaSearch;
use app\models\VotacionInterna;
use app\models\VotacionPublica;


/**
 * ParticipanteController implements the CRUD actions for Participante model.
 */
class PanelController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','acciones'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['acciones'],
                        'allow' => true,
                        'roles' => ['administrador'],
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
     * Lists all Participante models.
     * @return mixed
     */
    public function actionIdeasAccion()
    {
        $this->layout='estandar';
        if(\Yii::$app->user->can('administrador'))
        {
            return $this->redirect(['acciones']);
        }
        
        //$this->layout='equipo';
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
        
        return $this->render('ideas-accion',['equipo'=>$equipo,'integrantes'=>$integrantes,'etapa'=>$etapa]);
    }
    public function actionIndex()
    {
        $this->layout='estandar';
        if(\Yii::$app->user->can('administrador'))
        {
            return $this->redirect(['acciones']);
        }
        
        
        $usuario=Usuario::findOne(\Yii::$app->user->id);
        $estudiante=Estudiante::find()->where('id=:id',[':id'=>$usuario->estudiante_id])->one();
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$estudiante->id])->one();
        if($integrante)
        {
            $equipo=Equipo::findOne($integrante->equipo_id);
        }
        else
        {
            $equipo = new Equipo;
        }
        
        $invitaciones=Invitacion::find()
                        ->select('usuario.avatar,invitacion.id,equipo.descripcion_equipo,lider.nombres,lider.apellido_paterno,lider.apellido_materno,lider.nombres_apellidos,institucion.denominacion')
                        ->innerJoin('equipo','equipo.id=invitacion.equipo_id')
                        ->innerJoin('estudiante lider','invitacion.estudiante_id=lider.id')
                        ->innerJoin('usuario','usuario.estudiante_id=lider.id')
                        ->innerJoin('institucion','institucion.id=lider.institucion_id')
                        ->where('invitacion.estudiante_invitado_id=:invitado and invitacion.estado=1',
                                [':invitado'=>$usuario->estudiante_id])
                        ->all();
                        
        
        
        return $this->render('index', ['invitaciones'=>$invitaciones,
                                       'integrante'=>$integrante,
                                       'estudiante'=>$estudiante,
                                       'equipo'=>$equipo
                            ]);
    }
    
    public function actionAcciones()
    {
        $this->layout='registrar';
        $countVoto=Voto::find()->count();
        $resultados=Resultados::find()->all();
        $Countresultados=Resultados::find()->count();
        $votacionpublica=VotacionPublica::find()->all();
        $etapa=Etapa::find()->where('estado=1')->one();
        $faltavalorporcentual=VotacionInterna::find()
                        ->innerJoin('proyecto','proyecto.id=votacion_interna.proyecto_id')
                        ->where('votacion_interna.estado=2 and proyecto.valor_porcentual_administrador is null ')->count();
        
        return $this->render('acciones',['resultados'=>$resultados,'etapa'=>$etapa,
                                         'faltavalorporcentual'=>$faltavalorporcentual,
                                         'votacionpublica'=>$votacionpublica,
                                         'countVoto'=>$countVoto,'Countresultados'=>$Countresultados]);
    }
    
    public function actionCerrar($bandera)
    {
        $resultados=Resultados::find()->all();
        $connection = \Yii::$app->db;
        $ubigeos=Ubigeo::find()->select('department_id,department')->groupBy('department_id')->orderBy('department desc')->all();
        if($bandera==1 && !$resultados)
        {
            foreach($ubigeos as $ubigeo)
            {
                $command=$connection->createCommand("
                    insert into resultados (asunto_id,region_id,cantidad)
                    select asunto_id,region_id,COUNT(asunto_id) contador from voto
                    where region_id='$ubigeo->department_id'
                    group by region_id,asunto_id
                    order by contador desc
                    limit 3;
                ");
                
                $command->execute();
                
            }
            echo 1;
        }
        else
        {
            echo 2;
        }
    }
    
    public function actionVotacioninterna()
    {
        $this->layout='registrar';
        
        $searchModel = new VotacionInternaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $countInterna=VotacionInterna::find()->select(['count(proyecto_id) as maximo'])->groupBy('proyecto_id')->one();
        
        return $this->render('votacioninterna',[
                                        'searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                        'countInterna'=>$countInterna]);
    }
    
    

}
