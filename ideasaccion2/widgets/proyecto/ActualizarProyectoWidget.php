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
use app\models\ObjetivoEspecifico;
use app\models\Evaluacion;
use app\models\PlanPresupuestal;
use app\models\Cronograma;
use app\models\Video;
use app\models\VideoCopia;
use app\models\Etapa;
use app\models\Estudiante;
use app\models\ForoComentario;
use app\models\Foro;
use app\models\Institucion;
use yii\web\UploadedFile;

Yii::setAlias('video', '@web/video_carga/');

class ActualizarProyectoWidget extends Widget {

    public $message;
    public $entrega;

    public function init() {
        parent::init();
    }

    public function run() {
        //echo "lala";exit;

        $usuario = Usuario::findOne(\Yii::$app->user->id);

        if ($usuario->name_temporal == "Monitor" || $usuario->name_temporal == "Adminitrador" || $usuario->status_registro == "1") {
            return $this->goHome();
        }

        $etapa = Etapa::find()->where('estado=1')->one();
        $newComentario = new ForoComentario();
        //$usuario = Usuario::findOne(\Yii::$app->user->id);
        $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
        $estudiante = Estudiante::find()->where('id=:id', [':id' => $integrante->estudiante_id])->one();
        $equipo = Equipo::findOne($integrante->equipo_id);
        $institucion = Institucion::find()
                ->select('institucion.id,estudiante.id as estudiante_id,ubigeo.department_id')
                ->innerJoin('estudiante', 'estudiante.institucion_id=institucion.id')
                ->innerJoin('usuario', 'usuario.estudiante_id=estudiante.id')
                ->innerJoin('ubigeo', 'ubigeo.district_id=institucion.ubigeo_id')
                ->where('usuario.id=' . \Yii::$app->user->id . '')
                ->one();


        $disabled = '';
        if ($integrante->rol == 2) {
            $disabled = 'disabled';
        }

        $proyecto = Proyecto::find()->where('equipo_id=:equipo_id', [':equipo_id' => $integrante->equipo_id])->one();
        $objetivos_especificos = ObjetivoEspecifico::find()->where('proyecto_id=:proyecto_id', [':proyecto_id' => $proyecto->id])->all();
        $foro = Foro::find()->where('proyecto_id=:proyecto_id', [':proyecto_id' => $proyecto->id])->one();
        if ($proyecto && $foro) {
            $comen_monitores = ForoComentario::find()->where('foro_id=:foro_id and user_id between 2 and 8', [':foro_id' => $foro->id])->all();
            $comen_participantes = ForoComentario::find()->where('foro_id=:foro_id and user_id>=9', [':foro_id' => $foro->id])->all();
        } else {
            $comen_monitores = null;
            $comen_participantes = null;
            /* $comen_monitores=null;
              $comen_participantes=new ForoComentario;
              print_r($comen_monitores);
              exit; */
        }


        $video = Video::find()->where('proyecto_id=:proyecto_id and etapa=:etapa', [':proyecto_id' => $proyecto->id, ':etapa' => 0])->one();
        if (!$video) {
            $video = new Video;
        }

        $i = 1;
        foreach ($objetivos_especificos as $objetivo_especifico) {
            if ($i == 1) {
                $proyecto->objetivo_especifico_1_id = $objetivo_especifico->id;
                $proyecto->objetivo_especifico_1 = $objetivo_especifico->descripcion;
            }
            if ($i == 2) {
                $proyecto->objetivo_especifico_2_id = $objetivo_especifico->id;
                $proyecto->objetivo_especifico_2 = $objetivo_especifico->descripcion;
            }
            if ($i == 3) {
                $proyecto->objetivo_especifico_3_id = $objetivo_especifico->id;
                $proyecto->objetivo_especifico_3 = $objetivo_especifico->descripcion;
            }
            $i++;
        }
        $actividades = Actividad::find()
                        ->select('objetivo_especifico.id objetivo_especifico_id,actividad.id actividad_id,actividad.descripcion,actividad.resultado_esperado')
                        ->innerJoin('objetivo_especifico', 'objetivo_especifico.id=actividad.objetivo_especifico_id')
                        ->where('proyecto_id=:proyecto_id and actividad.estado=1', [':proyecto_id' => $proyecto->id])->all();
        $actividades1 = Actividad::find()
                        ->select('objetivo_especifico.id objetivo_especifico_id,actividad.id actividad_id,actividad.descripcion')
                        ->innerJoin('objetivo_especifico', 'objetivo_especifico.id=actividad.objetivo_especifico_id')
                        ->where('proyecto_id=:proyecto_id and actividad.estado=1 and objetivo_especifico.id=:id', [':proyecto_id' => $proyecto->id, ':id' => $proyecto->objetivo_especifico_1_id])->all();
        $actividades2 = Actividad::find()
                        ->select('objetivo_especifico.id objetivo_especifico_id,actividad.id actividad_id,actividad.descripcion')
                        ->innerJoin('objetivo_especifico', 'objetivo_especifico.id=actividad.objetivo_especifico_id')
                        ->where('proyecto_id=:proyecto_id and actividad.estado=1 and objetivo_especifico.id=:id', [':proyecto_id' => $proyecto->id, ':id' => $proyecto->objetivo_especifico_2_id])->all();
        $actividades3 = Actividad::find()
                        ->select('objetivo_especifico.id objetivo_especifico_id,actividad.id actividad_id,actividad.descripcion')
                        ->innerJoin('objetivo_especifico', 'objetivo_especifico.id=actividad.objetivo_especifico_id')
                        ->where('proyecto_id=:proyecto_id and actividad.estado=1 and objetivo_especifico.id=:id', [':proyecto_id' => $proyecto->id, ':id' => $proyecto->objetivo_especifico_3_id])->all();

        $reflexion = Reflexion::find()->where('proyecto_id=:proyecto_id', [':proyecto_id' => $proyecto->id])->one();
        if ($reflexion) {
            $proyecto->p1 = $reflexion->p1;
            $proyecto->p2 = $reflexion->p2;
            $proyecto->p3 = $reflexion->p3;
            $proyecto->p4 = $reflexion->p4;
            $proyecto->p5_1 = $reflexion->p5_1;
            $proyecto->p5_2 = $reflexion->p5_2;
            $proyecto->p5_3 = $reflexion->p5_3;
            $proyecto->p5_4 = $reflexion->p5_4;
            $proyecto->p5_5 = $reflexion->p5_5;
            $proyecto->p5_6 = $reflexion->p5_6;
            $proyecto->p5_7 = $reflexion->p5_7;
            $proyecto->p5_8 = $reflexion->p5_8;
            $proyecto->p6 = $reflexion->p6;
            $proyecto->p7_1 = $reflexion->p7_1;
            $proyecto->p7_2 = $reflexion->p7_2;
            $proyecto->p7_3 = $reflexion->p7_3;
            $proyecto->p7_4 = $reflexion->p7_4;
            $proyecto->p7_5 = $reflexion->p7_5;
            $proyecto->p7_6 = $reflexion->p7_6;
            $proyecto->p7_7 = $reflexion->p7_7;
            $proyecto->p7_8 = $reflexion->p7_8;
            $proyecto->p8 = $reflexion->p8;
        }

        if ($proyecto->load(\Yii::$app->request->post())) {

            //$integrante = Integrante::find()->where("estudiante_id=:estudiante_id and rol='1'", [':estudiante_id' => $usuario->estudiante_id])->one();
            if (empty($integrante)) {
                $this->redirect(['panel/index']);
            }

            Yii::$app->session->setFlash("tab_active_pro", $proyecto->tab_active_pro);

            $equipo->asunto_id = $proyecto->asunto_id;
            $equipo->update();
            if (!$reflexion) {
                $reflexion = new Reflexion;
                $reflexion->proyecto_id = $proyecto->id;
                $reflexion->user_id = $proyecto->user_id;
                $reflexion->p1 = trim($proyecto->p1);
                $reflexion->p2 = trim($proyecto->p2);
                $reflexion->p3 = trim($proyecto->p3);
                $reflexion->save();
            } else {
                $reflexion->p1 = trim($proyecto->p1);
                $reflexion->p2 = trim($proyecto->p2);
                $reflexion->p3 = trim($proyecto->p3);
                $reflexion->p4 = $proyecto->p4;

                if (isset($_POST["Proyecto"]["p5_1"])) {
                    $reflexion->p5_1 = 1;
                } else {
                    $reflexion->p5_1 = 0;
                }

                if (isset($_POST["Proyecto"]["p5_2"])) {
                    $reflexion->p5_2 = 1;
                } else {
                    $reflexion->p5_2 = 0;
                }

                if (isset($_POST["Proyecto"]["p5_3"])) {
                    $reflexion->p5_3 = 1;
                } else {
                    $reflexion->p5_3 = 0;
                }

                if (isset($_POST["Proyecto"]["p5_4"])) {
                    $reflexion->p5_4 = 1;
                } else {
                    $reflexion->p5_4 = 0;
                }

                if (isset($_POST["Proyecto"]["p5_5"])) {
                    $reflexion->p5_5 = 1;
                } else {
                    $reflexion->p5_5 = 0;
                }

                if (isset($_POST["Proyecto"]["p5_6"])) {
                    $reflexion->p5_6 = 1;
                } else {
                    $reflexion->p5_6 = 0;
                }

                if (isset($_POST["Proyecto"]["p5_7"])) {
                    $reflexion->p5_7 = 1;
                } else {
                    $reflexion->p5_7 = 0;
                }

                if (isset($_POST["Proyecto"]["p5_8"])) {
                    $reflexion->p5_8 = 1;
                } else {
                    $reflexion->p5_8 = 0;
                }

                /* $reflexion->p5_1=$proyecto->p5_1;
                  $reflexion->p5_2=$proyecto->p5_2;
                  $reflexion->p5_3=$proyecto->p5_3;
                  $reflexion->p5_4=$proyecto->p5_4;
                  $reflexion->p5_5=$proyecto->p5_5;
                  $reflexion->p5_6=$proyecto->p5_6;
                  $reflexion->p5_7=$proyecto->p5_7;
                  $reflexion->p5_8=$proyecto->p5_8; */
                $reflexion->p6 = $proyecto->p6;
                if (isset($_POST["Proyecto"]["p7_1"])) {
                    $reflexion->p7_1 = 1;
                } else {
                    $reflexion->p7_1 = 0;
                }

                if (isset($_POST["Proyecto"]["p7_2"])) {
                    $reflexion->p7_2 = 1;
                } else {
                    $reflexion->p7_2 = 0;
                }

                if (isset($_POST["Proyecto"]["p7_3"])) {
                    $reflexion->p7_3 = 1;
                } else {
                    $reflexion->p7_3 = 0;
                }

                if (isset($_POST["Proyecto"]["p7_4"])) {
                    $reflexion->p7_4 = 1;
                } else {
                    $reflexion->p7_4 = 0;
                }

                if (isset($_POST["Proyecto"]["p7_5"])) {
                    $reflexion->p7_5 = 1;
                } else {
                    $reflexion->p7_5 = 0;
                }

                if (isset($_POST["Proyecto"]["p7_6"])) {
                    $reflexion->p7_6 = 1;
                } else {
                    $reflexion->p7_6 = 0;
                }

                if (isset($_POST["Proyecto"]["p7_7"])) {
                    $reflexion->p7_7 = 1;
                } else {
                    $reflexion->p7_7 = 0;
                }

                if (isset($_POST["Proyecto"]["p7_8"])) {
                    $reflexion->p7_8 = 1;
                } else {
                    $reflexion->p7_8 = 0;
                }
                /*
                  $reflexion->p7_2=$proyecto->p7_2;
                  $reflexion->p7_3=$proyecto->p7_3;
                  $reflexion->p7_4=$proyecto->p7_4;
                  $reflexion->p7_5=$proyecto->p7_5;
                  $reflexion->p7_6=$proyecto->p7_6;
                  $reflexion->p7_7=$proyecto->p7_7;
                  $reflexion->p7_8=$proyecto->p7_8; */
                $reflexion->p8 = $proyecto->p8;
                $reflexion->update();
                //var_dump($reflexion->p7_1);die;
            }

            //var_dump(\Yii::$app->request->post());die;

            $proyecto->update();
            if (!$proyecto->actividades_1) {
                $countActividades1 = 0;
            } else {
                $countActividades1 = count(array_filter($proyecto->actividades_1));
            }
            if (!$proyecto->actividades_2) {
                $countActividades2 = 0;
            } else {
                $countActividades2 = count(array_filter($proyecto->actividades_2));
            }
            if (!$proyecto->actividades_3) {
                $countActividades3 = 0;
            } else {
                $countActividades3 = count(array_filter($proyecto->actividades_3));
            }

            if (!$proyecto->planes_presupuestales_cantidades) {
                $countPlanesPresupuestalesCantidades = 0;
            } else {
                $countPlanesPresupuestalesCantidades = count(array_filter($proyecto->planes_presupuestales_cantidades));
            }



            if (!$proyecto->cronogramas_fechas_inicios) {
                $countCronogramasFechasInicios = 0;
            } else {
                $countCronogramasFechasInicios = count(array_filter($proyecto->cronogramas_fechas_inicios));
            }

            if (!$proyecto->resultados_esperados) {
                $countResultadosEsperados = 0;
            } else {
                $countResultadosEsperados = count(array_filter($proyecto->resultados_esperados));
            }


            if (trim($proyecto->objetivo_especifico_1) != '') {
                if (isset($proyecto->objetivo_especifico_1_id)) {
                    $objetivoespecifico1 = ObjetivoEspecifico::find()->where('id=:id', [':id' => $proyecto->objetivo_especifico_1_id])->one();
                    $objetivoespecifico1->descripcion = $proyecto->objetivo_especifico_1;
                    $objetivoespecifico1->update();
                } else {
                    $objetivoespecifico1 = new ObjetivoEspecifico;
                    $objetivoespecifico1->proyecto_id = $proyecto->id;
                    $objetivoespecifico1->descripcion = $proyecto->objetivo_especifico_1;
                    $objetivoespecifico1->save();
                }


                for ($i = 0; $i < $countActividades1; $i++) {
                    if (isset($proyecto->actividades_ids_1[$i]) && trim($proyecto->actividades_1[$i])) {
                        $actividad = Actividad::find()->where('id=:id', [':id' => $proyecto->actividades_ids_1[$i]])->one();
                        $actividad->descripcion = $proyecto->actividades_1[$i];
                        $actividad->update();
                    } elseif (trim($proyecto->actividades_1[$i])) {
                        $actividad = new Actividad;
                        $actividad->objetivo_especifico_id = $objetivoespecifico1->id;
                        $actividad->descripcion = $proyecto->actividades_1[$i];
                        $actividad->estado = 1;
                        $actividad->save();
                    }
                }
            }

            if (trim($proyecto->objetivo_especifico_2) != '') {
                if (isset($proyecto->objetivo_especifico_2_id)) {
                    $objetivoespecifico2 = ObjetivoEspecifico::find()->where('id=:id', [':id' => $proyecto->objetivo_especifico_2_id])->one();
                    $objetivoespecifico2->descripcion = $proyecto->objetivo_especifico_2;
                    $objetivoespecifico2->update();
                } else {
                    $objetivoespecifico2 = new ObjetivoEspecifico;
                    $objetivoespecifico2->proyecto_id = $proyecto->id;
                    $objetivoespecifico2->descripcion = $proyecto->objetivo_especifico_2;
                    $objetivoespecifico2->save();
                }

                for ($i = 0; $i < $countActividades2; $i++) {
                    if (isset($proyecto->actividades_ids_2[$i]) && trim($proyecto->actividades_2[$i])) {
                        $actividad = Actividad::find()->where('id=:id', [':id' => $proyecto->actividades_ids_2[$i]])->one();
                        $actividad->descripcion = $proyecto->actividades_2[$i];
                        $actividad->update();
                    } elseif (trim($proyecto->actividades_2[$i])) {
                        $actividad = new Actividad;
                        $actividad->objetivo_especifico_id = $objetivoespecifico2->id;
                        $actividad->descripcion = $proyecto->actividades_2[$i];
                        $actividad->estado = 1;
                        $actividad->save();
                    }
                }
            }

            if (trim($proyecto->objetivo_especifico_3) != '') {

                if (isset($proyecto->objetivo_especifico_3_id)) {
                    $objetivoespecifico3 = ObjetivoEspecifico::find()->where('id=:id', [':id' => $proyecto->objetivo_especifico_3_id])->one();
                    $objetivoespecifico3->descripcion = $proyecto->objetivo_especifico_3;
                    $objetivoespecifico3->update();
                } else {
                    $objetivoespecifico3 = new ObjetivoEspecifico;
                    $objetivoespecifico3->proyecto_id = $proyecto->id;
                    $objetivoespecifico3->descripcion = $proyecto->objetivo_especifico_3;
                    $objetivoespecifico3->save();
                }
                //var_dump($countActividades3);die;
                for ($i = 0; $i < $countActividades3; $i++) {
                    if (isset($proyecto->actividades_ids_3[$i]) && trim($proyecto->actividades_3[$i])) {
                        $actividad = Actividad::find()->where('id=:id', [':id' => $proyecto->actividades_ids_3[$i]])->one();
                        $actividad->descripcion = $proyecto->actividades_3[$i];
                        $actividad->update();
                    } elseif (trim($proyecto->actividades_3[$i])) {

                        $actividad = new Actividad;
                        $actividad->objetivo_especifico_id = $objetivoespecifico3->id;
                        $actividad->descripcion = $proyecto->actividades_3[$i];
                        $actividad->estado = 1;
                        $actividad->save();
                    }
                }
            }

            /* Plan presupuestal */
            for ($i = 0; $i < $countPlanesPresupuestalesCantidades; $i++) {

                if (isset($proyecto->planes_presupuestal_ids[$i])) {
                    $planpresupuestal = PlanPresupuestal::find()->where('id=:id', [':id' => $proyecto->planes_presupuestal_ids[$i]])->one();
                    $planpresupuestal->actividad_id = $proyecto->planes_presupuestales_actividades;
                    $planpresupuestal->recurso_descripcion = $proyecto->planes_presupuestales_recursos_descripciones[$i];
                    $planpresupuestal->unidad = $proyecto->planes_presupuestales_unidades[$i];
                    $planpresupuestal->dirigido = $proyecto->planes_presupuestales_dirigidos[$i];
                    $planpresupuestal->como_conseguirlo = $proyecto->planes_presupuestales_comos_conseguirlos[$i];
                    $planpresupuestal->precio_unitario = str_replace("S/.", "", $proyecto->planes_presupuestales_precios_unitarios[$i]);
                    $planpresupuestal->cantidad = $proyecto->planes_presupuestales_cantidades[$i];
                    $planpresupuestal->subtotal = str_replace("S/.", "", $proyecto->planes_presupuestales_subtotales[$i]);
                    $planpresupuestal->update();
                } else {

                    //var_dump($proyecto->planes_presupuestales_precios_unitarios[$i]);die;
                    $planpresupuestal = new PlanPresupuestal;
                    $planpresupuestal->actividad_id = $proyecto->planes_presupuestales_actividades;
                    $planpresupuestal->recurso_descripcion = $proyecto->planes_presupuestales_recursos_descripciones[$i];
                    //$planpresupuestal->unidad = $proyecto->planes_presupuestales_unidades[$i];
                    $planpresupuestal->dirigido = $proyecto->planes_presupuestales_dirigidos[$i];
                    $planpresupuestal->como_conseguirlo = $proyecto->planes_presupuestales_comos_conseguirlos[$i];
                    $planpresupuestal->precio_unitario = str_replace("S/.", "", $proyecto->planes_presupuestales_precios_unitarios[$i]);
                    $planpresupuestal->cantidad = $proyecto->planes_presupuestales_cantidades[$i];
                    $planpresupuestal->subtotal = str_replace("S/.", "", $proyecto->planes_presupuestales_subtotales[$i]);
                    $planpresupuestal->estado = 1;
                    $planpresupuestal->save();
                }
            }

            /* Cronograma */
            for ($i = 0; $i < $countCronogramasFechasInicios; $i++) {
                $fecha_inicio = date("Y-m-d H:i:s");
                $fecha_fin = date("Y-m-d H:i:s");

                if (isset($proyecto->cronogramas_ids[$i])) {
                    $fecha_inicio = str_replace("/", "-", $proyecto->cronogramas_fechas_inicios[$i]);
                    $fecha_fin = str_replace("/", "-", $proyecto->cronogramas_fechas_fines[$i]);

                    $cronograma = Cronograma::find()->where('id=:id', [':id' => $proyecto->cronogramas_ids[$i]])->one();
                    $cronograma->actividad_id = $proyecto->cronogramas_actividades;
                    $cronograma->tarea = $proyecto->cronogramas_tareas[$i];
                    $cronograma->responsable_id = $proyecto->cronogramas_responsables[$i];
                    $cronograma->fecha_inicio = date("Y-m-d", strtotime($fecha_inicio));
                    $cronograma->fecha_fin = date("Y-m-d", strtotime($fecha_fin));
                    $cronograma->save();
                } else {
                    $fecha_inicio = str_replace("/", "-", $proyecto->cronogramas_fechas_inicios[$i]);
                    $fecha_fin = str_replace("/", "-", $proyecto->cronogramas_fechas_fines[$i]);

                    $cronograma = new Cronograma;
                    $cronograma->actividad_id = $proyecto->cronogramas_actividades;
                    $cronograma->tarea = $proyecto->cronogramas_tareas[$i];
                    $cronograma->responsable_id = $proyecto->cronogramas_responsables[$i];
                    $cronograma->fecha_inicio = date("Y-m-d", strtotime($fecha_inicio));
                    $cronograma->fecha_fin = date("Y-m-d", strtotime($fecha_fin));
                    $cronograma->estado = 1;
                    $cronograma->save();
                }
            }

            /* Resultado */
            for ($i = 0; $i < $countResultadosEsperados; $i++) {

                if (isset($proyecto->resultados_ids[$i])) {
                    $actividad = Actividad::find()->where('id=:id', [':id' => $proyecto->resultados_ids[$i]])->one();
                    $actividad->resultado_esperado = $proyecto->resultados_esperados[$i];
                    $actividad->update();
                }
            }

            $video->archivo = UploadedFile::getInstance($video, 'archivo');

            if ($video->archivo) {

                $video->proyecto_id = $proyecto->id;
                $video->etapa = 0;
                $video->save();
                $videoup = Video::findOne($video->id);
                $videoup->ruta = $video->id . '.' . $video->archivo->extension;
                $videoup->tipo = 2;
                $videoup->update();
                $video->archivo->saveAs('video_carga/' . $videoup->id . '.' . $video->archivo->extension);
            } elseif ($proyecto->ruta) {
                $video->proyecto_id = $proyecto->id;
                $video->etapa = 0;
                $video->save();
                $videoup = Video::findOne($video->id);
                $videoup->ruta = $proyecto->ruta;
                $videoup->tipo = 1;
                $videoup->update();
            }

            $foro = Foro::find()->where('proyecto_id=:proyecto_id', [':proyecto_id' => $proyecto->id])->one();

            if ($foro && $newComentario->load(Yii::$app->request->post()) && trim($newComentario->contenido) != '') {
                $newComentario->foro_id = $foro->id;
                $newComentario->save();
            }

            $proyecto->archivo = UploadedFile::getInstance($proyecto, 'archivo');
            $proyecto->archivo2 = UploadedFile::getInstance($proyecto, 'archivo2');
            if ($etapa->etapa == 1 && $proyecto->archivo) {

                $proyecto->proyecto_archivo = $proyecto->id . '.' . $proyecto->archivo->extension;
                $proyecto->formato_proyecto = 1; //formato en documento
                $proyecto->update();
                $proyecto->archivo->saveAs('proyectos/' . $proyecto->proyecto_archivo);
            } elseif ($etapa->etapa == 2 && $proyecto->archivo2) {
                $proyecto->proyecto_archivo2 = $proyecto->id . '_2.' . $proyecto->archivo2->extension;
                $proyecto->formato_proyecto2 = 1; //formato en documento
                $proyecto->update();
                $proyecto->archivo2->saveAs('proyectos/' . $proyecto->proyecto_archivo2);
            }


            return \Yii::$app->getResponse()->refresh();
        }

        if ($this->entrega == 1) {
            $disabled = 'disabled';
            $videoprimera = VideoCopia::find()->where('proyecto_id=:proyecto_id and etapa in (0,1)', [':proyecto_id' => $proyecto->id])->one();
            $videosegunda = VideoCopia::find()->where('proyecto_id=:proyecto_id and etapa in (0,2)', [':proyecto_id' => $proyecto->id])->one();
        } else {
            $videoprimera = NULL;
            $videosegunda = NULL;
        }
        /*
          if($this->entrega==1)
          {
          $disabled='disabled';
          //$videoprimera=Video::find()->where('proyecto_id=:proyecto_id and etapa in (0,1)',[':proyecto_id'=>$proyecto->id])->one();
          //$videosegunda=Video::find()->where('proyecto_id=:proyecto_id and etapa in (0,2)',[':proyecto_id'=>$proyecto->id])->one();
          $videoprimera=Video::find()->where('proyecto_id=:proyecto_id and etapa in (0,1)',[':proyecto_id'=>$proyecto->id])->one();
          $videosegunda=Video::find()->where('proyecto_id=:proyecto_id and etapa in (0,2)',[':proyecto_id'=>$proyecto->id])->one();
          }
          else
          {
          $videoprimera=NULL;
          $videosegunda=NULL;
          } */

        if ($equipo->etapa == 2) {
            $disabled = 'disabled';
        }



        return $this->render('actualizar', ['proyecto' => $proyecto,
                    'objetivos_especificos' => $objetivos_especificos,
                    'actividades' => $actividades,
                    'actividades1' => $actividades1,
                    'actividades2' => $actividades2,
                    'actividades3' => $actividades3,
                    'disabled' => $disabled,
                    'equipo' => $equipo,
                    'integrante' => $integrante,
                    'video' => $video,
                    'videoprimera' => $videoprimera,
                    'videosegunda' => $videosegunda,
                    'entrega' => $this->entrega,
                    'etapa' => $etapa,
                    'estudiante' => $estudiante,
                    'institucion' => $institucion,
                    'comen_monitores' => $comen_monitores,
                    'comen_participantes' => $comen_participantes]);
    }

    public function rename_win($oldfile, $newfile) {
        if (!rename($oldfile, $newfile)) {
            if (copy($oldfile, $newfile)) {
                unlink($oldfile);
                return TRUE;
            }
            return FALSE;
        }
        return TRUE;
    }

}
