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

<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">PRIMERA ENTREGA
</div>
<div class="box_content contenido_seccion_crear_equipo">
    <div class="row">
        <?php if($proyecto->formato_proyecto==0){ ?>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" style="background: white;">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Datos generales</a></li>
                <li class=""><a href="#tab_9" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Objetivos y actividades</a></li>
                <!--<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Resultado</a></li>-->
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Presupuesto</a></li>
                <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Cronograma</a></li>
                <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="true" style="color: #333 !important"> Mi video</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-titulo">
                            <label class="control-label" for="proyecto-titulo">Título del proyecto</label>
                            <p class="text-justify" style="padding-bottom: 5px;padding-top: 9px"><?= htmlentities($proyecto->titulo, ENT_QUOTES) ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-asunto required">
                            <label class="control-label" for="proyecto-asunto" >Asunto público</label>
                            <p class="text-justify" style="padding-bottom: 5px;padding-top: 9px"><?= htmlentities($equipo->asunto->descripcion_cabecera,ENT_QUOTES) ?></p>
                        </div>
                    </div>
                    
                    <div class="clearfix"></div>    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-resumen required">
                            <label class="control-label" for="proyecto-resumen" >Sumilla / Justificación</label>
                            <p class="text-justify" style="padding-bottom: 5px;padding-top: 9px"><?= htmlentities($proyecto->resumen, ENT_QUOTES) ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group label-floating field-proyecto-beneficiario required">
                            <label class="control-label" for="proyecto-beneficiario">Objetivo General</label>
                            <p class="text-justify" style="padding-bottom: 5px;padding-top: 9px"><?= htmlentities($proyecto->beneficiario , ENT_QUOTES)?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_9">
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h4><b>Objetivos</b>  </h4>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div id="mostrar_oe_actividades">
                            
                            <div id="oe_1" class='col-xs-12 col-sm-12 col-md-12'>
                                <?php if($proyecto->objetivo_especifico_1){ ?>
                                    <ul>
                                        <li id='oespe'><b>Objetivo N° 1: <?= $proyecto->objetivo_especifico_1 ?></b> </li>
                                        <ul>
                                            <?php foreach($actividades as $actividad){ ?>
                                                <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_1_id){ ?>
                                            <li id='act'>Actividad: <?= htmlentities($actividad->descripcion,ENT_QUOTES) ?></li>
                                                <?php  } ?>
                                            <?php  } ?>
                                        </ul>
                                    </ul>
                                <?php } ?>
                            </div>
                            <div id="oe_2" class='col-xs-12 col-sm-12 col-md-12'>
                                <?php if($proyecto->objetivo_especifico_2){  ?>
                                    <ul>
                                        <li id='oespe'><b>Objetivo N°2: <?= $proyecto->objetivo_especifico_2 ?></b> </li>
                                        <ul>
                                            <?php foreach($actividades as $actividad){ ?>
                                                <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_2_id){?>
                                            <li id='act'>Actividad: <?= htmlentities($actividad->descripcion,ENT_QUOTES) ?></li>
                                                <?php } ?>
                                            <?php  } ?>
                                        </ul>
                                    </ul>
                                <?php } ?>
                            </div>
                            
                            <div id="oe_3" class='col-xs-12 col-sm-12 col-md-12'>
                                <?php if($proyecto->objetivo_especifico_3) { ?>
                                    <ul>
                                        <li id='oespe'><b>Objetivo N°3: <?= $proyecto->objetivo_especifico_3 ?></b> </li>
                                        <ul>
                                            <?php foreach($actividades as $actividad){ ?>
                                                <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_3_id){?>
                                                    <li id='act'>Actividad: <?= htmlentities($actividad->descripcion,ENT_QUOTES) ?></li>
                                                <?php  } ?>
                                            <?php  } ?>
                                        </ul>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.tab-pane -->
                
                <div class="tab-pane" id="tab_2">
                    
                </div><!-- /.tab-pane -->
                
                <div class="tab-pane" id="tab_3">
                    <?= \app\widgets\planpresupuestal\PlanPresupuestalWidget1::widget(['proyecto_id'=>$proyecto->id,'disabled'=>$disabled]); ?> 
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_4">
                    <?= \app\widgets\cronograma\CronogramaWidget1::widget(['proyecto_id'=>$proyecto->id,'disabled'=>$disabled]); ?> 
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_5">
                    
                    <?php if($videoprimera){ ?>
                    <div class="col-xs-12 col-sm-3 col-md-3">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
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
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_6">
                    
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_7">
                    <div class="clearfix"></div>
                    <?php if($equipo->etapa==1 || $equipo->etapa==2){ ?>
                    <div class="col-xs-12 col-sm-7 col-md-5">
                        <div class="form-group field-proyecto-evaluacion required">
                            <label class="control-label" for="proyecto-evaluacion" >Evaluación: </label>
                            <textarea id="proyecto-evaluacion" class="form-control" name="Proyecto[evaluacion]"  placeholder="Evaluación" <?= ($equipo->etapa==2)?'disabled':''; ?>><?= $proyecto->evaluacion?></textarea>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div>
        <?php }else { ?>
        
        <?php } ?>
    </div>
</div>




<?php ActiveForm::end(); ?>


<script nonce="<?= getnonceideas() ?>" src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.7/jquery.js"></script>
<script nonce="<?= getnonceideas() ?>" src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/jquery.form.js"></script>


<?php
    $this->registerJs(
    "$('document').ready(function(){})");
?>
<?php
    $eliminaractividad= Yii::$app->getUrlManager()->createUrl('proyecto/eliminaractividad');
    $reflexion= Yii::$app->getUrlManager()->createUrl('proyecto/reflexion');
    $evaluacion= Yii::$app->getUrlManager()->createUrl('proyecto/evaluacion');
?>





