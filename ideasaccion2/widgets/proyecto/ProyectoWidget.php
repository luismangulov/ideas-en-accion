<?php
namespace app\widgets\proyecto;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Usuario;
use app\models\Integrante;
use app\models\Proyecto;
use app\models\Reflexion;
use app\models\Actividad;
use app\models\Equipo;
use app\models\ObjetivoEspecifico;
use app\models\Institucion;

use yii\web\UploadedFile;

class ProyectoWidget extends Widget
{
    public $message;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
      
        $proyecto = new Proyecto;
        $usuario=Usuario::findOne(\Yii::$app->user->id);
        $integrante=Integrante::find()->where('estudiante_id=:estudiante_id',[':estudiante_id'=>$usuario->estudiante_id])->one();
        $equipo=Equipo::findOne($integrante->equipo_id);
        $institucion=Institucion::find()
                    ->select('institucion.id,estudiante.id as estudiante_id,ubigeo.department_id')
                    ->innerJoin('estudiante','estudiante.institucion_id=institucion.id')
                    ->innerJoin('usuario','usuario.estudiante_id=estudiante.id')
                    ->innerJoin('ubigeo','ubigeo.district_id=institucion.ubigeo_id')
                    ->where('usuario.id='.\Yii::$app->user->id.'')
                    ->one();
                    
        if ($proyecto->load(\Yii::$app->request->post()) && $proyecto->save()) {
                    
            //$countActividades1=count(array_filter($proyecto->actividades_1));
            //$countActividades2=count(array_filter($proyecto->actividades_2));
            if(isset($proyecto->actividades_1))
            {
                $countActividades1=count(array_filter($proyecto->actividades_1));
            }
            else
            {
                $countActividades1=0;
            }
            
            if(isset($proyecto->actividades_2))
            {
                $countActividades2=count(array_filter($proyecto->actividades_2));
            }
            else
            {
                $countActividades2=0;
            }
            
            if(isset($proyecto->actividades_3))
            {
                $countActividades3=count(array_filter($proyecto->actividades_3));
            }
            else
            {
                $countActividades3=0;
            }
            
            
            if(trim($proyecto->objetivo_especifico_1)!='')
            {
                $objetivoespecifico1=new ObjetivoEspecifico;
                $objetivoespecifico1->proyecto_id=$proyecto->id;
                $objetivoespecifico1->descripcion=$proyecto->objetivo_especifico_1;
                $objetivoespecifico1->save();
                
                for($i=0;$i<$countActividades1;$i++)
                {
                    if(trim($proyecto->actividades_1[$i]))
                    {
                        $actividad=new Actividad;
                        $actividad->objetivo_especifico_id=$objetivoespecifico1->id;
                        $actividad->descripcion=$proyecto->actividades_1[$i];
                        $actividad->estado=1;
                        $actividad->save();
                    }
                    
                }
            }
            
            if(trim($proyecto->objetivo_especifico_2)!='')
            {
                $objetivoespecifico2=new ObjetivoEspecifico;
                $objetivoespecifico2->proyecto_id=$proyecto->id;
                $objetivoespecifico2->descripcion=$proyecto->objetivo_especifico_2;
                $objetivoespecifico2->save();
                
                for($i=0;$i<$countActividades2;$i++)
                {
                    if(trim($proyecto->actividades_2[$i]))
                    {
                        $actividad=new Actividad;
                        $actividad->objetivo_especifico_id=$objetivoespecifico2->id;
                        $actividad->descripcion=$proyecto->actividades_2[$i];
                        $actividad->estado=1;
                        $actividad->save();
                    }
                }
            }
            
            if($countActividades3>0)
            {
                $objetivoespecifico3=new ObjetivoEspecifico;
                $objetivoespecifico3->proyecto_id=$proyecto->id;
                $objetivoespecifico3->descripcion=$proyecto->objetivo_especifico_3;
                $objetivoespecifico3->save();
                
                for($i=0;$i<$countActividades3;$i++)
                {
                    if(trim($proyecto->actividades_3[$i]))
                    {
                        $actividad=new Actividad;
                        $actividad->objetivo_especifico_id=$objetivoespecifico3->id;
                        $actividad->descripcion=$proyecto->actividades_3[$i];
                        $actividad->estado=1;
                        $actividad->save();
                    }
                    
                }
            }
            
            $proyecto->archivo = UploadedFile::getInstance($proyecto, 'archivo');
            if($proyecto->archivo) {
                
                $proyecto->proyecto_archivo=$proyecto->id. '.' . $proyecto->archivo->extension;
                $proyecto->formato_proyecto=1;//formato en documento
                $proyecto->update();
                $proyecto->archivo->saveAs('proyectos/' . $proyecto->proyecto_archivo);
            }
            
            return \Yii::$app->getResponse()->refresh();
        }
        
        return $this->render('proyecto',['proyecto'=>$proyecto,'equipo'=>$equipo,'institucion'=>$institucion]);
    }
}