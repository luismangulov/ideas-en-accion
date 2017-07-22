<?php
namespace app\widgets\proyecto;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Reflexion;
use app\models\Proyecto;
use app\models\Usuario;
use app\models\Integrante;
use app\models\Actividad;
use app\models\Equipo;
use app\models\Estudiante;
use app\models\Institucion;
use app\models\Ubigeo;
use app\models\ObjetivoEspecifico;
use app\models\Evaluacion;
use app\models\PlanPresupuestal;
use app\models\Cronograma;
use app\models\Video;
use app\models\VideoCopia;
use app\models\ProyectoCopia;
use app\models\ObjetivoEspecificoCopia;
use app\models\ActividadCopia;
use app\models\Etapa;
use app\models\ForoComentario;
use app\models\Foro;
use yii\web\UploadedFile;
Yii::setAlias('video', '@web/video_carga/');
class ProyectoPrimeraEntregaWidget extends Widget
{
    public $message;
    public $entrega;
    public $seccion;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $usuario=Usuario::findOne(\Yii::$app->user->id);
        
        $estudiante=Estudiante::find()->where('id=:id',[':id'=>$usuario->estudiante_id])->one();
        $institucion=Institucion::find()->where('id=:id',[':id'=>$estudiante->institucion_id])->one();
        $region=Ubigeo::find()->where('district_id=:district_id',[':district_id'=>$institucion->ubigeo_id])->one();
        
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        $equipo=Equipo::findOne($integrante->equipo_id);
        $disabled='';
        if($integrante->rol==2)
        {
            $disabled='disabled';
        }
        
        $proyecto=ProyectoCopia::find()->where('equipo_id=:equipo_id and etapa=1',[':equipo_id'=>$integrante->equipo_id])->one();
        $objetivos_especificos=ObjetivoEspecificoCopia::find()->where('proyecto_id=:proyecto_id and etapa=1',[':proyecto_id'=>$proyecto->id])->all();
        
        $i=1;
        foreach($objetivos_especificos as $objetivo_especifico)
        {
            if($i==1)
            {
                $proyecto->objetivo_especifico_1_id=$objetivo_especifico->id;
                $proyecto->objetivo_especifico_1=$objetivo_especifico->descripcion;
            }
            if($i==2)
            {
                $proyecto->objetivo_especifico_2_id=$objetivo_especifico->id;
                $proyecto->objetivo_especifico_2=$objetivo_especifico->descripcion;
            }
            if($i==3)
            {
                $proyecto->objetivo_especifico_3_id=$objetivo_especifico->id;
                $proyecto->objetivo_especifico_3=$objetivo_especifico->descripcion;
            }
            $i++;
        }
        $actividades=ActividadCopia::find()
                    ->select('objetivo_especifico_copia.id objetivo_especifico_id,actividad_copia.id actividad_id,actividad_copia.descripcion,actividad_copia.resultado_esperado')
                    ->innerJoin('objetivo_especifico_copia','objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                    ->where('proyecto_id=:proyecto_id and actividad_copia.estado=1  and actividad_copia.etapa=1 and objetivo_especifico_copia.etapa=1',[':proyecto_id'=>$proyecto->id])->all();
        $actividades1=ActividadCopia::find()
                    ->select('objetivo_especifico_copia.id objetivo_especifico_id,actividad_copia.id actividad_id,actividad_copia.descripcion')
                    ->innerJoin('objetivo_especifico_copia','objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                    ->where('proyecto_id=:proyecto_id and actividad_copia.estado=1 and objetivo_especifico_copia.id=:id  and actividad_copia.etapa=1',[':proyecto_id'=>$proyecto->id,':id'=>$proyecto->objetivo_especifico_1_id])->all();
        $actividades2=ActividadCopia::find()
                    ->select('objetivo_especifico_copia.id objetivo_especifico_id,actividad_copia.id actividad_id,actividad_copia.descripcion')
                    ->innerJoin('objetivo_especifico_copia','objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                    ->where('proyecto_id=:proyecto_id and actividad_copia.estado=1 and objetivo_especifico_copia.id=:id  and actividad_copia.etapa=1',[':proyecto_id'=>$proyecto->id,':id'=>$proyecto->objetivo_especifico_2_id])->all();
        $actividades3=ActividadCopia::find()
                    ->select('objetivo_especifico_copia.id objetivo_especifico_id,actividad_copia.id actividad_id,actividad_copia.descripcion')
                    ->innerJoin('objetivo_especifico_copia','objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                    ->where('proyecto_id=:proyecto_id and actividad_copia.estado=1 and objetivo_especifico_copia.id=:id  and actividad_copia.etapa=1',[':proyecto_id'=>$proyecto->id,':id'=>$proyecto->objetivo_especifico_3_id])->all();
                    
        $reflexion=Reflexion::find()->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])->one();
        $proyecto->p1=$reflexion->p1;
        $proyecto->p2=$reflexion->p2;
        $proyecto->p3=$reflexion->p3;
        //var_dump($proyecto->reflexion);die;
        if($equipo->etapa==1 || $equipo->etapa==2)
        {
            $evaluacion=Evaluacion::find()->where('proyecto_id=:proyecto_id and user_id=:user_id',[':user_id'=>$usuario->id,':proyecto_id'=>$proyecto->id])->one();
            if($evaluacion)
            {
                $proyecto->evaluacion=$evaluacion->evaluacion;
            }
            
        }
        
        
        $disabled='disabled';
        $videoprimera=VideoCopia::find()->where('proyecto_id=:proyecto_id and etapa=1',[':proyecto_id'=>$proyecto->id])->one();
        
        
        $etapa=Etapa::find()->where('estado=1')->one();
        /*$newComentario = new ForoComentario();
        $foro=Foro::find()->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])->one();
        
        if($foro && $newComentario->load(Yii::$app->request->post()) && trim($newComentario->contenido)!='')
        {
            $newComentario->foro_id = $foro->id;
            $newComentario->save();
        }
        */
            
        return $this->render('proyectoprimeraentrega',
                             ['proyecto'=>$proyecto,
                              'objetivos_especificos'=>$objetivos_especificos,
                              'actividades'=>$actividades,
                              'actividades1'=>$actividades1,
                              'actividades2'=>$actividades2,
                              'actividades3'=>$actividades3,
                              'disabled'=>$disabled,
                              'equipo'=>$equipo,
                              'integrante'=>$integrante,
                              'videoprimera'=>$videoprimera,
                              'entrega'=>$this->entrega,
                              'etapa'=>$etapa,
                              'estudiante'=>$estudiante,
                              'institucion'=>$institucion,
                              'region'=>$region,
                              'seccion'=>$this->seccion]);
    }
    
    public function rename_win($oldfile,$newfile) {
    if (!rename($oldfile,$newfile)) {
        if (copy ($oldfile,$newfile)) {
            unlink($oldfile);
            return TRUE;
        }
        return FALSE;
    }
    return TRUE;
}
}