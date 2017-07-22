<?php
namespace app\widgets\cronograma;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Actividad;
use app\models\ObjetivoEspecifico;
use app\models\Proyecto;
use app\models\Cronograma;
use app\models\ActividadCopia;
use app\models\ObjetivoEspecificoCopia;
use app\models\ProyectoCopia;
use app\models\CronogramaCopia;
use app\models\Usuario;
use app\models\Integrante;

class CronogramaWidget1 extends Widget
{
    public $proyecto_id;
    public $disabled;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $disabled=$this->disabled;
        $proyecto=ProyectoCopia::findOne($this->proyecto_id);
        
        //$usuario=Usuario::findOne(\Yii::$app->user->id);
        //$integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        $responsables=Integrante::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$proyecto->equipo_id])->all();
        
        
        $objetivos=ObjetivoEspecificoCopia::find()->where('proyecto_id=:proyecto_id and etapa=1',[':proyecto_id'=>$proyecto->id])->all();
        $actividades=ActividadCopia::find()
                    ->innerJoin('objetivo_especifico_copia','objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                    ->where('objetivo_especifico_copia.proyecto_id=:proyecto_id and actividad_copia.etapa=1 and
                            objetivo_especifico_copia.etapa=1',[':proyecto_id'=>$proyecto->id])
                    ->all();
                    
        $cronogramas=CronogramaCopia::find()
                    ->select('  cronograma_copia.id,cronograma_copia.fecha_inicio,cronograma_copia.fecha_fin,
                                cronograma_copia.duracion,cronograma_copia.responsable_id,cronograma_copia.estado,
                                cronograma_copia.actividad_id,objetivo_especifico_copia.id objetivo_especifico_id')
                    ->innerJoin('actividad_copia','actividad_copia.id=cronograma_copia.actividad_id')
                    ->innerJoin('objetivo_especifico_copia','objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                    ->where('objetivo_especifico_copia.proyecto_id=:proyecto_id and actividad_copia.estado=1 and cronograma_copia.estado=1 and
                            objetivo_especifico_copia.etapa=1 and actividad_copia.etapa=1 and cronograma_copia.etapa=1',[':proyecto_id'=>$proyecto->id])
                    ->all();
        
        return $this->render('cronograma1',['proyecto'=>$proyecto,
                                                 'objetivos'=>$objetivos,
                                                 'actividades'=>$actividades,
                                                 'cronogramas'=>$cronogramas,
                                                 'disabled'=>$disabled,
                                                 'responsables'=>$responsables]);
    }
}