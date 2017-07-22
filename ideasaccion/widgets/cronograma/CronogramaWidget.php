<?php
namespace app\widgets\cronograma;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Actividad;
use app\models\ObjetivoEspecifico;
use app\models\Proyecto;
use app\models\Cronograma;
use app\models\Usuario;
use app\models\Integrante;

class CronogramaWidget extends Widget
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
        $usuario=Usuario::findOne(\Yii::$app->user->id);
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        $responsables=Integrante::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$integrante->equipo_id])->all();
        $proyecto=Proyecto::findOne($this->proyecto_id);
        $objetivos=ObjetivoEspecifico::find()->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])->all();
        $actividades=Actividad::find()
                    ->innerJoin('objetivo_especifico','objetivo_especifico.id=actividad.objetivo_especifico_id')
                    ->where('objetivo_especifico.proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])
                    ->all();
                    
        $cronogramas=Cronograma::find()
                    ->select('  cronograma.id,cronograma.fecha_inicio,cronograma.fecha_fin,
                                cronograma.duracion,cronograma.responsable_id,cronograma.estado,
                                cronograma.actividad_id,objetivo_especifico.id objetivo_especifico_id')
                    ->innerJoin('actividad','actividad.id=cronograma.actividad_id')
                    ->innerJoin('objetivo_especifico','objetivo_especifico.id=actividad.objetivo_especifico_id')
                    ->where('objetivo_especifico.proyecto_id=:proyecto_id and actividad.estado=1 and cronograma.estado=1',[':proyecto_id'=>$proyecto->id])
                    ->all();
        
        return $this->render('cronograma',['proyecto'=>$proyecto,
                                                 'objetivos'=>$objetivos,
                                                 'actividades'=>$actividades,
                                                 'cronogramas'=>$cronogramas,
                                                 'disabled'=>$disabled,
                                                 'responsables'=>$responsables]);
    }
}