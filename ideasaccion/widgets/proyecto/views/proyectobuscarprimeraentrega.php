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
    <img src="../img/icon_team_big.jpg" alt="">PRIMERA ENTREGA
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
                <div class="col-md-12 text-center">
                    <button style="background:#f6de34;color: #1f2a69;border-color:#f6de34;font-weight:bold" class="btn  btn-lateral" href="#tab_1" data-toggle="tab" aria-expanded="false">Proyecto</button>
                    <button style="background:#f6de34;color: #1f2a69;border-color:#f6de34;font-weight:bold" class="btn  btn-lateral" href="#tab_2" data-toggle="tab" aria-expanded="false">Video</button>
                </div>
                <!--
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Proyecto</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Video</a></li>-->
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?php if($proyecto->formato_proyecto==0){ ?>
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
                                <h4><b>Objetivos Específicos</b>  </h4>
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
                            <?= \app\widgets\planpresupuestal\PlanPresupuestalWidget1::widget(['proyecto_id'=>$proyecto->id,'disabled'=>$disabled]); ?> 
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h4><b>Cronograma</b>  </h4>
                            </div>
                            <div class="clearfix"></div>
                            <?= \app\widgets\cronograma\CronogramaWidget1::widget(['proyecto_id'=>$proyecto->id,'disabled'=>$disabled]); ?>
                            <div class="clearfix"></div>
                            <div class="col-md-12" style="height: 660px; overflow-y: scroll;float: left">
                                <?php if($etapa->etapa==2 || $etapa->etapa==3){ ?>
                                    <?= \app\widgets\foro\ForoPrimeraEntregaProyectoWidget::widget(['proyecto_id'=>$proyecto->id,'seccion'=>$seccion->seccion]); ?> 
                                <?php }?>
                            </div>
                            
                                    
                                
                        </div>
                        <?php }else { ?>
                        <div class="col-md-12" style="height: 660px; ">
                            <embed style='overflow: hidden' type='text/html' src= "<?= \Yii::$app->request->BaseUrl ?>/proyectos/<?= $proyecto->proyecto_archivo ?>" width=100% height=100% >
                        </div>
                        <div class="col-md-12" style="height: 660px; float: left">
                            <?php if($etapa->etapa==2 || $etapa->etapa==3){ ?>
                                <?= \app\widgets\foro\ForoPrimeraEntregaProyectoWidget::widget(['proyecto_id'=>$proyecto->id,'seccion'=>$seccion->seccion]); ?> 
                            <?php }?>
                        </div>
                        <?php } ?>
                </div>
                <div class="clearfix"></div>
                <div class="tab-pane" id="tab_2">
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            </div>
                            <div class="clearfix"></div>
                            <?php if($videoprimera){ ?>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <?php if($videoprimera->ruta && $videoprimera->tipo==1){ ?>
                                            <br>
                                            <iframe type="text/html" 
                                                width="320" 
                                                height="240" 
                                                src="https://www.youtube.com/embed/<?= substr($videoprimera->ruta,-11) ?>" 
                                                frameborder="0">
                                            </iframe>
                                    <?php } elseif($videoprimera->tipo==2){ ?>
                                            <video width="320" height="240" controls>
                                                <source src="<?= Yii::getAlias('@video').$videoprimera->ruta ?>" >  
                                            </video>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            
                   
                    <div class="clearfix"></div>
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





