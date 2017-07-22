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
use app\models\ActividadCopia;
use app\models\ObjetivoEspecificoCopia;
use app\models\ProyectoCopia;
use app\models\CronogramaCopia;
use app\models\PlanPresupuestalCopia;
class PlanPresupuestalWidget2 extends Widget
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
        $objetivos=ObjetivoEspecificoCopia::find()->where('proyecto_id=:proyecto_id and etapa=2',[':proyecto_id'=>$proyecto->id])->all();
        $actividades=ActividadCopia::find()
                    ->innerJoin('objetivo_especifico_copia','objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                    ->where('objetivo_especifico_copia.proyecto_id=:proyecto_id and actividad_copia.etapa=2 and objetivo_especifico_copia.etapa=2',[':proyecto_id'=>$proyecto->id])
                    ->all();
                    
        $planespresupuestales=PlanPresupuestalCopia::find()
                    ->select('  plan_presupuestal_copia.id,plan_presupuestal_copia.recurso,plan_presupuestal_copia.como_conseguirlo,
                                plan_presupuestal_copia.precio_unitario,plan_presupuestal_copia.cantidad,plan_presupuestal_copia.subtotal,
                                plan_presupuestal_copia.actividad_id,objetivo_especifico_copia.id objetivo_especifico_id')
                    ->innerJoin('actividad_copia','actividad_copia.id=plan_presupuestal_copia.actividad_id')
                    ->innerJoin('objetivo_especifico_copia','objetivo_especifico_copia.id=actividad_copia.objetivo_especifico_id')
                    ->where('objetivo_especifico_copia.proyecto_id=:proyecto_id and actividad_copia.estado=1 and
                                plan_presupuestal_copia.estado=1 and plan_presupuestal_copia.etapa=2 and
                                actividad_copia.etapa=2 and objetivo_especifico_copia.etapa=2',[':proyecto_id'=>$proyecto->id])
                    ->all();
                    
        return $this->render('planpresupuestal2',['proyecto'=>$proyecto,
                                                 'objetivos'=>$objetivos,
                                                 'actividades'=>$actividades,
                                                 'planespresupuestales'=>$planespresupuestales,
                                                 'disabled'=>$disabled]);
    }
}