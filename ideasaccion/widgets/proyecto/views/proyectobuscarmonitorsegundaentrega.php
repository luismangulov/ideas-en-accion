<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Resultados;
use yii\widgets\Pjax;
use yii\web\JsExpression;

/* @var $this \yii\web\View */
/* @var $user \common\models\LoginForm */
/* @var $title string */
$contoe=0;
$acti1=0;
$acti2=0;
$acti3=0;
?>

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


<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">SEGUNDA ENTREGA
</div>
<div class="box_content contenido_seccion_crear_equipo">
    <div class="row" >
        <div style="border: 2px solid #1f2a69;padding: 10px" class="text-justify">
            <b>Región:</b> <?= $region->department ?><br>
            <b>Institución educativa:</b> <?= $institucion->denominacion ?><br>
            <b>Título del proyecto:</b> <?= $proyecto->titulo ?><br>
        </div> 
        <div class="nav-tabs-custom" >
            <ul class="nav nav-tabs" style="background: white;">
                <!--<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Proyecto</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Video</a></li>
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Reflexión</a></li>-->
                <div class="col-md-12 text-center">
                    <button style="background:#f6de34;color: #1f2a69;border-color:#f6de34;font-weight:bold" class="btn  btn-lateral" href="#tab_1" data-toggle="tab" aria-expanded="false">Proyecto</button>
                    <button style="background:#f6de34;color: #1f2a69;border-color:#f6de34;font-weight:bold" class="btn  btn-lateral" href="#tab_2" data-toggle="tab" aria-expanded="false">Video</button>
                    <button style="background:#f6de34;color: #1f2a69;border-color:#f6de34;font-weight:bold" class="btn  btn-lateral" href="#tab_3" data-toggle="tab" aria-expanded="false">Reflexión</button>
                </div>
                
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?php if($proyecto->formato_proyecto2==0){ ?>
                        <div class="col-md-12" style="height: 660px; ">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group label-floating field-proyecto-titulo">
                                    <label class="control-label" for="proyecto-titulo">Título del proyecto</label>
                                    <p class="text-justify" style="padding-bottom: 5px;padding-top: 9px"><?= $proyecto->titulo ?></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group label-floating field-proyecto-asunto required">
                                    <label class="control-label" for="proyecto-asunto" >Asunto público</label>
                                    <p class="text-justify" style="padding-bottom: 5px;padding-top: 9px"><?= $equipo->asunto->descripcion_cabecera ?></p>
                                </div>
                            </div>
                            
                            <div class="clearfix"></div>    
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group label-floating field-proyecto-resumen required">
                                    <label class="control-label" for="proyecto-resumen" >Sumilla / Justificación</label>
                                    <p class="text-justify" style="padding-bottom: 5px;padding-top: 9px"><?= $proyecto->resumen ?></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group label-floating field-proyecto-beneficiario required">
                                    <label class="control-label" for="proyecto-beneficiario">Objetivo General</label>
                                    <p class="text-justify" style="padding-bottom: 5px;padding-top: 9px"><?= $proyecto->beneficiario ?></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h4><b>Objetivos  Específicos</b>  </h4>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div id="mostrar_oe_actividades">
                                    <div id="oe_1" class='col-xs-12 col-sm-12 col-md-12'>
                                        <?php if($proyecto->objetivo_especifico_1){ ?>
                                            <ul>
                                                <li id='oespe'><b>Objetivo Específico N° 1: <?= $proyecto->objetivo_especifico_1 ?></b> </li>
                                                <ul>
                                                    <?php foreach($actividades as $actividad){ ?>
                                                        <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_1_id){ ?>
                                                            <li id='act'>Actividad: <?= $actividad->descripcion ?></li>
                                                        <?php  } ?>
                                                    <?php  } ?>
                                                </ul>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                    <div id="oe_2" class='col-xs-12 col-sm-12 col-md-12'>
                                        <?php if($proyecto->objetivo_especifico_2){  ?>
                                            <ul>
                                                <li id='oespe'><b>Objetivo Específico N°2: <?= $proyecto->objetivo_especifico_2 ?></b> </li>
                                                <ul>
                                                    <?php foreach($actividades as $actividad){ ?>
                                                        <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_2_id){?>
                                                            <li id='act'>Actividad: <?= $actividad->descripcion ?></li>
                                                        <?php } ?>
                                                    <?php  } ?>
                                                </ul>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                    
                                    <div id="oe_3" class='col-xs-12 col-sm-12 col-md-12'>
                                        <?php if($proyecto->objetivo_especifico_3) { ?>
                                            <ul>
                                                <li id='oespe'><b>Objetivo Específico N°3: <?= $proyecto->objetivo_especifico_3 ?></b> </li>
                                                <ul>
                                                    <?php foreach($actividades as $actividad){ ?>
                                                        <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_3_id){?>
                                                            <li id='act'>Actividad: <?= $actividad->descripcion ?></li>
                                                        <?php  } ?>
                                                    <?php  } ?>
                                                </ul>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h4><b>Presupuesto</b>  </h4>
                            </div>
                            <div class="clearfix"></div>
                            <?= \app\widgets\planpresupuestal\PlanPresupuestalWidget2::widget(['proyecto_id'=>$proyecto->id,'disabled'=>$disabled]); ?> 
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h4><b>Cronograma</b>  </h4>
                            </div>
                            <div class="clearfix"></div>
                            <?= \app\widgets\cronograma\CronogramaWidget2::widget(['proyecto_id'=>$proyecto->id,'disabled'=>$disabled]); ?>
                            <div class="clearfix"></div>
                            
                        </div>
                        <?php }else { ?>
                        <div class="col-md-12" style="height: 660px; ">
                            <embed style='overflow: hidden' type='text/html' src= "<?= \Yii::$app->request->BaseUrl ?>/proyectos/<?= $proyecto->proyecto_archivo2 ?>" width=100% height=100% >
                        </div>
                        <?php } ?>
                </div>
                <div class="clearfix"></div>
                <div class="tab-pane" id="tab_2">
                    <div class="clearfix"></div>
                    <?php if($videosegunda){ ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <?php if($videosegunda->ruta && $videosegunda->tipo==1){ ?>
                                    <br>
                                    <iframe type="text/html" 
                                        width="320" 
                                        height="240" 
                                        src="https://www.youtube.com/embed/<?= substr($videosegunda->ruta,-11) ?>" 
                                        frameborder="0">
                                    </iframe>
                            <?php } elseif($videosegunda->tipo==2){ ?>
                                    <video width="320" height="240" controls>
                                        <source src="<?= Yii::getAlias('@video').$videosegunda->ruta ?>" >  
                                    </video>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="tab-pane" id="tab_3">
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                        <label>1.- Aportes del equipo MINEDU</label>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-p4 required">
                            <label class="control-label" for="proyecto-p4" >¿Qué aportes incluyeron en su proyecto participativo?</label>
                            <!--<textarea style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p1" class="form-control" rows="3" name="Proyecto[p1]"  </textarea>-->
                            <select style="border: 2px solid #1f2a69;padding: 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p4" class="form-control" name="Proyecto[p4]" disabled />
                                <option value=""></option>
                                <?php foreach($comen_monitores as $comen_monitor){ ?>
                                <option value="<?= $comen_monitor->id ?>" <?= ($comen_monitor->id==$proyecto->p4)?'selected':'' ?>><?= $comen_monitor->contenido ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group label-floating field-proyecto-p2 required">
                            <label class="control-label" for="proyecto-p2" >¿Qué debilidades encuentras en tu escuela o comunidad para trabajar tu proyecto?</label>
                            <div class="col-md-6">
                                <input type="checkbox" id="proyecto-p5_1" name="Proyecto[p5_1]" value="1" <?= ($proyecto->p5_1==1)?'checked':'' ?> onclick="Check('5','1')" disabled>Título<br>
                                <input type="checkbox" id="proyecto-p5_2" name="Proyecto[p5_2]" value="1" <?= ($proyecto->p5_2==1)?'checked':'' ?> onclick="Check('5','2')" disabled>Resumen<br>
                                <input type="checkbox" id="proyecto-p5_3" name="Proyecto[p5_3]" value="1" <?= ($proyecto->p5_3==1)?'checked':'' ?> onclick="Check('5','3')" disabled>Objetivo General<br>
                                <input type="checkbox" id="proyecto-p5_4" name="Proyecto[p5_4]" value="1" <?= ($proyecto->p5_4==1)?'checked':'' ?> onclick="Check('5','4')" disabled>Objetivos
                            </div>
                            <div class="col-md-6">
                                <input type="checkbox" id="proyecto-p5_5" name="Proyecto[p5_5]" value="1" <?= ($proyecto->p5_5==1)?'checked':'' ?> onclick="Check('5','5')" disabled>Actividades<br>
                                <input type="checkbox" id="proyecto-p5_6" name="Proyecto[p5_6]" value="1" <?= ($proyecto->p5_6==1)?'checked':'' ?> onclick="Check('5','6')" disabled>Cronograma<br>
                                <input type="checkbox" id="proyecto-p5_7" name="Proyecto[p5_7]" value="1" <?= ($proyecto->p5_7==1)?'checked':'' ?> onclick="Check('5','7')" disabled>Presupuesto<br>
                                <input type="checkbox" id="proyecto-p5_8" name="Proyecto[p5_8]" value="1" <?= ($proyecto->p5_8==1)?'checked':'' ?> onclick="Check('5','8')" disabled>Video
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
                            <select style="border: 2px solid #1f2a69;padding: 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-p6" class="form-control" name="Proyecto[p6]" disabled />
                                <option value=""></option>
                                <?php foreach($comen_participantes as $comen_participante){ ?>
                                <option value="<?= $comen_participante->id ?>" <?= ($comen_participante->id==$proyecto->p6)?'selected':'' ?> ><?= $comen_participante->contenido ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group label-floating field-proyecto-p7 required">
                            <label class="control-label" for="proyecto-p7" >¿Qué debilidades encuentras en tu escuela o comunidad para trabajar tu proyecto?</label>
                            <div class="col-md-6">
                                <input type="checkbox" id="proyecto-p7_1" name="Proyecto[p7_1]"  <?= ($proyecto->p7_1==1)?'checked':'' ?> onclick="Check('7','1')" disabled>Título<br>
                                <input type="checkbox" id="proyecto-p7_2" name="Proyecto[p7_2]"  <?= ($proyecto->p7_2==1)?'checked':'' ?> onclick="Check('7','2')" disabled>Resumen<br>
                                <input type="checkbox" id="proyecto-p7_3" name="Proyecto[p7_3]"  <?= ($proyecto->p7_3==1)?'checked':'' ?> onclick="Check('7','3')" disabled>Objetivo General<br>
                                <input type="checkbox" id="proyecto-p7_4" name="Proyecto[p7_4]"  <?= ($proyecto->p7_4==1)?'checked':'' ?> onclick="Check('7','4')" disabled>Objetivos
                            </div>
                            <div class="col-md-6">
                                <input type="checkbox" id="proyecto-p7_5" name="Proyecto[p7_5]"  <?= ($proyecto->p7_5==1)?'checked':'' ?> onclick="Check('7','5')" disabled>Actividades<br>
                                <input type="checkbox" id="proyecto-p7_6" name="Proyecto[p7_6]"  <?= ($proyecto->p7_6==1)?'checked':'' ?> onclick="Check('7','6')" disabled>Cronograma<br>
                                <input type="checkbox" id="proyecto-p7_7" name="Proyecto[p7_7]"  <?= ($proyecto->p7_7==1)?'checked':'' ?> onclick="Check('7','7')" disabled>Presupuesto<br>
                                <input type="checkbox" id="proyecto-p7_8" name="Proyecto[p7_8]"  <?= ($proyecto->p7_8==1)?'checked':'' ?> onclick="Check('7','8')" disabled>Video
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 form-group">
                        <label>3.- ¿Consideran importante los aportes entre equipos?</label>
                        <div class="col-md-12">
                            <input disabled type="radio" name="Proyecto[p8]" value="1" <?= ($proyecto->p8==1)?'checked':'' ?> >No, porque es un concurso<br>
                            <input disabled type="radio" name="Proyecto[p8]" value="2" <?= ($proyecto->p8==2)?'checked':'' ?> >No, porque ellos no saben cómo es mi proyecto<br>
                            <input disabled type="radio" name="Proyecto[p8]" value="3" <?= ($proyecto->p8==3)?'checked':'' ?>>Sí, porque me ayudó a mejorar mi proyecto<br>
                            <input disabled type="radio" name="Proyecto[p8]" value="4" <?= ($proyecto->p8==4)?'checked':'' ?>>Sí, porque todos nos ayudamos y mejoramos nuestra escuela, comunidad o región.
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                </div>
            </div>
        </div>
    </div>
</div>




<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.7/jquery.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/jquery.form.js"></script>

<?php
    $this->registerJs(
    "$('document').ready(function(){})");
?>
<?php
    $eliminaractividad= Yii::$app->getUrlManager()->createUrl('proyecto/eliminaractividad');
    $reflexion= Yii::$app->getUrlManager()->createUrl('proyecto/reflexion');
    $evaluacion= Yii::$app->getUrlManager()->createUrl('proyecto/evaluacion');
?>





<script type="text/javascript">
    $(document).ready(function() {
// Handler for .ready() called.

        $("#lnk_votacioninterna").addClass("active");

    });



</script>