<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Resultados;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use app\models\Asunto_categoria;

/* @var $this \yii\web\View */
/* @var $user \common\models\LoginForm */
/* @var $title string */
$contoe = 0;
$acti1 = 0;
$acti2 = 0;
$acti3 = 0;
?>
<script type="text/javascript" src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/3.3.2/bootstrap.min.js"></script>

<script type="text/javascript" src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/master/material.min.js"></script>
<script type="text/javascript" src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/moments/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<style>.image-upload > input
    {
        display: none;
    }

    .image-upload img
    {
        width: 80px;
        cursor: pointer;
    }
    label{
        display:inline-block !important ;
        max-width:100% !important;
        margin-bottom:5px !important;
        font-size:14px !important;
        font-weight:700 !important;
        color:#1f2a69 !important;
    }
    .form-control
    {
        color:#59595b !important;
        font-size:14px !important;
    }

    ul #oespe{
        content: "";
        list-style: none; 
    }
    ul #act{
        content: "";
        list-style: none; 
    }
    /*
    li {
        
    }*/
    #oespe::before
    {
        padding-right: 5px;
        content: "\25BA";
    }
    #act::before
    {
        padding-right: 5px;
        content: "\25CF";
    }

    #act
    {
        padding-top:10px;
        padding-bottom:10px;
    }
</style>





