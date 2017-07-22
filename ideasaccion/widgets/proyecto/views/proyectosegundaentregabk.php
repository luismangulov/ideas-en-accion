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

?>

<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">SEGUNDA ENTREGA
</div>
<div class="box_content contenido_seccion_equipo">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" style="background: white;">
            <li class="active"><a href="#tab_11" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Datos generales</a></li>
            <li class=""><a href="#tab_19" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Objetivos y actividades</a></li>
            <!--<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Resultado</a></li>
            <li class=""><a href="#tab_12" data-toggle="tab" aria-expanded="false">Resultado</a></li>-->
            <li class=""><a href="#tab_13" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Presupuesto</a></li>
            <li class=""><a href="#tab_14" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Cronograma</a></li>
            <li class=""><a href="#tab_15" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Mi Video</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_11">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h4 style="margin-bottom: 0px;padding-bottom: 0px;color: black"><label>Título:</label> </h4>
                    <p class="text-justify" style="padding-bottom: 5px"><?= $proyecto->titulo ?></p>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h4 style="margin-bottom: 0px;padding-bottom: 0px;color: black"><label>Resumen:</label> </h4>
                    <p class="text-justify" style="padding-bottom: 5px"><?= $proyecto->resumen ?></p>
                    
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h4 style="margin-bottom: 0px;padding-bottom: 0px;color: black"><label>Objetivo General:</label> </h4>
                    <p class="text-justify" style="padding-bottom: 5px"><?= $proyecto->beneficiario ?></p>
                </div>
                <div class="clearfix"></div>
            </div><!-- /.tab-pane -->
            <div class="tab-pane" id="tab_19">
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-3 col-md-3"></div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="clearfix"></div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <h4 style="margin-bottom: 0px;padding-bottom: 0px;color: black"><label>Objetivo general</label> </h4>
                        <p class="text-justify" style="padding-bottom: 5px"><?= $proyecto->objetivo_general ?></p>
                    </div>
                   <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4 style="margin-bottom: 0px;padding-bottom: 0px;color: black"><label>Objetivos especificos</label>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div id="mostrar_oe_actividades">
                            <div class='col-xs-12 col-sm-12 col-md-12'>
                                <?php if($proyecto->objetivo_especifico_1){ ?>
                                    <li><b><?= $proyecto->objetivo_especifico_1 ?></b></li>
                                        <input type='hidden' value='<?= $proyecto->objetivo_especifico_1 ?>' name='Proyecto[objetivo_especifico_1]'>
                                    <ul>
                                        <?php foreach($actividades as $actividad){ ?>
                                            <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_1_id){?>
                                                <li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_1][]'></li>
                                                <input type="hidden" name="Proyecto[actividades_ids_1][]" placeholder="Actividad" value="<?= $actividad->actividad_id ?>" <?= $disabled ?>/>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                    <?php $contoe=1; ?>
                                <?php } ?>
                            </div>
                            
                            <div class='col-xs-12 col-sm-12 col-md-12'>
                                <?php if($proyecto->objetivo_especifico_2){  ?>
                                    <li><b><?= $proyecto->objetivo_especifico_2 ?></b></li>
                                        <input type='hidden' value='<?= $proyecto->objetivo_especifico_2 ?>' name='Proyecto[objetivo_especifico_2]'>
                                    <ul>
                                        <?php foreach($actividades as $actividad){ ?>
                                            <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_2_id){?>
                                                <li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_2][]'></li>
                                                <input type="hidden" name="Proyecto[actividades_ids_2][]" placeholder="Actividad" value="<?= $actividad->actividad_id ?>" <?= $disabled ?>/>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                    <?php $contoe=2; ?>
                                <?php } ?>
                            </div>
                            
                            <div class='col-xs-12 col-sm-12 col-md-12'>
                                <?php if($proyecto->objetivo_especifico_3) { ?>
                                    <li><b><?= $proyecto->objetivo_especifico_3 ?></b></li>
                                        <input type='hidden' value='<?= $proyecto->objetivo_especifico_3 ?>' name='Proyecto[objetivo_especifico_3]'>
                                    <ul>
                                        <?php foreach($actividades as $actividad){ ?>
                                            <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_3_id){?>
                                                <li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_3][]'></li>
                                                <input type="hidden" name="Proyecto[actividades_ids_3][]" placeholder="Actividad" value="<?= $actividad->actividad_id ?>" <?= $disabled ?>/>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                    <?php $contoe=3; ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div><!-- /.tab-pane -->
            <div class="tab-pane" id="tab_12">
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-8 col-md-8">
                    <table class="table">
                        <thead>
                        <th>Actividad</th>
                        <th>Resultado</th>
                        </thead>
                        <tbody>
                    <?php $i=0;?>
                    <?php foreach($actividades as $actividad){ ?>
                        <tr>
                            <td><?= $actividad->descripcion ?></td>
                            <td>
                                <div class="form-group field-proyecto-resultado_esperado_<?= $i ?> required">
                                    <input type="hidden"  class="form-control" name="Proyecto[resultados_ids][]" value="<?= $actividad->actividad_id ?>" >
                                    <input type="text" id="proyecto-resultado_esperado_<?= $i ?>" class="form-control" name="Proyecto[resultados_esperados][]" placeholder="Resultado #<?= $i ?>" value="<?= $actividad->resultado_esperado ?>" <?= $disabled ?> >
                                </div>
                            </td>
                        </tr>
                        
                    <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div><!-- /.tab-pane -->
            <div class="tab-pane" id="tab_13">
                <?= \app\widgets\planpresupuestal\PlanPresupuestalWidget::widget(['proyecto_id'=>$proyecto->id,'disabled'=>$disabled]); ?> 
            </div><!-- /.tab-pane -->
            <div class="tab-pane" id="tab_14">
                <?= \app\widgets\cronograma\CronogramaWidget::widget(['proyecto_id'=>$proyecto->id,'disabled'=>$disabled]); ?> 
            </div><!-- /.tab-pane -->
            <div class="tab-pane" id="tab_15">
                
                <?php if($videosegunda){ ?>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <video width="320" height="240" controls>
                        <source src="<?= Yii::getAlias('@video').$videosegunda->ruta ?>">  
                    </video>
                </div>
                <?php } ?>
                <div class="clearfix"></div>
            </div><!-- /.tab-pane -->
            <!--<div class="tab-pane" id="tab_16">
                <div class="col-xs-12 col-sm-7 col-md-5">
                    <div class="form-group field-proyecto-reflexion required">
                        <label class="control-label" for="proyecto-reflexion" >Reflexión: </label>
                        <textarea id="proyecto-reflexion" class="form-control" name="Proyecto[reflexion]"  placeholder="Reflexión" <?= ($equipo->etapa==1  || $equipo->etapa==2)?'disabled':''; ?>><?php //= $proyecto->reflexion?></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>tab-pane -->
            <div class="tab-pane" id="tab_17">
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
    
    <div class="clearfix"></div>
    
</div>




<?php ActiveForm::end(); ?>

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
<script>
   
    
    $("#btn_objetivo_general").click(function(event){
        if ($('#proyecto-objetivo_general').val()=='') {
            $.notify({
                message: 'Ingrese el Objetivo General' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            $('.field-proyecto-objetivo_general').addClass('has-error');
            return false;
        }
        $('.field-proyecto-objetivo_general').css( 'color', 'black' );
        $("#txt_objetivo_general").html($('#proyecto-objetivo_general').val());
        return true;
    });
    
    $("#btn_objetivo_especifico_1").click(function(event){
        var error='';
        if ($('#proyecto-objetivo_especifico_1').val()=='') {
            error=error+' Ingrese el Objetivo especifico 1 <br>';
            $('.field-proyecto-objetivo_especifico_1').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_1').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_1').removeClass('has-error');
        }
        
        var objetivo1=$('input[name=\'Proyecto[actividades_1][]\']').length;
        for (var i=0; i<objetivo1; i++) {
            if($('#proyecto-actividad_objetivo1_'+i).val()=='')
            {
                error=error+'ingrese si quiera '+i+' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo1_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo1_'+i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo1_'+i).removeClass('has-error');
            }
        }
        
        
        if (error!='') {
            $.notify({
                message: error 
            },{
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
            $("#txt_objetivo_especifico_1").html($('#proyecto-objetivo_especifico_1').val());
            $('.field-proyecto-objetivo_especifico_1').css( 'color', 'black' );
            $( "#w0" ).submit();
            return true;
        }
        
    });
    
    $("#btn_objetivo_especifico_2").click(function(event){
        var error='';
        
        var objetivo2=$('input[name=\'Proyecto[actividades_2][]\']').length;
        for (var i=0; i<objetivo2; i++) {
            if($('#proyecto-actividad_objetivo2_'+i).val()=='')
            {
                error=error+'ingrese si quiera '+i+' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo2_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo2_'+i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo2_'+i).removeClass('has-error');
            }
        }
        
        if ($('#proyecto-objetivo_especifico_2').val()=='') {
            error=error+'Ingrese el Objetivo especifico 2 <br>';
            $('.field-proyecto-objetivo_especifico_2').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_2').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_2').removeClass('has-error');
        }
        
        
        if (error!='') {
            $.notify({
                message: error 
            },{
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
            $("#txt_objetivo_especifico_2").html($('#proyecto-objetivo_especifico_2').val());
            $('.field-proyecto-objetivo_especifico_2').css( 'color', 'black' );
            $( "#w0" ).submit();
            return true;
        }
    });
    
    $("#btn_objetivo_especifico_3").click(function(event){
        var error='';
        
        if ($('#proyecto-objetivo_especifico_3').val()=='') {
            error=error+'Ingrese el Objetivo especifico 3 <br>';
            $('.field-proyecto-objetivo_especifico_3').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_3').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_3').removeClass('has-error');
        }
            
        var objetivo3=$('input[name=\'Proyecto[actividades_3][]\']').length;
        for (var i=0; i<objetivo3; i++) {
            if($('#proyecto-actividad_objetivo3_'+i).val()=='')
            {
                error=error+'ingrese si quiera '+i+' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo3_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo3_'+i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo3_'+i).removeClass('has-error');
            }
        }
        
        
        
        if (error!='') {
            $.notify({
                message: error 
            },{
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
            $("#txt_objetivo_especifico_3").html($('#proyecto-objetivo_especifico_3').val());
            $('.field-proyecto-objetivo_especifico_3').css( 'color', 'black' );
            $( "#w0" ).submit();
            return true;
        }
    });
    
    $("#btnproyecto").click(function(event){
        var error='';
        
        if($('#proyecto-titulo').val()=='')
        {
            error=error+'ingrese titulo del proyecto <br>';
            $('.field-proyecto-titulo').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-titulo').addClass('has-success');
            $('.field-proyecto-titulo').removeClass('has-error');
        }
        
        if($('#proyecto-resumen').val()=='')
        {
            error=error+'ingrese resumen del proyecto <br>';
            $('.field-proyecto-resumen').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-resumen').addClass('has-success');
            $('.field-proyecto-resumen').removeClass('has-error');
        }
        
        if($('#proyecto-beneficiario').val()=='')
        {
            error=error+'ingrese objetivo general del proyecto <br>';
            $('.field-proyecto-beneficiario').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-beneficiario').addClass('has-success');
            $('.field-proyecto-beneficiario').removeClass('has-error');
        }
        
        
        if($('#proyecto-objetivo_general').val()=='')
        {
            error=error+'ingrese objetivo general del proyecto <br>';
            $('.field-proyecto-objetivo_general').addClass('has-error');
            $('.field-proyecto-objetivo_general').css( 'color', '#a94442' );
            
        }
        else
        {
            $('.field-proyecto-objetivo_general').addClass('has-success');
            $('.field-proyecto-objetivo_general').removeClass('has-error');
            $('.field-proyecto-objetivo_general').css( 'color', 'black' );
        }
        
        if($('#proyecto-objetivo_especifico_1').val()=='')
        {
            error=error+'ingrese objetivo especifico 1   <br>';
            $('.field-proyecto-objetivo_especifico_1').addClass('has-error');
            $('.field-proyecto-objetivo_especifico_1').css( 'color', '#a94442' );
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_1').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_1').removeClass('has-error');
            $('.field-proyecto-objetivo_especifico_1').css( 'color', 'black' );
        }
        
        if($('#proyecto-objetivo_especifico_2').val()=='')
        {
            error=error+'ingrese objetivo especifico 2   <br>';
            $('.field-proyecto-objetivo_especifico_2').addClass('has-error');
            $('.field-proyecto-objetivo_especifico_2').css( 'color', '#a94442' );
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_2').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_2').removeClass('has-error');
            $('.field-proyecto-objetivo_especifico_2').css( 'color', 'black' );
        }
        
        
        
        if(error!='')
        {
            $.notify({
                message: error 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        return true;
    });
    
    $('.numerico').keypress(function (tecla) {
        var reg = /^[0-9\s]+$/;
        if(!reg.test(String.fromCharCode(tecla.which))){
            return false;
        }
        return true;
    });
    
    $('#btnproyectoreflexion').click(function(events){
        var error='';
        
        if($.trim($('#proyecto-reflexion').val())=='')
        {
            error=error+'ingrese una reflexión del proyecto <br>';
            $('.field-proyecto-reflexion').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-reflexion').addClass('has-success');
            $('.field-proyecto-reflexion').removeClass('has-error');
        }
        
        if(error!='')
        {
            $.notify({
                message: error 
            },{
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
                data: {'Reflexion[reflexion]':$('#proyecto-reflexion').val(),'Reflexion[proyecto_id]':<?= $proyecto->id ?>,'Reflexion[user_id]':<?= \Yii::$app->user->id ?>},
                success: function(data){
                    $.notify({
                        message: 'Se ha guardado tu reflexión' 
                    },{
                        type: 'success',
                        z_index: 1000000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                    });
                    
                    setTimeout(function(){
                                        window.location.reload(1);
                                    }, 1000); 
                }
            });
            return true;
        }
        
    });
    
    
    
    
    $('#btnproyectoevaluacion').click(function(events){
        var error='';
        
        if($.trim($('#proyecto-evaluacion').val())=='')
        {
            error=error+'ingrese una evaluacion del proyecto <br>';
            $('.field-proyecto-evaluacion').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-evaluacion').addClass('has-success');
            $('.field-proyecto-evaluacion').removeClass('has-error');
        }
        
        if(error!='')
        {
            $.notify({
                message: error 
            },{
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
                url: '<?= $evaluacion ?>',
                type: 'POST',
                async: true,
                data: {'Evaluacion[evaluacion]':$('#proyecto-evaluacion').val(),'Evaluacion[proyecto_id]':<?= $proyecto->id ?>,'Evaluacion[user_id]':<?= \Yii::$app->user->id ?>},
                success: function(data){
                    $.notify({
                        message: 'Se ha guardado tu evaluación' 
                    },{
                        type: 'success',
                        z_index: 1000000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                    });
                    $( "#w0" ).submit();
                }
            });
            
            setTimeout(function(){
                                        window.location.reload(1);
                                    }, 1000); 
            return true;
        }
        
    });
    
    
    (function() {
    
        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');
        $('#w0').ajaxForm({
            beforeSend: function() {
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
                
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
                //console.log(percentVal, position, total);
            },
            success: function() {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);
                $( "#w0" ).submit();
            },
            complete: function(xhr) {
                status.html(xhr.responseText);
                $( "#w0" ).submit();
                /*setTimeout(function(){
                                        window.location.reload(1);
                                    }, 10);*/
            }
        }); 
    })();  
</script>





