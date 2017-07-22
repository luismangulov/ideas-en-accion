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
class ProyectoBuscarMonitorSegundaEntregaWidget extends Widget
{
    public $proyecto_id;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $proyecto=ProyectoCopia::find()->where('id=:id and etapa=2',[':id'=>$this->proyecto_id])->one();
        $integrante=Integrante::find()->where('equipo_id=:equipo_id and rol=1',[':equipo_id'=>$proyecto->equipo_id])->one();
        $disabled='disabled';
        $equipo=Equipo::findOne($integrante->equipo_id);
        $estudiante=Estudiante::find()->where('id=:id',[':id'=>$integrante->estudiante_id])->one();
        $institucion=Institucion::find()->where('id=:id',[':id'=>$estudiante->institucion_id])->one();
        $region=Ubigeo::find()->where('district_id=:district_id',[':district_id'=>$institucion->ubigeo_id])->one();
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
                    ->where('proyecto_id=:proyecto_id and actividad_copia.estado=1  and actividad_copia.etapa=2 and objetivo_especifico_copia.etapa=2',[':proyecto_id'=>$proyecto->id])->all();
        $actividades1=ActividadCopia::find()
                    ->select('objetivo_especifico_copia.id objetivo_especifico_id,actividad_copia.id actividad_id,actividad_copia.descripcion')
                    ->innerJoin('objetivo_especifico_copia','objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                    ->where('proyecto_id=:proyecto_id and actividad_copia.estado=1 and objetivo_especifico_copia.id=:id  and actividad_copia.etapa=2',[':proyecto_id'=>$proyecto->id,':id'=>$proyecto->objetivo_especifico_1_id])->all();
        $actividades2=ActividadCopia::find()
                    ->select('objetivo_especifico_copia.id objetivo_especifico_id,actividad_copia.id actividad_id,actividad_copia.descripcion')
                    ->innerJoin('objetivo_especifico_copia','objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                    ->where('proyecto_id=:proyecto_id and actividad_copia.estado=1 and objetivo_especifico_copia.id=:id  and actividad_copia.etapa=2',[':proyecto_id'=>$proyecto->id,':id'=>$proyecto->objetivo_especifico_2_id])->all();
        $actividades3=ActividadCopia::find()
                    ->select('objetivo_especifico_copia.id objetivo_especifico_id,actividad_copia.id actividad_id,actividad_copia.descripcion')
                    ->innerJoin('objetivo_especifico_copia','objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                    ->where('proyecto_id=:proyecto_id and actividad_copia.estado=1 and objetivo_especifico_copia.id=:id  and actividad_copia.etapa=2',[':proyecto_id'=>$proyecto->id,':id'=>$proyecto->objetivo_especifico_3_id])->all();
        $foro=Foro::find()->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])->one();
        if($proyecto && $foro)
        {
            $comen_monitores=ForoComentario::find()->where('foro_id=:foro_id and user_id between 2 and 8',[':foro_id'=>$foro->id])->all();
            $comen_participantes=ForoComentario::find()->where('foro_id=:foro_id and user_id>=9',[':foro_id'=>$foro->id])->all();
        }
        else
        {
            $comen_monitores=new ForoComentario;
            $comen_participantes=new ForoComentario;
        }     
        $reflexion=Reflexion::find()->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])->one();
        if($reflexion)
        {
            $proyecto->p1=$reflexion->p1;
            $proyecto->p2=$reflexion->p2;
            $proyecto->p3=$reflexion->p3;
            $proyecto->p4=$reflexion->p4;
            $proyecto->p5_1=$reflexion->p5_1;
            $proyecto->p5_2=$reflexion->p5_2;
            $proyecto->p5_3=$reflexion->p5_3;
            $proyecto->p5_4=$reflexion->p5_4;
            $proyecto->p5_5=$reflexion->p5_5;
            $proyecto->p5_6=$reflexion->p5_6;
            $proyecto->p5_7=$reflexion->p5_7;
            $proyecto->p5_8=$reflexion->p5_8;
            $proyecto->p6=$reflexion->p6;
            $proyecto->p7_1=$reflexion->p7_1;
            $proyecto->p7_2=$reflexion->p7_2;
            $proyecto->p7_3=$reflexion->p7_3;
            $proyecto->p7_4=$reflexion->p7_4;
            $proyecto->p7_5=$reflexion->p7_5;
            $proyecto->p7_6=$reflexion->p7_6;
            $proyecto->p7_7=$reflexion->p7_7;
            $proyecto->p7_8=$reflexion->p7_8;
            $proyecto->p8=$reflexion->p8;
        }
        
        
        
        $disabled='disabled';
        $videosegunda=VideoCopia::find()->where('proyecto_id=:proyecto_id and etapa=2',[':proyecto_id'=>$proyecto->id])->one();
        
        
        $etapa=Etapa::find()->where('estado=1')->one();
            
        return $this->render('proyectobuscarmonitorsegundaentrega',
                             ['proyecto'=>$proyecto,
                              'objetivos_especificos'=>$objetivos_especificos,
                              'actividades'=>$actividades,
                              'actividades1'=>$actividades1,
                              'actividades2'=>$actividades2,
                              'actividades3'=>$actividades3,
                              'disabled'=>$disabled,
                              'equipo'=>$equipo,
                              'integrante'=>$integrante,
                              'videosegunda'=>$videosegunda,
                              'etapa'=>$etapa,
                              'estudiante'=>$estudiante,
                              'institucion'=>$institucion,
                              'region'=>$region,
                              'comen_monitores'=>$comen_monitores,
                              'comen_participantes'=>$comen_participantes]);
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