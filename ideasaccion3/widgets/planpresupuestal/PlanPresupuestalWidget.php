<?php
namespace app\widgets\planpresupuestal;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Actividad;
use app\models\ObjetivoEspecifico;
use app\models\Proyecto;
use app\models\Cronograma;
use app\models\PlanPresupuestal;

class PlanPresupuestalWidget extends Widget
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
        $proyecto=Proyecto::findOne($this->proyecto_id);
        $objetivos=ObjetivoEspecifico::find()->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])->all();
        $actividades=Actividad::find()
                    ->innerJoin('objetivo_especifico','objetivo_especifico.id=actividad.objetivo_especifico_id')
                    ->where('objetivo_especifico.proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])
                    ->all();
                    
        $planespresupuestales=PlanPresupuestal::find()
                    ->select('  plan_presupuestal.id,plan_presupuestal.recurso,plan_presupuestal.como_conseguirlo,
                                plan_presupuestal.precio_unitario,plan_presupuestal.cantidad,plan_presupuestal.subtotal,
                                plan_presupuestal.actividad_id,objetivo_especifico.id objetivo_especifico_id')
                    ->innerJoin('actividad','actividad.id=plan_presupuestal.actividad_id')
                    ->innerJoin('objetivo_especifico','objetivo_especifico.id=actividad.objetivo_especifico_id')
                    ->where('objetivo_especifico.proyecto_id=:proyecto_id and actividad.estado=1 and plan_presupuestal.estado=1',[':proyecto_id'=>$proyecto->id])
                    ->all();
                    
        return $this->render('planpresupuestal',['proyecto'=>$proyecto,
                                                 'objetivos'=>$objetivos,
                                                 'actividades'=>$actividades,
                                                 'planespresupuestales'=>$planespresupuestales,
                                                 'disabled'=>$disabled]);
    }
}