<?php $form = ActiveForm::begin(['options' => ['id' => 'form_actualizar', 'enctype' => 'multipart/form-data']]); ?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_project_big.png" alt="">MI PROYECTO <?= ($equipo->etapa == 1 || $equipo->etapa == 2) ? '(Segunda entrega)' : '' ?>
</div>
<input type="hidden" name="Proyecto[tab_active_pro]" id="tab_active_pro"/>
<div class="box_content contenido_seccion_crear_equipo">
    <div class="row">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" style="background: white;">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Datos generales</a></li>
                <li class=""><a href="#tab_9" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Objetivos y actividades</a></li>
                <!--<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Resultado</a></li>-->
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Recursos</a></li>
                <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Cronograma</a></li>
                <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"  style="color: #333 !important">Mi video</a></li>
                <?php if ($equipo->etapa == 1 && $estudiante->grado != 6) { ?>
                    <!--<li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false" style="color: #333 !important" >Reflexión</a></li>-->
                    <li class=""><a href="#tab_15" data-toggle="tab" aria-expanded="false" style="color: #333 !important" >Reflexión</a></li>
                <?php } ?>
                <?php if (($etapa->etapa == 2 || $etapa->etapa == 3) && $estudiante->grado != 6) { ?>
                    <!--<li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Mi evaluación</a></li>-->
                    <!--<li class=""><a href="#tab_8" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Foro</a></li>-->
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-titulo required">
                            <label class="control-label" for="proyecto-titulo">Nombre del proyecto </label>
                            <input type="text" id="proyecto-titulo" class="form-control" name="Proyecto[titulo]" maxlength="200" title="Máximo 200 palabras" value="<?= htmlentities($proyecto->titulo) ?>" disabled <?php //= $disabled                                         ?>>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-titulo required" >
                            <label class="control-label" for="proyecto-categoria">Categoría de Asunto Público:</label>


                            <?php
                            $resultados = Asunto_categoria::find()->where('id=:region_id', ['region_id' => $equipo->asunto->categoria_id])->one();
                            if ($equipo->asunto_id != '') {
                                ?>


                                <input type="text" id="proyecto-categoria" class="form-control" name="Proyecto[categoria]" maxlength="200" title="Máximo 200 palabras" value=" <?= $resultados->descripcion_categoria ?>" disabled <?php //= $disabled                                         ?>>

                            <?php } ?>



                        </div>
                        <div class="form-group label-floating field-equipo-asunto_id required" >
                            <label class="control-label" for="proyecto-asunto_id">Asunto Público sobre el que trabajará tu equipo</label>

                            <?php
                            //$resultados = Asunto_categoria::find()->where('id=:region_id', ['region_id' => $equipo->asunto->categoria_id])->one();
                            if ($equipo->asunto_id != '') {
                                ?>


                                <input type="text" id="proyecto-asunto_id" class="form-control" name="Proyecto[categoria]" maxlength="200" title="Máximo 200 palabras" value=" <?= $equipo->asunto->descripcion_cabecera ?>" disabled <?php //= $disabled                                         ?>>

                            <?php } ?>



                        </div>                            
                    </div>
                    <div class="clearfix"></div>    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-resumen required">
                            <label class="control-label" for="proyecto-resumen" >Resumen del proyecto <span style="font-weight: normal !important;">(máximo 500 caracteres)</span></label>
                            <textarea id="proyecto-resumen" class="form-control" name="Proyecto[resumen]" rows="3"  maxlength="500"  <?= $disabled ?> ><?= htmlentities($proyecto->resumen) ?></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-beneficiario required">
                            <label class="control-label" for="proyecto-beneficiario">Objetivo general <span style="font-weight: normal !important;">(máximo 500 caracteres)</span></label>
                            <textarea id="proyecto-beneficiario" class="form-control" name="Proyecto[beneficiario]" rows="3" maxlength="500"  <?= $disabled ?> ><?= htmlentities($proyecto->beneficiario) ?></textarea>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <!--<div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-archivo required" >
                            <input class="form-control" type="file" id="proyecto-archivo"  name="Proyecto[archivo]" onchange="Documento(this)"/>
                            <div class="input-group">
                                <input type="text" readonly="" class="form-control" >
                                  <span class="input-group-btn input-group-sm">
                                    <button type="button" class="btn btn-fab btn-fab-mini glyphicon glyphicon-paperclip">
                                      <i class="material-icons">archivo</i>
                                    </button>
                                  </span>
                            </div>
                        </div>
                    </div>
                    -->
                    <div class="col-xs-12 col-sm-12 col-md-12" >

                        <?php //if(($proyecto->formato_proyecto=='' || $proyecto->formato_proyecto==0) && $integrante->rol==1 && $etapa->etapa==1){   ?>
                        <!--<div class="form-group" style="background: #F0EFF1">
                            <p class="text-justify" style="margin-left: 20px;margin-bottom: 0px;margin-top: 20px;padding-top: 10px">Tambien puedes subir tu proyecto:</p>
                            <div class="col-xs-12 col-sm-4 col-md-4"></div>
                            <div class="col-xs-12 col-sm-4 col-md-4 text-center">
                                    <input type="file" id="proyecto-archivo"  name="Proyecto[archivo]" />
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>-->
                        <?php if ($proyecto->formato_proyecto == 1 && ($equipo->etapa == 2 || $equipo->etapa == 1 || $equipo->etapa == 0 || $equipo->etapa == NULL)) { ?>
                            <div class="form-group" style="background: #F0EFF1">
                                <p class="text-justify" style="margin: 20px;padding-top: 10px"></p>
                                <div class="col-xs-12 col-sm-4 col-md-4"></div>
                                <div class="col-xs-12 col-sm-4 col-md-4 text-center">
                                    <a href="<?= \Yii::$app->request->BaseUrl ?>/proyectos/<?= $proyecto->proyecto_archivo ?>" target="_blank" class=" btn-lateral"><img height=22px src="<?= \Yii::$app->request->BaseUrl ?>/img/pdf.png"> Primera entrega</a>
                                </div>
                                <div class="clearfix"></div>
                            </div><!--César has cambiado el elseif agregandole && $equipo->etapa==1 recuerda 22062016-->
                        <?php } ?>
                        <?php if (($proyecto->formato_proyecto2 == '' || $proyecto->formato_proyecto2 == 0) && $integrante->rol == 1 && ($etapa->etapa == 2) && $equipo->etapa == 1) { ?>
                            <div class="form-group" style="background: #F0EFF1">
                                <p class="text-justify" style="margin-left: 20px;margin-bottom: 0px;margin-top: 20px;padding-top: 10px">Tambien puedes subir tu proyecto:</p>
                                <div class="col-xs-12 col-sm-4 col-md-4"></div>
                                <div class="col-xs-12 col-sm-4 col-md-4 text-center">
                                    <input type="file" id="proyecto-archivo2"  name="Proyecto[archivo2]" />
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php } elseif ($proyecto->formato_proyecto2 == 1 && ($etapa->etapa == 2)) { ?>
                            <div class="form-group" style="background: #F0EFF1">
                                <p class="text-justify" style="margin: 20px;padding-top: 10px">Haz subido tu proyecto en el formato simplificado:</p>
                                <div class="col-xs-12 col-sm-4 col-md-4"></div>
                                <div class="col-xs-12 col-sm-4 col-md-4 text-center">
                                    <a href="<?= \Yii::$app->request->BaseUrl ?>/proyectos/<?= $proyecto->proyecto_archivo2 ?>" target="_blank" class=" btn-lateral"><img height=22px src="<?= \Yii::$app->request->BaseUrl ?>/img/pdf.png"> Segunda entrega</a> <?= ($equipo->etapa != 2) ? '<span style="cursor: pointer;color: red" onclick="EliminarArchivo(' . $proyecto->id . ')"><b>(x)</b></span>' : ''; ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_9">
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php if ($disabled == 'disabled') { ?>
                            <h4><b>Objetivos Específicos</b>  </h4>
                        <?php } else { ?>
                            <h4><b>Objetivos Específicos</b> <span class="glyphicon glyphicon-plus-sign" style="cursor: pointer" title="Haga clic para añadir objetivos"  onclick="agregarObjetivoActividad()" <?= $disabled ?>></span></h4>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div id="mostrar_oe_actividades">
                            <div id="oe_1" class='col-xs-12 col-sm-12 col-md-12'>
                                <?php if ($proyecto->objetivo_especifico_1) { ?>
                                    <ul>
                                        <li id='oespe'><b>Objetivo Específico N° 1: <?= htmlentities($proyecto->objetivo_especifico_1) ?></b> <?= ($disabled == 'disabled') ? '' : "<span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar(1)'></span>" ?>  </li>
                                        <input type='hidden' value='<?= htmlentities($proyecto->objetivo_especifico_1, ENT_QUOTES) ?>' name='Proyecto[objetivo_especifico_1]'>
                                        <ul>
                                            <?php foreach ($actividades as $actividad) { ?>
                                                <?php if ($actividad->objetivo_especifico_id == $proyecto->objetivo_especifico_1_id) { ?>
                                                    <li id='act'>Actividad: <?= htmlentities($actividad->descripcion) ?><input type='hidden' value='<?= htmlentities($actividad->descripcion, ENT_QUOTES) ?>' name='Proyecto[actividades_1][]'></li>
                                                    <input id="proyecto-actividades_ids_1_<?= $acti1 ?>" type="hidden" name="Proyecto[actividades_ids_1][]" placeholder="Actividad" value="<?= htmlentities($actividad->actividad_id) ?>" />
                                                    <?php
                                                    $acti1 ++;
                                                }
                                                ?>
                                            <?php } ?>
                                        </ul>
                                    </ul>
                                    <?php $contoe = 1; ?>
                                <?php } ?>
                            </div>

                            <div id="oe_2" class='col-xs-12 col-sm-12 col-md-12'>
                                <?php if ($proyecto->objetivo_especifico_2) { ?>
                                    <ul>
                                        <li id='oespe'><b>Objetivo Específico N° 2: <?= htmlentities($proyecto->objetivo_especifico_2) ?></b> <?= ($disabled == 'disabled') ? '' : "<span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar(2)'></span>" ?> </li>
                                        <input type='hidden' value='<?= htmlentities($proyecto->objetivo_especifico_2, ENT_QUOTES) ?>' name='Proyecto[objetivo_especifico_2]'>
                                        <ul>
                                            <?php foreach ($actividades as $actividad) { ?>
                                                <?php if ($actividad->objetivo_especifico_id == $proyecto->objetivo_especifico_2_id) { ?>
                                                    <li id='act'>Actividad: <?= htmlentities($actividad->descripcion) ?><input type='hidden' value='<?= htmlentities($actividad->descripcion, ENT_QUOTES) ?>' name='Proyecto[actividades_2][]'></li>
                                                    <input id="proyecto-actividades_ids_2_<?= $acti2 ?>" type="hidden" name="Proyecto[actividades_ids_2][]" placeholder="Actividad" value="<?= htmlentities($actividad->actividad_id) ?>" />
                                                    <?php
                                                    $acti2++;
                                                }
                                                ?>
                                            <?php } ?>
                                        </ul>
                                    </ul>
                                    <?php $contoe = 2; ?>
                                <?php } ?>
                            </div>

                            <div id="oe_3" class='col-xs-12 col-sm-12 col-md-12'>
                                <?php if ($proyecto->objetivo_especifico_3) { ?>
                                    <ul>
                                        <li id='oespe'><b>Objetivo Específico N° 3: <?= htmlentities($proyecto->objetivo_especifico_3) ?></b> <?= ($disabled == 'disabled') ? '' : "<span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar(3)'></span>" ?> </li>
                                        <input type='hidden' value='<?= htmlentities($proyecto->objetivo_especifico_3, ENT_QUOTES) ?>' name='Proyecto[objetivo_especifico_3]'>
                                        <ul>
                                            <?php foreach ($actividades as $actividad) { ?>
                                                <?php if ($actividad->objetivo_especifico_id == $proyecto->objetivo_especifico_3_id) { ?>
                                                    <li id='act'>Actividad: <?= htmlentities($actividad->descripcion) ?><input type='hidden' value='<?= htmlentities($actividad->descripcion, ENT_QUOTES) ?>' name='Proyecto[actividades_3][]'></li>
                                                    <input id="proyecto-actividades_ids_3_<?= $acti3 ?>" type="hidden" name="Proyecto[actividades_ids_3][]" placeholder="Actividad" value="<?= htmlentities($actividad->actividad_id) ?>" />
                                                    <?php
                                                    $acti3++;
                                                }
                                                ?>
                                            <?php } ?>
                                        </ul>
                                    </ul>
                                    <?php $contoe = 3; ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_2">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <table class="table table-striped table-hover">
                            <thead>
                            <th>Actividad</th>
                            <th>Resultado</th>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                <?php foreach ($actividades as $actividad) { ?>
                                    <tr>
                                        <td style="vertical-align: middle"><?= htmlentities($actividad->descripcion) ?></td>
                                        <td style="padding: 2px">
                                            <div class="form-group field-proyecto-resultado_esperado_<?= $i ?> required" style="margin-top: 0px">
                                                <input type="hidden"  class="form-control" name="Proyecto[resultados_ids][]" value="<?= $actividad->actividad_id ?>" >
                                                <input type="text" id="proyecto-resultado_esperado_<?= $i ?>" class="form-control " name="Proyecto[resultados_esperados][]" placeholder="Resultado #<?= $i ?>" value="<?= htmlentities($actividad->resultado_esperado) ?>" <?= $disabled ?> >
                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <?= \app\widgets\planpresupuestal\PlanPresupuestalWidget::widget(['proyecto_id' => $proyecto->id, 'disabled' => $disabled]); ?> 
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_4">
                    <?= \app\widgets\cronograma\CronogramaWidget::widget(['proyecto_id' => $proyecto->id, 'disabled' => $disabled]); ?> 
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_5">
                    <div class="clearfix"></div>
                    <?php if ($integrante->rol == 1 && !$disabled) { ?>

                        <?php if ($video->ruta) { ?>
                            <div class="col-xs-12 col-sm-3 col-md-3">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <?php
                                if ($video->ruta && $video->tipo == 1) {
                                    $url = $video->ruta;
                                    parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
                                    $v_variable = "";
                                    if (!empty($my_array_of_vars['v'])) {
                                        $v_variable = $my_array_of_vars['v'];
                                    }
                                    ?>
                                    <br>
                                    <iframe type="text/html" 
                                            width="320" 
                                            height="240" 
                                            src="https://www.youtube.com/embed/<?= $v_variable ?>" 
                                            frameborder="0">
                                    </iframe>
                                <?php } elseif ($video->tipo == 2) { ?>
                                    <video width="320" height="240" controls>
                                        <source src="<?= Yii::getAlias('@video') . $video->ruta ?>" >  
                                    </video>
                                <?php } ?>






                                <div class="radio">
                                    <label>
                                        <input checked type="radio" id="video-link" name="video" ><span class="circle"></span><span class="check"></span>
                                        Copiar link de YouTube
                                    </label>
                                </div>
                                <div class="form-group label-floating field-proyecto-ruta required" ">
                                    <label class="control-label" for="proyecto-ruta" >Link youtube</label>
                                    <input id="videoproyec" type="text" class="form-control" name="Proyecto[ruta]" maxlength="450">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-xs-12 col-sm-3 col-md-3">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="radio">
                                    <label>
                                        <input checked type="radio" id="video-link" name="video" ><span class="circle"></span><span class="check"></span>
                                        Copiar link de YouTube
                                    </label>
                                </div>
                                <div class="form-group label-floating field-proyecto-ruta required" >
                                    <label class="control-label" for="proyecto-ruta" >Link youtube</label>
                                    <input id="videoproyec"  type="text" class="form-control" name="Proyecto[ruta]" maxlength="450">
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <?php if ($integrante->rol == 1 && $disabled && $videoprimera) { ?>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <video width="320" height="240" controls>
                                <source src="<?= Yii::getAlias('@video') . $videoprimera->ruta ?>" >  
                            </video>
                        </div>
                    <?php } ?>

                    <?php if ($integrante->rol == 2 && $disabled && !$videoprimera && !$videosegunda) { ?>
                        <?php //var_dump($videoprimera);die;   ?>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">

                            <?php if ($video->ruta && $video->tipo == 1) { ?>
                                <br>
                                <iframe type="text/html" 
                                        width="320" 
                                        height="240" 
                                        src="https://www.youtube.com/embed/<?= substr($video->ruta, -11) ?>" 
                                        frameborder="0">
                                </iframe>
                            <?php } elseif ($video->tipo == 2) { ?>
                                <video width="320" height="240" controls>
                                    <source src="<?= Yii::getAlias('@video') . $video->ruta ?>" >  
                                </video>
                            <?php } ?>

                        </div>
                    <?php } ?>

                    <?php if ($integrante->rol == 2 && $disabled && $videoprimera) { ?>
                        <?php //var_dump($videoprimera);die;   ?>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <video width="320" height="240" controls>
                                <source src="<?= Yii::getAlias('@video') . $videoprimera->ruta ?>" >  
                            </video>
                        </div>
                    <?php } ?>

                    <?php if ($integrante->rol == 2 && $videosegunda) { ?>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <video width="320" height="240" controls>
                                <source src="<?= Yii::getAlias('@video') . $videosegunda->ruta ?>" >  
                            </video> 
                        </div>
                    <?php } ?>

                    <div class="clearfix"></div>

                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_6">
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-p1 required">
                            <label class="control-label" for="proyecto-p1" style="padding-left: 10px">Como equipo ¿Cómo se han sentido al trabajar su proyecto?</label>
                            <textarea style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p1" class="form-control" rows="3" name="Proyecto[p1]"  <?= $disabled ?>><?= $proyecto->p1 ?></textarea>
                        </div>
                        <div class="form-group label-floating field-proyecto-p2 required">
                            <label class="control-label" for="proyecto-p2" style="padding-left: 10px">¿Qué debilidades encuentras en tu escuela o comunidad para trabajar tu proyecto?</label>
                            <textarea style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p2" class="form-control" rows="3" name="Proyecto[p2]"  <?= $disabled ?>><?= $proyecto->p2 ?></textarea>
                        </div>
                        <div class="form-group label-floating field-proyecto-p3 required">
                            <label class="control-label" for="proyecto-p3" style="padding-left: 10px"> ¿Qué fortalezas encuentras en tu escuela o comunidad para trabajar tu proyecto?</label>
                            <textarea style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p3" class="form-control" rows="3" name="Proyecto[p3]"  <?= $disabled ?>><?= $proyecto->p3 ?></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.tab-pane -->
                <?php if ($equipo->etapa == 1) { ?>
                    <div class="tab-pane" id="tab_15">
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                            <label>1.- Aportes del equipo MINEDU</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-p4 required">
                                <label class="control-label" for="proyecto-p4" >¿Qué aportes incluyeron en su proyecto participativo?</label>
                                <!--<textarea style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p1" class="form-control" rows="3" name="Proyecto[p1]"  </textarea>-->
                                <select style="border: 2px solid #1f2a69;padding: 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p4" class="form-control" name="Proyecto[p4]" <?= $disabled ?> />
                                <option value=""></option>
                                <?php
                                if ($comen_monitores)
                                    foreach ($comen_monitores as $comen_monitor) {
                                        ?>
                                        <option value="<?= $comen_monitor->id ?>" <?= ($comen_monitor->id == $proyecto->p4) ? 'selected' : '' ?>><?= $comen_monitor->contenido ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group label-floating field-proyecto-p2 required">
                                <label class="control-label" for="proyecto-p2" >¿Qué debilidades encuentras en tu escuela o comunidad para trabajar tu proyecto?</label>
                                <div class="col-md-6">
                                    <input type="checkbox" id="proyecto-p5_1" name="Proyecto[p5_1]" value="1" <?= ($proyecto->p5_1 == 1) ? 'checked' : '' ?> onclick="Check('5', '1')">Título<br>
                                    <input type="checkbox" id="proyecto-p5_2" name="Proyecto[p5_2]" value="1" <?= ($proyecto->p5_2 == 1) ? 'checked' : '' ?> onclick="Check('5', '2')">Resumen<br>
                                    <input type="checkbox" id="proyecto-p5_3" name="Proyecto[p5_3]" value="1" <?= ($proyecto->p5_3 == 1) ? 'checked' : '' ?> onclick="Check('5', '3')">Objetivo General<br>
                                    <input type="checkbox" id="proyecto-p5_4" name="Proyecto[p5_4]" value="1" <?= ($proyecto->p5_4 == 1) ? 'checked' : '' ?> onclick="Check('5', '4')">Objetivos
                                </div>
                                <div class="col-md-6">
                                    <input type="checkbox" id="proyecto-p5_5" name="Proyecto[p5_5]" value="1" <?= ($proyecto->p5_5 == 1) ? 'checked' : '' ?> onclick="Check('5', '5')">Actividades<br>
                                    <input type="checkbox" id="proyecto-p5_6" name="Proyecto[p5_6]" value="1" <?= ($proyecto->p5_6 == 1) ? 'checked' : '' ?> onclick="Check('5', '6')">Cronograma<br>
                                    <input type="checkbox" id="proyecto-p5_7" name="Proyecto[p5_7]" value="1" <?= ($proyecto->p5_7 == 1) ? 'checked' : '' ?> onclick="Check('5', '7')">Presupuesto<br>
                                    <input type="checkbox" id="proyecto-p5_8" name="Proyecto[p5_8]" value="1" <?= ($proyecto->p5_8 == 1) ? 'checked' : '' ?> onclick="Check('5', '8')">Video
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                            <label>2.- Aportes de otros participantes</label>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-p6 required">
                                <label class="control-label" for="proyecto-p6" >¿Qué aportes incluyeron en su proyecto participativo? (el que más influyó en su proyecto)</label>
                                <!--<textarea style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p1" class="form-control" rows="3" name="Proyecto[p1]"  </textarea>-->
                                <select style="border: 2px solid #1f2a69;padding: 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p6" class="form-control" name="Proyecto[p6]" <?= $disabled ?> />
                                <option value=""></option>
                                <?php
                                if ($comen_participantes)
                                    foreach ($comen_participantes as $comen_participante) {
                                        ?>
                                        <option value="<?= $comen_participante->id ?>" <?= ($comen_participante->id == $proyecto->p6) ? 'selected' : '' ?> ><?= $comen_participante->contenido ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group label-floating field-proyecto-p7 required">
                                <label class="control-label" for="proyecto-p7" >¿Qué debilidades encuentras en tu escuela o comunidad para trabajar tu proyecto?</label>
                                <div class="col-md-6">
                                    <input type="checkbox" id="proyecto-p7_1" name="Proyecto[p7_1]"  <?= ($proyecto->p7_1 == 1) ? 'checked' : '' ?> onclick="Check('7', '1')">Título<br>
                                    <input type="checkbox" id="proyecto-p7_2" name="Proyecto[p7_2]"  <?= ($proyecto->p7_2 == 1) ? 'checked' : '' ?> onclick="Check('7', '2')">Resumen<br>
                                    <input type="checkbox" id="proyecto-p7_3" name="Proyecto[p7_3]"  <?= ($proyecto->p7_3 == 1) ? 'checked' : '' ?> onclick="Check('7', '3')">Objetivo General<br>
                                    <input type="checkbox" id="proyecto-p7_4" name="Proyecto[p7_4]"  <?= ($proyecto->p7_4 == 1) ? 'checked' : '' ?> onclick="Check('7', '4')">Objetivos
                                </div>
                                <div class="col-md-6">
                                    <input type="checkbox" id="proyecto-p7_5" name="Proyecto[p7_5]"  <?= ($proyecto->p7_5 == 1) ? 'checked' : '' ?> onclick="Check('7', '5')">Actividades<br>
                                    <input type="checkbox" id="proyecto-p7_6" name="Proyecto[p7_6]"  <?= ($proyecto->p7_6 == 1) ? 'checked' : '' ?> onclick="Check('7', '6')">Cronograma<br>
                                    <input type="checkbox" id="proyecto-p7_7" name="Proyecto[p7_7]"  <?= ($proyecto->p7_7 == 1) ? 'checked' : '' ?> onclick="Check('7', '7')">Presupuesto<br>
                                    <input type="checkbox" id="proyecto-p7_8" name="Proyecto[p7_8]"  <?= ($proyecto->p7_8 == 1) ? 'checked' : '' ?> onclick="Check('7', '8')">Video
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                            <label>3.- ¿Consideran importante los aportes entre equipos?</label>
                            <div class="col-md-12">
                                <input type="radio" name="Proyecto[p8]" value="1" <?= ($proyecto->p8 == 1) ? 'checked' : '' ?> >No, porque es un concurso<br>
                                <input type="radio" name="Proyecto[p8]" value="2" <?= ($proyecto->p8 == 2) ? 'checked' : '' ?> >No, porque ellos no saben cómo es mi proyecto<br>
                                <input type="radio" name="Proyecto[p8]" value="3" <?= ($proyecto->p8 == 3) ? 'checked' : '' ?>>Sí, porque me ayudó a mejorar mi proyecto<br>
                                <input type="radio" name="Proyecto[p8]" value="4" <?= ($proyecto->p8 == 4) ? 'checked' : '' ?>>Sí, porque todos nos ayudamos y mejoramos nuestra escuela, comunidad o región.
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div><!-- /.tab-pane -->
                <?php } ?>
                <?php if ($etapa->etapa == 1 || $etapa->etapa == 2 || $etapa->etapa == 3) { ?>

                    <div class="tab-pane" id="tab_7">
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-evaluacion required">
                                <label class="control-label" for="proyecto-evaluacion" style="padding-left: 10px">Evaluación</label>
                                <textarea id="proyecto-evaluacion" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" class="form-control" name="Proyecto[evaluacion]"  <?= ($equipo->etapa == 2) ? 'disabled' : ''; ?>><?= $proyecto->evaluacion ?></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div><!-- /.tab-pane -->
                <?php } ?>
                <?php if ($etapa->etapa == 2 || $etapa->etapa == 3) { ?>
                    <div class="tab-pane" id="tab_8">
                        <?php //= \app\widgets\foro\ForoWidget::widget(['proyecto_id'=>$proyecto->id]);     ?> 
                    </div><!-- /.tab-pane -->
                <?php } ?>
            </div><!-- /.tab-content -->
        </div>





        <div class="clearfix"></div>
        <!-- Objetivo Especifico general-->
        <div class="modal fade" id="objetivo_especifico_general" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="z-index: 2000 !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/vote_popup_close.png" alt=""></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="oe_modal">

                    </div>
                    <div class="modal-footer">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-default"  onclick='MostrarOeActividades()'>Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Objetivo Especifico general-->
        <div class="modal fade" id="objetivo_especifico_general_copia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="z-index: 2000 !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/vote_popup_close.png" alt=""></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="oe_modal_copia">

                    </div>
                    <div class="modal-footer" id="oe_modal_button">

                    </div>
                </div>
            </div>
        </div>

        <div style="border-top:2px dotted #f6de34 !important;">
            <?php if ($entrega != 1 && $estudiante->grado != 6) { ?>    
                <?php if ($disabled == '' && $equipo->etapa == 0) { ?>
                    <div class="col-xs-12 col-sm-4 col-md-4" >
                        <button type="button" id="btnproyecto" class="btn btn-default">Guardar</button>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 ">

                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 ">
                        <?= \app\widgets\entrega\EntregaWidget::widget(); ?>
                    </div>
                <?php } else if ($disabled && $equipo->etapa == 0) { ?>
                    <div class="col-xs-12 col-sm-4 col-md-4" >
                        <!--<button type="button" id="btnproyectoreflexion" class="btn btn-default">Guardar</button>-->
                    </div>
                <?php } else if ($equipo->etapa == 1 && $integrante->rol == 1) { ?>
                    <div class="col-xs-12 col-sm-4 col-md-4" >
                        <button type="button" id="btnproyectoevaluacion" class="btn btn-default">Guardar</button>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 "></div>
                    <div class="col-xs-12 col-sm-4 col-md-4 ">
                        <?= \app\widgets\entrega\EntregaWidget::widget(); ?> <!--Activar cuando se acabe la semana de foros-->
                    </div>


                <?php } else if ($equipo->etapa == 1 && $integrante->rol == 2) { ?>
                    <div class="col-xs-12 col-sm-4 col-md-4" >
                        <!--<button type="button" id="btnproyectoevaluacion" class="btn btn-default">Guardar</button>-->
                    </div>

                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>



<?php ActiveForm::end(); ?>

<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/jquery.form.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/kartik-v-bootstrap-fileinput/js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
     This must be loaded before fileinput.min.js -->
<script src="<?= \Yii::$app->request->BaseUrl ?>/kartik-v-bootstrap-fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>
<!-- purify.min.js is only needed if you wish to purify HTML content in your preview for HTML files.
     This must be loaded before fileinput.min.js -->
<script src="<?= \Yii::$app->request->BaseUrl ?>/kartik-v-bootstrap-fileinput/js/plugins/purify.min.js" type="text/javascript"></script>
<!-- the main fileinput plugin file -->
<script src="<?= \Yii::$app->request->BaseUrl ?>/kartik-v-bootstrap-fileinput/js/fileinput.min.js"></script>
<!-- bootstrap.js below is needed if you wish to zoom and view file content 
     in a larger detailed modal dialog -->
<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/3.3.6/bootstrap.min.js" type="text/javascript"></script>
<!-- optionally if you need a theme like font awesome theme you can include 
    it as mentioned below -->
<!-- optionally if you need translation for your language then include 
    locale file as mentioned below -->
<script src="<?= \Yii::$app->request->BaseUrl ?>/kartik-v-bootstrap-fileinput/js/locales/es.js"></script>

<?php
$this->registerJs(
        "$('document').ready(function(){})");
?>
<?php
$eliminaractividad = Yii::$app->getUrlManager()->createUrl('proyecto/eliminaractividad');
$reflexion = Yii::$app->getUrlManager()->createUrl('proyecto/reflexion');
$evaluacion = Yii::$app->getUrlManager()->createUrl('proyecto/evaluacion');
$archivo_pro = Yii::$app->getUrlManager()->createUrl('proyecto/archivo');
$archivo_pro2 = Yii::$app->getUrlManager()->createUrl('proyecto/archivo2');
$eliminararchivo_pro2 = Yii::$app->getUrlManager()->createUrl('proyecto/eliminar-archivo2');
?>
<!--var i=<?php //= $i                                       ?>;
    var a=<?php //= $a                                        ?>;
    var e=<?php //= $e                                        ?>;-->
<script>

                                $(document).ready(function ($) {

                                    $("#proyecto-archivo").fileinput({
                                        uploadUrl: "<?= $archivo_pro ?>", // server upload action
                                        uploadAsync: false,
                                        showUpload: false, // hide upload button
                                        showRemove: false, // hide remove button
                                        showPreview: false,
                                        showCaption: false,
                                        showCancel: false,
                                        browseLabel: 'Subir proyecto',
                                        minFileCount: 1,
                                        maxFileCount: 1,
                                        allowedFileExtensions: ['pdf']
                                    }).on("filebatchselected", function (event, files) {
                                        // trigger upload method immediately after files are selected
                                        $("#proyecto-archivo").fileinput("upload");
                                    }).on('filebatchuploadcomplete', function (event, data, previewId, index) {
                                        alert("Se ha subido tu proyecto satisfactoriamente");
                                        location.reload();
                                    }).on('fileerror', function (event, data, msg) {

                                        $.notify({
                                            message: "Solo se permite subir archivos con extensiones .pdf"
                                        }, {
                                            // settings
                                            type: 'danger',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                    });
                                    $("#proyecto-archivo2").fileinput({
                                        uploadUrl: "<?= $archivo_pro2 ?>", // server upload action
                                        uploadAsync: false,
                                        showUpload: false, // hide upload button
                                        showRemove: false, // hide remove button
                                        showPreview: false,
                                        showCaption: false,
                                        showCancel: false,
                                        browseLabel: 'Subir proyecto',
                                        minFileCount: 1,
                                        maxFileCount: 1,
                                        allowedFileExtensions: ['pdf']
                                    }).on("filebatchselected", function (event, files) {
                                        // trigger upload method immediately after files are selected
                                        $("#proyecto-archivo2").fileinput("upload");
                                    }).on('filebatchuploadcomplete', function (event, data, previewId, index) {
                                        //alert("Se ha subido tu proyecto satisfactoriamente");
                                        //debugger;
                                        // alert(data.response);
                                        // location.reload();
                                    }).on('filebatchuploadsuccess', function (event, data, previewId, index) {
                                        //alert("Se ha subido tu proyecto satisfactoriamente");

                                        if (data.response != "1") {
                                            $.notify({
                                                message: "Formato inválido"
                                            }, {
                                                type: 'danger',
                                                z_index: 1000000,
                                                placement: {
                                                    from: 'bottom',
                                                    align: 'right'
                                                },
                                            });
                                        } else {

                                            $.notify({
                                                message: 'Se ha subido tu proyecto satisfactoriamente'
                                            }, {
                                                type: 'success',
                                                z_index: 1000000,
                                                placement: {
                                                    from: 'bottom',
                                                    align: 'right'
                                                },
                                            });
                                            location.reload();
                                        }
                                        // location.reload();
                                    }).on('fileerror', function (event, data, msg) {

                                        $.notify({
                                            message: "Solo se permite subir archivos con extensiones .pdf"
                                        }, {
                                            // settings
                                            type: 'danger',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                    });
                                });
                                $("#video-nuevo").click(function (event) {
                                    $(".field-video-archivo").show();
                                    $(".field-proyecto-ruta").hide();
                                });
                                $("#video-link").click(function (event) {
                                    $(".field-proyecto-ruta").show();
                                    $(".field-video-archivo").hide();
                                });
                                $('.numerico').keypress(function (e) {

                                    tecla = (document.all) ? e.keyCode : e.which; // 2
                                    if (tecla == 8)
                                        return true; // 3
                                    var reg = /^[0-9\s]+$/;
                                    te = String.fromCharCode(tecla); // 5
                                    return reg.test(te); // 6

                                });
                                $('#btnproyectoreflexion').click(function (events) {
                                    var error = '';
                                    if (jQuery.trim($('#proyecto-reflexion').val()) == '')
                                    {
                                        error = error + 'ingrese una reflexión del proyecto <br>';
                                        $('.field-proyecto-reflexion').addClass('has-error');
                                    }
                                    else
                                    {
                                        $('.field-proyecto-reflexion').addClass('has-success');
                                        $('.field-proyecto-reflexion').removeClass('has-error');
                                    }

                                    if (error != '')
                                    {
                                        $.notify({
                                            message: error
                                        }, {
                                            type: 'danger',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                        return false;
                                    }
                                    else
                                    {
                                        $.ajax({
                                            url: '<?= $reflexion ?>',
                                            type: 'POST',
                                            async: true,
                                            data: {'Reflexion[reflexion]': $('#proyecto-reflexion').val(), 'Reflexion[proyecto_id]':<?= $proyecto->id ?>, 'Reflexion[user_id]':<?= \Yii::$app->user->id ?>},
                                            success: function (data) {
                                                $.notify({
                                                    message: 'Se ha guardado tu reflexión'
                                                }, {
                                                    type: 'success',
                                                    z_index: 1000000,
                                                    placement: {
                                                        from: 'bottom',
                                                        align: 'right'
                                                    },
                                                });
                                                setTimeout(function () {
                                                    window.location.reload(1);
                                                }, 1000);
                                            }
                                        });
                                        return true;
                                    }

                                });
                                $('#btnproyectoevaluacion').click(function (events) {

                                    if (validarCampos()) {
                                        // alert("Ingrese todos los campos vacíos");
                                    } else {
                                        $("#form_actualizar").submit();
                                    }


                                    /*
                                     var error = '';
                                     var etapa =<?= $etapa->etapa ?>;
                                     if (etapa == 2) {
                                     
                                     $.ajax({
                                     url: '<?= $evaluacion ?>',
                                     type: 'POST',
                                     async: true,
                                     data: {'Evaluacion[evaluacion]': $('#proyecto-evaluacion').val(), 'Evaluacion[proyecto_id]':<?= $proyecto->id ?>, 'Evaluacion[user_id]':<?= \Yii::$app->user->id ?>},
                                     success: function (data) {
                                     $.notify({
                                     message: 'Se ha guardado tu información'
                                     }, {
                                     type: 'success',
                                     z_index: 1000000,
                                     placement: {
                                     from: 'bottom',
                                     align: 'right'
                                     },
                                     });
                                     
                                     }
                                     });
                                     setTimeout(function () {
                                     window.location.reload(1);
                                     }, 1000);
                                     return true;
                                     }
                                     else
                                     {
                                     $.notify({
                                     message: 'Se ha guardado la información'
                                     }, {
                                     type: 'success',
                                     z_index: 1000000,
                                     placement: {
                                     from: 'bottom',
                                     align: 'right'
                                     },
                                     });
                                     //$( "#w0" ).submit();
                                     setTimeout(function () {
                                     window.location.reload(1);
                                     }, 1000);
                                     return true;
                                     }*/



                                });
                                //(function() {
                                $('#btnvideo').click(function (events) {
                                    var bar = $('.bar');
                                    var percent = $('.percent');
                                    var status = $('#status');
                                    $('#w0').ajaxForm({
                                        beforeSend: function () {
                                            var percentVal = '0%';
                                            bar.width(percentVal)
                                            percent.html(percentVal);
                                        },
                                        uploadProgress: function (event, position, total, percentComplete) {
                                            var percentVal = percentComplete + '%';
                                            bar.width(percentVal)
                                            percent.html(percentVal);
                                            //console.log(percentVal, position, total);
                                        },
                                        success: function () {
                                            var percentVal = '100%';
                                            bar.width(percentVal)
                                            percent.html(percentVal);
                                            // $( "#w0" ).submit();
                                            setTimeout(function () {
                                                window.location.reload(1);
                                            }, 10);
                                        },
                                        complete: function (xhr) {
                                            status.html(xhr.responseText);
                                            // $( "#w0" ).submit();
                                            setTimeout(function () {
                                                window.location.reload(1);
                                            }, 10);
                                        }
                                    });
                                });
                                //})();

                                function Video(elemento) {
                                    var ext = $(elemento).val().split('.').pop().toLowerCase();
                                    var error = '';
                                    if ($.inArray(ext, ['mp4', 'avi', 'mpeg', 'flv']) == -1) {
                                        error = error + 'Solo se permite subir archivos con extensiones .mp4,.avi,.mpeg,.flv';
                                    }
                                    if (error == '' && elemento.files[0].size / 1024 / 1024 >= 100) {
                                        error = error + 'Solo se permite archivos hasta 50 MB';
                                    }

                                    if (error != '') {
                                        $.notify({
                                            message: error
                                        }, {
                                            // settings
                                            type: 'danger',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                        //fileupload = $('#equipo-foto_img');  
                                        //fileupload.replaceWith($fileupload.clone(true));
                                        $(elemento).replaceWith($(elemento).val('').clone(true));
                                        //$('#equipo-foto_img').val('');
                                        return false;
                                    }
                                    else
                                    {
                                        //mostrarImagen(this);
                                        return true;
                                    }
                                }


                                var oe = 1;
                                var actividadcon = 1;
                                /*
                                 $('#objetivo_especifico_general').on('hidden.bs.modal', function (e) {
                                 actividad=1;
                                 console.log("aa");
                                 });*/


                                function agregarObjetivoActividad() {


                                    var body = "";
                                    var objetivo_especifico_1 = $('input[name=\'Proyecto[objetivo_especifico_1]\']').length;
                                    var objetivo_especifico_2 = $('input[name=\'Proyecto[objetivo_especifico_2]\']').length;
                                    var objetivo_especifico_3 = $('input[name=\'Proyecto[objetivo_especifico_3]\']').length;
                                    var total = objetivo_especifico_1 + objetivo_especifico_2 + objetivo_especifico_3;
                                    if (total >= 3) {
                                        $.notify({
                                            message: 'Solo se puede agregar 3 objetivos especificos'
                                        }, {
                                            type: 'danger',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                        return false;
                                    }
                                    $('#objetivo_especifico_general').modal({backdrop: 'static', keyboard: false});
                                    actividadcon = 1;
                                    body = "<div id='objetivo'>" +
                                            "<div class='col-xs-12 col-sm-12 col-md-12'>" +
                                            "<div class='form-group label-floating field-proyecto-temp_objetivo_especifico required' style='margin-top: 15px'>" +
                                            "<label class='control-label' for='proyecto-temp_objetivo_especifico' >Objetivo Específico</label>" +
                                            "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_objetivo_especifico' maxlength='250' class='form-control'>" +
                                            "</div>" +
                                            "</div>" +
                                            "</div>" +
                                            "<div class='clearfix'></div>" +
                                            "<div class='col-xs-12 col-sm-12 col-md-12' ><div style='padding-top:5px;border-top:2px dotted #f6de34'>Actividades <span class='glyphicon glyphicon-plus-sign' onclick='agregarActividad()' ></span></div></div>" +
                                            "<div id='actividades'></div>" +
                                            "<div class='clearfix'></div>";
                                    $("#oe_modal").html(body);
                                    //oe++;
                                    return true;
                                }

                                function agregarActividad() {

                                    var error = '';
                                    //var temp_actividad=$("proyecto-temp_actividad_"+(actividad-1)).val();
                                    var temp_actividades = $('input[name=\'Proyecto[temp_actividades][]\']').length;
                                    for (var i = 1; i <= temp_actividades; i++) {
                                        if (jQuery.trim($('#proyecto-temp_actividad_' + i).val()) == '')
                                        {
                                            error = error + 'Ingrese Actividad #' + i + ' <br>';
                                            $('.field-proyecto-temp_actividad_' + i).addClass('has-error');
                                        }
                                        else
                                        {
                                            $('.field-proyecto-temp_actividad_' + i).addClass('has-success');
                                            $('.field-proyecto-temp_actividad_' + i).removeClass('has-error');
                                        }
                                    }

                                    if (error != '') {
                                        $.notify({
                                            message: error
                                        }, {
                                            type: 'danger',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                        return false;
                                    }

                                    var body = "";
                                    body = "<div class='col-xs-12 col-sm-11 col-md-11 pull-right' style='margin-top:15px;'>" +
                                            "<div class='form-group label-floating field-proyecto-temp_actividad_" + actividadcon + " required' style='margin-top: 15px'>" +
                                            "<label class='control-label' for='proyecto-temp_actividad_actividad_" + actividadcon + "' >Descripción de actividad #" + actividadcon + "</label>" +
                                            "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_actividad_" + actividadcon + "' maxlength='250' name='Proyecto[temp_actividades][]' class='form-control'>" +
                                            "</div>" +
                                            "</div>";
                                    $("#actividades").append(body);
                                    actividadcon++;
                                    return true;
                                }

                                function MostrarOeActividades() {
                                    oe =<?= ($contoe + 1) ?>; //raro
                                    var oe_es_1 = $('input[name=\'Proyecto[objetivo_especifico_1]\']').length;
                                    var oe_es_2 = $('input[name=\'Proyecto[objetivo_especifico_2]\']').length;
                                    var oe_es_3 = $('input[name=\'Proyecto[objetivo_especifico_3]\']').length;
                                    var body = "";
                                    var error = '';
                                    var temp_objetivo_especifico = $("#proyecto-temp_objetivo_especifico").val();
                                    var temp_actividades = $('input[name=\'Proyecto[temp_actividades][]\']').length;
                                    var bodyactividades = "";
                                    if (oe_es_1 > 0) {
                                        oe = 2;
                                    }

                                    if (oe_es_2 > 0) {
                                        oe = 3;
                                    }


                                    if (jQuery.trim(temp_objetivo_especifico) == '')
                                    {
                                        error = error + 'Ingrese descripción en Objetivo especifico <br>';
                                        $('.field-proyecto-temp_objetivo_especifico').addClass('has-error');
                                    }
                                    else
                                    {
                                        $('.field-proyecto-temp_objetivo_especifico').addClass('has-success');
                                        $('.field-proyecto-temp_objetivo_especifico').removeClass('has-error');
                                    }

                                    if (temp_actividades == 0) {
                                        error = error + 'Ingrese 1 actividad como mínimo <br>';
                                    }

                                    for (var i = 1; i <= temp_actividades; i++) {
                                        if (jQuery.trim($('#proyecto-temp_actividad_' + i).val()) == '')
                                        {
                                            error = error + 'Ingrese Actividad #' + i + ' <br>';
                                            $('.field-proyecto-temp_actividad_' + i).addClass('has-error');
                                        }
                                        else
                                        {
                                            $('.field-proyecto-temp_actividad_' + i).addClass('has-success');
                                            $('.field-proyecto-temp_actividad_' + i).removeClass('has-error');
                                        }
                                    }


                                    if (error != '') {
                                        $.notify({
                                            message: error
                                        }, {
                                            type: 'danger',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                        return false;
                                    }


                                    $("#actividades input").each(function (index) {
                                        bodyactividades = bodyactividades + "<li id='act'> Actividad: " + xescape($(this).val()) + " <input type='hidden' value='" + xescape($(this).val()) + "' name='Proyecto[actividades_" + oe + "][]'></li>";
                                        console.log($(this).val());
                                    });
                                    var body = "<div id='oe_" + oe + "' class='col-xs-12 col-sm-12 col-md-12'>" +
                                            "<ul><li id='oespe'><b>Objetivo Específico N° " + oe + ": " + xescape(temp_objetivo_especifico) + "</b> <span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar(" + oe + ")'></span></li>" +
                                            "<input type='hidden' value='" + xescape(temp_objetivo_especifico) + "' name='Proyecto[objetivo_especifico_" + oe + "]'>" +
                                            "<ul>" + bodyactividades + "</ul></ul>" +
                                            "</div>";
                                    //$('#objetivo_especifico_general').modal('toggle');



                                    $("#oe_" + oe).replaceWith(body);
                                    // $("#mostrar_oe_actividades").append(body);
                                    oe++;
                                    actividadcon = 1;
                                    $("#form_actualizar").submit();
                                    return true;
                                }

                                function Editar(identificador) {

                                    $('#oe_modal').html("");
                                    $('#objetivo_especifico_general_copia').modal({backdrop: 'static', keyboard: false});
                                    //var objetivo_especifico="";
                                    var objetivo_especifico = $("input[name='Proyecto[objetivo_especifico_" + identificador + "]']").val();
                                    //alert("Hola " + xescape(objetivo_especifico) );

                                    var bodyactividades = "";
                                    var a = 1;
                                    $("input[name='Proyecto[actividades_" + identificador + "][]']").each(function (index) {
                                        bodyactividades = bodyactividades + "<div class='col-xs-12 col-sm-11 col-md-11 pull-right' style='margin-top:15px;'>" +
                                                "<div class='form-group label-floating field-proyecto-temp_actividad_" + a + " required' style='margin-top: 15px'>" +
                                                "<label class='control-label' for='proyecto-temp_actividad_actividad_" + a + "'>Descripción de actividad #" + a + "</label>" +
                                                "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_actividad_" + a + "' maxlength='250' name='Proyecto[temp_actividades_copia][]' class='form-control' value='" + xescape($(this).val()) + "'>" +
                                                "</div>" +
                                                "</div>";
                                        a++;
                                    });
                                    body = "<div id='objetivo_copia'>" +
                                            "<div class='col-xs-12 col-sm-12 col-md-12'>" +
                                            "<div class='form-group label-floating field-proyecto-temp_objetivo_especifico required' style='margin-top: 15px'>" +
                                            "<label class='control-label' for='proyecto-temp_objetivo_especifico' >Objetivo Específico</label>" +
                                            "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' maxlength='250' id='proyecto-temp_objetivo_especifico_" + identificador + "' class='form-control' value='" + xescape(objetivo_especifico) + "'>" +
                                            "</div>" +
                                            "</div>" +
                                            "</div>" +
                                            "<div class='clearfix'></div>" +
                                            "<div class='col-xs-12 col-sm-12 col-md-12' ><div style='padding-top::5px;border-top:2px dotted #f6de34'> Actividades <span class='glyphicon glyphicon-plus-sign' onclick='agregarActividadCopia()' ></span></div></div>" +
                                            "<div id='actividades_copia'>" +
                                            bodyactividades +
                                            "</div>" +
                                            "<div class='clearfix'></div>";
                                    $("#oe_modal_copia").html(body);
                                    $("#oe_modal_button").html('<div class="col-md-4"></div>' +
                                            '<div class="col-md-4"><button type="button" class="btn btn-default"  onclick="MostrarOeActividadesCopia(' + identificador + ')">Aceptar</button></div>');
                                    actividad = a;
                                    return true;
                                }

                                function MostrarOeActividadesCopia(identificador) {
                                    oe = identificador;
                                    var body = "";
                                    var error = '';
                                    var temp_objetivo_especifico = ($("#proyecto-temp_objetivo_especifico_" + identificador + "").val());
                                    var temp_actividades = $('input[name=\'Proyecto[temp_actividades_copia][]\']').length;
                                    var bodyactividades = "";
                                    if (jQuery.trim(temp_objetivo_especifico) == '')
                                    {
                                        error = error + 'Ingrese descripción en Objetivo especifico <br>';
                                        $('.field-proyecto-temp_objetivo_especifico').addClass('has-error');
                                    }
                                    else
                                    {
                                        $('.field-proyecto-temp_objetivo_especifico').addClass('has-success');
                                        $('.field-proyecto-temp_objetivo_especifico').removeClass('has-error');
                                    }

                                    if (temp_actividades == 0) {
                                        error = error + 'Ingrese 1 actividad como mínimo <br>';
                                    }


                                    for (var i = 1; i <= temp_actividades; i++) {

                                        // alert(temp_actividades + " - "+$('#proyecto-temp_actividad_' + i).val()); 
                                        if (jQuery.trim($('#proyecto-temp_actividad_' + i).val()) == '')
                                        {
                                            error = error + 'Ingrese Actividad #' + i + ' <br>';
                                            $('.field-proyecto-temp_actividad_' + i).addClass('has-error');
                                        }
                                        else
                                        {
                                            $('.field-proyecto-temp_actividad_' + i).addClass('has-success');
                                            $('.field-proyecto-temp_actividad_' + i).removeClass('has-error');
                                        }
                                    }


                                    if (error != '') {
                                        $.notify({
                                            message: error
                                        }, {
                                            type: 'danger',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                        return false;
                                    }


                                    if (oe == 1) {
<?php foreach ($actividades as $actividad) { ?>
    <?php if ($actividad->objetivo_especifico_id == $proyecto->objetivo_especifico_1_id) { ?>
                                                //bodyactividades=bodyactividades+"<li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_"+oe+"][]'></li>"+
                                                //"<input type='hidden' name='Proyecto[actividades_ids_"+oe+"][]'  value='<?= $actividad->actividad_id ?>' />";
    <?php } ?>
<?php } ?>
                                    }
                                    else if (oe == 2) {
<?php foreach ($actividades as $actividad) { ?>
    <?php if ($actividad->objetivo_especifico_id == $proyecto->objetivo_especifico_2_id) { ?>
                                                //bodyactividades=bodyactividades+"<li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_"+oe+"][]'></li>"+
                                                //    "<input type='hidden' name='Proyecto[actividades_ids_"+oe+"][]'  value='<?= $actividad->actividad_id ?>' />";
    <?php } ?>
<?php } ?>
                                    }
                                    else if (oe == 3) {
<?php foreach ($actividades as $actividad) { ?>
    <?php if ($actividad->objetivo_especifico_id == $proyecto->objetivo_especifico_3_id) { ?>
                                                //bodyactividades=bodyactividades+"<li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_"+oe+"][]'></li>"+
                                                //  "<input type='hidden' name='Proyecto[actividades_ids_"+oe+"][]'  value='<?= $actividad->actividad_id ?>' />";
    <?php } ?>
<?php } ?>
                                    }



                                    var acti = 0;
                                    $("#actividades_copia input").each(function (index) {
                                        //console.log($("#proyecto-actividades_ids_"+oe+"_"+acti+"").val());
                                        input = "";
                                        if ($("#proyecto-actividades_ids_" + oe + "_" + acti + "").length > 0) {
                                            input = "<input id='proyecto-actividades_ids_" + oe + "_" + acti + "' type='hidden' name='Proyecto[actividades_ids_" + oe + "][]' value='" + $("#proyecto-actividades_ids_" + oe + "_" + acti + "").val() + "' >";
                                        }

                                        bodyactividades = bodyactividades + "<li id='act'>Actividad: " + xescape($(this).val()) + " <input type='hidden' value='" + xescape($(this).val()) + "' name='Proyecto[actividades_" + oe + "][]'></li>" +
                                                input;
                                        /*"<input id='proyecto-actividades_ids_"+oe+"_"+acti+"' type='hidden' name='Proyecto[actividades_ids][]'  value='"+$('#proyecto-actividades_ids_'+oe+'_'+acti+'').val()+"' />";*/

                                        acti++;
                                    });
                                    //alert($(".tab-content .active").attr("id"));
                                    $("#tab_active_pro").val($(".tab-content .active").attr("id"));
                                    //alert($("#tab_active_pro").val());
                                    $("#form_actualizar").submit();
                                    var body = "<div id='oe_" + oe + "' class='col-xs-12 col-sm-12 col-md-12'>" +
                                            "<ul><li id='oespe'><b>Objetivo Específico N° " + oe + ": " + xescape(temp_objetivo_especifico) + "</b> <span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar(" + oe + ")'></span> </li>" +
                                            "<input type='hidden' value='" + xescape(temp_objetivo_especifico) + "' name='Proyecto[objetivo_especifico_" + oe + "]'>" +
                                            "<ul>" + bodyactividades + "</ul></ul>" +
                                            "</div>";
                                    //$('#objetivo_especifico_general_copia').modal('toggle');
                                    $("#oe_" + identificador + "").replaceWith(body);
                                    oe++;
                                    actividadcon = 1;
                                    return true;
                                }


                                function agregarActividadCopia() {

                                    var error = '';
                                    //var temp_actividad=$("proyecto-temp_actividad_"+(actividad-1)).val();
                                    var temp_actividades = $('input[name=\'Proyecto[temp_actividades_copia][]\']').length;
                                    for (var i = 1; i <= temp_actividades; i++) {
                                        if (jQuery.trim($('#proyecto-temp_actividad_' + i).val()) == '')
                                        {
                                            error = error + 'Ingrese Actividad #' + i + ' <br>';
                                            $('.field-proyecto-temp_actividad_' + i).addClass('has-error');
                                        }
                                        else
                                        {
                                            $('.field-proyecto-temp_actividad_' + i).addClass('has-success');
                                            $('.field-proyecto-temp_actividad_' + i).removeClass('has-error');
                                        }
                                    }

                                    if (error != '') {
                                        $.notify({
                                            message: error
                                        }, {
                                            type: 'danger',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                        return false;
                                    }

                                    var body = "";
                                    body = "<div class='col-xs-12 col-sm-11 col-md-11 pull-right' style='margin-top:15px;'>" +
                                            "<div class='form-group label-floating field-proyecto-temp_actividad_" + actividad + " required' style='margin-top: 15px'>" +
                                            "<label class='control-label' for='proyecto-temp_actividad_actividad_" + actividad + "' >Descripción de actividad #" + actividad + "</label>" +
                                            "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_actividad_" + actividad + "' maxlength='250' name='Proyecto[temp_actividades_copia][]' class='form-control'>" +
                                            "</div>" +
                                            "</div>";
                                    $("#actividades_copia").append(body);
                                    actividad++;
                                    return true;
                                }

                                function Documento(elemento) {
                                    var ext = $(elemento).val().split('.').pop().toLowerCase();
                                    var error = '';
                                    if ($.inArray(ext, ['pdf']) == -1) {
                                        error = error + 'Solo se permite subir archivos con extensiones .pdf';
                                    }
                                    if (error == '' && elemento.files[0].size / 1024 / 1024 >= 10) {
                                        error = error + 'Solo se permite archivos hasta 5 MB';
                                    }

                                    if (error != '') {
                                        $.notify({
                                            message: error
                                        }, {
                                            // settings
                                            type: 'danger',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                        //fileupload = $('#equipo-foto_img');  
                                        //fileupload.replaceWith($fileupload.clone(true));
                                        $(elemento).replaceWith($(elemento).val('').clone(true));
                                        //$('#equipo-foto_img').val('');
                                        return false;
                                    }
                                    else
                                    {
                                        //mostrarImagen(this);
                                        return true;
                                    }
                                }

                                function Check(v1, v2) {

                                    if ($('#proyecto-p' + v1 + '_' + v2).is(':checked')) {
                                        $('#proyecto-p' + v1 + '_' + v2).val('1');
                                        console.log('1');
                                    }
                                    else
                                    {
                                        console.log("0");
                                        $('#proyecto-p' + v1 + '_' + v2).val('0');
                                    }

                                }

                                function EliminarArchivo(proyecto) {
                                    $.ajax({
                                        url: '<?= $eliminararchivo_pro2 ?>',
                                        type: 'POST',
                                        async: true,
                                        data: {'id': proyecto},
                                        success: function (data) {
                                            $.notify({
                                                message: 'Se ha ha elimando el archivo del proyecto 2'
                                            }, {
                                                type: 'success',
                                                z_index: 1000000,
                                                placement: {
                                                    from: 'bottom',
                                                    align: 'right'
                                                },
                                            });
                                            setTimeout(function () {
                                                window.location.reload(1);
                                            }, 1000);
                                        }
                                    });
                                }

                                $("a[href*='#tab']").click(function () {
                                    // str.replace("Microsoft", "W3Schools");
                                    var idtab = $(this).attr("href");
                                    //alert( );
                                    $("#tab_active_pro").val(idtab.replace("#", ""));
                                });
                                $("#btnproyecto").click(function () {

                                    if (validarCampos()) {
                                        // alert("Ingrese todos los campos vacíos");
                                    } else {
                                        $("#form_actualizar").submit();
                                    }

                                });
                                function validarCampos() {
                                    var planespresupuestalesrecursosdescripciones = $('input[name=\'Proyecto[planes_presupuestales_recursos_descripciones][]\']').length;
                                    var cronogramas = $('input[name=\'Proyecto[cronogramas_tareas][]\']').length;
                                    if (jQuery.trim($('#videoproyec').val()) != '') {

                                        if (!validYT($('#videoproyec').val())) {
                                            alert('Ingrese un link valido para el video de youtube ');
                                            return true;
                                        }
                                    }


                                    for (var i = 0; i < planespresupuestalesrecursosdescripciones; i++) {
                                        if (jQuery.trim($('#proyecto-plan_presupuestal_recurso_descripcion_' + i).val()) == '')
                                        {
                                            alert('Ingrese información en la fila #' + (i + 1) + ' de la columna recurso descripción ');
                                            return true;
                                        }
                                        if (jQuery.trim($('#proyecto-plan_presupuestal_dirigido_' + i).val()) == '')
                                        {
                                            //alert('#proyecto-plan_presupuestal_dirigido_' + i);
                                            alert('Ingrese información en la fila #' + (i + 1) + ' de la columna a quien va dirigido');
                                            return true;
                                        }
                                        if (jQuery.trim($('#proyecto-plan_presupuestal_precio_unitario1_' + i).val()) == '')
                                        {
                                            alert('Ingrese información en la fila #' + (i + 1) + ' de la columna precio unitario');
                                            return true;
                                        }


                                        if ($('#proyecto-plan_presupuestal_como_conseguirlo_' + i).val() == '')
                                        {
                                            alert('Ingrese información en la fila #' + (i + 1) + ' de la columna cómo conseguirlo');
                                            return true;
                                        }
                                        if ($('#proyecto-plan_presupuestal_cantidad_' + i).val() == '')
                                        {
                                            alert('Ingrese información en la fila #' + (i + 1) + ' de la columna cantidad');
                                            return true;
                                        }
                                    }


                                    for (var i = 0; i < cronogramas; i++) {
                                        if (jQuery.trim($('#proyecto-cronograma_tarea_' + i).val()) == '')
                                        {
                                            alert('Ingrese información en la fila #' + (i + 1) + ' de la columna tarea ');
                                            return true;
                                        }
                                        if (jQuery.trim($('#proyecto-cronograma_responsable_' + i).val()) == '')
                                        {
                                            alert('Ingrese información en la fila #' + (i + 1) + ' de la columna responsable');
                                            return true;
                                        }

                                        if ($('#proyecto-cronograma_fecha_inicio_' + i).val() == '')
                                        {
                                            alert('Ingrese información en la fila #' + (i + 1) + ' de la columna fecha de inicio');
                                            return true;
                                        }
                                        if ($('#proyecto-cronograma_fecha_fin_' + i).val() == '')
                                        {
                                            alert('Ingrese información en la fila #' + (i + 1) + ' de la columna fecha de fin');
                                            return true;
                                        }
                                    }

                                    /*
                                     var $inputs = $('form input:visible'); // Obtenemos los inputs de nuestro formulario
                                     var formvalido = false; // Para saber si el form esta vacio 
                                     
                                     $inputs.each(function() {  // Recorremos los inputs del formulario (uno a uno)
                                     alert($(this).attr("id"));
                                     if (jQuery.trim($(this).val()) == "") {
                                     
                                     formvalido = true;
                                     }
                                     
                                     });*/

                                    return false; // retornamos segun corresponda
                                }


                                /*
                                 function isEmpty(val) {
                                 if (jQuery.trim(val).length > = 0)
                                 return false;
                                 return true;
                                 }*/

                                $(document).ready(function () {
// Handler for .ready() called.

                                    $("#lnk_proyecto").attr("class", "active");
                                });
</script>
</script>

<script src="<?= \Yii::$app->request->BaseUrl ?>/js/bootstrap-notify.js"></script>

<?php if (Yii::$app->session->hasFlash('tab_active_pro')): ?>
    <script>
                                // alert("<?= Yii::$app->session->getFlash('tab_active_pro') ?>");
                                $("a[href='#<?= Yii::$app->session->getFlash('tab_active_pro') ?>']").click();
                                //$("#<?= Yii::$app->session->getFlash('tab_active_pro') ?>").click();
    </script>
<?php endif; ?>
