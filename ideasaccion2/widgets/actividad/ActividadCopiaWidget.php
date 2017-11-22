<?php
namespace app\widgets\actividad;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Actividad;
use app\models\ObjetivoEspecifico;
use app\models\Proyecto;
use app\models\PlanPresupuestal;
use app\models\Integrante;
use app\models\Equipo;
use app\models\Estudiante;
use app\models\Usuario;
use app\models\Cronograma;

class ActividadCopiaWidget extends Widget
{
    public $id;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $usuario=Usuario::findOne(\Yii::$app->user->id);
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        $disabled='disabled';
        if($integrante->rol==2)
        {
            $disabled='disabled';
        }
        $proyecto=Proyecto::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$integrante->equipo_id])->one();
       
        //$estudiante=Estudiante::find()->where('id=:id',[':id'=>$usuario->estudiante_id])->one();
        $actividad=Actividad::find()
                    ->select('objetivo_especifico.id objetivo_especifico_id,actividad.id actividad_id,actividad.descripcion,actividad.resultado_esperado')
                    ->innerJoin('objetivo_especifico','objetivo_especifico.id=actividad.objetivo_especifico_id')
                    ->where('actividad.id=:actividad_id and actividad.estado=1',[':actividad_id'=>$this->id])
                    ->one();
        $planespresupuestales=PlanPresupuestal::find()
                    ->innerJoin('actividad','actividad.id=plan_presupuestal.actividad_id')
                    ->where('actividad_id=:actividad_id and actividad.estado=1 and plan_presupuestal.estado=1',[':actividad_id'=>$this->id])
                    ->all();
        //$lider=Integrante::find()->where('estudiante_id=:estudiante_id and rol=1',[':estudiante_id'=>$integrante->estudiante_id])->one();
        $responsables=Integrante::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$integrante->equipo_id])->all();
        $cronogramas=Cronograma::find()
                    ->innerJoin('actividad','actividad.id=cronograma.actividad_id')
                    ->where('actividad_id=:actividad_id and actividad.estado=1 and cronograma.estado=1',[':actividad_id'=>$this->id])
                    ->all();
        if(!$actividad)
        {
            
        }
        
        if ($actividad->load(\Yii::$app->request->post())) {
            $actividadu=Actividad::findOne($actividad->actividad_id);
            $actividadu->resultado_esperado=$actividad->resultado_esperado;
            $actividadu->update();
            
            $countPlanpresupuestal=count($actividad->precios_unitarios);
            
            for($i=0;$i<$countPlanpresupuestal;$i++)
            {
                if(isset($actividad->planes_presupuestal_ids[$i]))
                {
                    $planpresupuestal=PlanPresupuestal::find()->where('id=:id',[':id'=>$actividad->planes_presupuestal_ids[$i]])->one();
                    $planpresupuestal->recurso=$actividad->recursos[$i];
                    $planpresupuestal->como_conseguirlo=$actividad->comos_conseguirlos[$i];
                    $planpresupuestal->precio_unitario=$actividad->precios_unitarios[$i];
                    $planpresupuestal->cantidad=$actividad->cantidades[$i];
                    $planpresupuestal->subtotal=$actividad->subtotales[$i];
                    $planpresupuestal->update();
                }
                else
                {
                    $planpresupuestal=new PlanPresupuestal;
                    $planpresupuestal->actividad_id=$actividad->actividad_id;
                    $planpresupuestal->recurso=$actividad->recursos[$i];
                    $planpresupuestal->como_conseguirlo=$actividad->comos_conseguirlos[$i];
                    $planpresupuestal->precio_unitario=$actividad->precios_unitarios[$i];
                    $planpresupuestal->cantidad=$actividad->cantidades[$i];
                    $planpresupuestal->subtotal=$actividad->subtotales[$i];
                    $planpresupuestal->estado=1;
                    $planpresupuestal->save();
                }
            }
            
            $countCronograma=count($actividad->fechas_inicios);
            for($i=0;$i<$countCronograma;$i++)
            {
                if(isset($actividad->cronogramas_ids[$i]))
                {
                    $cronograma=Cronograma::find()->where('id=:id',[':id'=>$actividad->cronogramas_ids[$i]])->one();
                    $cronograma->responsable_id=$actividad->responsables[$i];
                    $cronograma->fecha_inicio=$actividad->fechas_inicios[$i];
                    $cronograma->fecha_fin=$actividad->fechas_fines[$i];
                    $cronograma->update();
                }
                else
                {
                    $cronograma=new Cronograma;
                    $cronograma->actividad_id=$actividad->actividad_id;
                    $cronograma->responsable_id=$actividad->responsables[$i];
                    $cronograma->fecha_inicio=$actividad->fechas_inicios[$i];
                    $cronograma->fecha_fin=$actividad->fechas_fines[$i];
                    $cronograma->estado=1;
                    $cronograma->save();
                }
            }
            return \Yii::$app->getResponse()->refresh();
        }
        
        return $this->render('actividadc',['proyecto'=>$proyecto,'actividad'=>$actividad,'planespresupuestales'=>$planespresupuestales,
                                          'responsables'=>$responsables,'cronogramas'=>$cronogramas,'disabled'=>$disabled]);
    }
}