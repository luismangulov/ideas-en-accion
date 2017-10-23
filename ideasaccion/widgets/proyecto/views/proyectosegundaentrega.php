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

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
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

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" style="background: white;">
                <div class="col-md-12 text-center">
                    <button style="background:#f6de34;color: #1f2a69;border-color:#f6de34;font-weight:bold" class="btn  btn-lateral" href="#tab_11" data-toggle="tab" aria-expanded="false">Proyecto</button>
                    <button style="background:#f6de34;color: #1f2a69;border-color:#f6de34;font-weight:bold" class="btn  btn-lateral" href="#tab_12" data-toggle="tab" aria-expanded="false">Video</button>
                </div>
                <?php /* <li class="active"><a href="#tab_11" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Datos generales</a></li>
                  <li class=""><a href="#tab_19" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Objetivos y actividades</a></li>
                  <!--<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Resultado</a></li>
                  <li class=""><a href="#tab_12" data-toggle="tab" aria-expanded="false">Resultado</a></li>-->
                  <li class=""><a href="#tab_13" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Presupuesto</a></li>
                  <li class=""><a href="#tab_14" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Cronograma</a></li>
                  <li class=""><a href="#tab_15" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Mi Video</a></li> */ ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_11">
                    <?php if ($proyecto->formato_proyecto2 == 0) { ?>
                        <div class="col-md-12" style="height: 660px; ">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h4 style="margin-bottom: 0px;padding-bottom: 0px;color: black"><label>Título:</label> </h4>
                                <p class="text-justify" style="padding-bottom: 5px"><?= $proyecto->titulo ?></p>
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
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h4><b>Objetivos Específicos</b>  </h4>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div id="mostrar_oe_actividades">
                                    <div class='col-xs-12 col-sm-12 col-md-12'>
                                        <?php if ($proyecto->objetivo_especifico_1) { ?>
                                            <li><b><?= $proyecto->objetivo_especifico_1 ?></b></li>
                                            <input type='hidden' value='<?= $proyecto->objetivo_especifico_1 ?>' name='Proyecto[objetivo_especifico_1]'>
                                            <ul>
                                                <?php foreach ($actividades as $actividad) { ?>
                                                    <?php if ($actividad->objetivo_especifico_id == $proyecto->objetivo_especifico_1_id) { ?>
                                                        <li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_1][]'></li>
                                                        <input type="hidden" name="Proyecto[actividades_ids_1][]" placeholder="Actividad" value="<?= $actividad->actividad_id ?>" <?= $disabled ?>/>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                            <?php $contoe = 1; ?>
                                        <?php } ?>
                                    </div>

                                    <div class='col-xs-12 col-sm-12 col-md-12'>
                                        <?php if ($proyecto->objetivo_especifico_2) { ?>
                                            <li><b><?= $proyecto->objetivo_especifico_2 ?></b></li>
                                            <input type='hidden' value='<?= $proyecto->objetivo_especifico_2 ?>' name='Proyecto[objetivo_especifico_2]'>
                                            <ul>
                                                <?php foreach ($actividades as $actividad) { ?>
                                                    <?php if ($actividad->objetivo_especifico_id == $proyecto->objetivo_especifico_2_id) { ?>
                                                        <li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_2][]'></li>
                                                        <input type="hidden" name="Proyecto[actividades_ids_2][]" placeholder="Actividad" value="<?= $actividad->actividad_id ?>" <?= $disabled ?>/>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                            <?php $contoe = 2; ?>
                                        <?php } ?>
                                    </div>

                                    <div class='col-xs-12 col-sm-12 col-md-12'>
                                        <?php if ($proyecto->objetivo_especifico_3) { ?>
                                            <li><b><?= $proyecto->objetivo_especifico_3 ?></b></li>
                                            <input type='hidden' value='<?= $proyecto->objetivo_especifico_3 ?>' name='Proyecto[objetivo_especifico_3]'>
                                            <ul>
                                                <?php foreach ($actividades as $actividad) { ?>
                                                    <?php if ($actividad->objetivo_especifico_id == $proyecto->objetivo_especifico_3_id) { ?>
                                                        <li><?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_3][]'></li>
                                                        <input type="hidden" name="Proyecto[actividades_ids_3][]" placeholder="Actividad" value="<?= $actividad->actividad_id ?>" <?= $disabled ?>/>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                            <?php $contoe = 3; ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h4><b>Presupuesto</b>  </h4>
                            </div>
                            <div class="clearfix"></div>
                            <?= \app\widgets\planpresupuestal\PlanPresupuestalWidget2::widget(['proyecto_id' => $proyecto->id, 'disabled' => $disabled]); ?> 
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h4><b>Cronograma</b>  </h4>
                            </div>
                            <div class="clearfix"></div>
                            <?= \app\widgets\cronograma\CronogramaWidget2::widget(['proyecto_id' => $proyecto->id, 'disabled' => $disabled]); ?>
                            <div class="clearfix"></div>
                            <div class="col-md-12" >
                                <?php /* if($etapa->etapa==2 || $etapa->etapa==3){ ?>
                                  <?php //= \app\widgets\foro\ForoPrimeraEntregaWidget::widget(['proyecto_id'=>$proyecto->id,'seccion'=>$seccion]); ?>
                                  <?php } */ ?>
                            </div>


                        </div>
                        <div class="clearfix"></div>
                    <?php } else { ?>
                        <div class="col-md-12" style="height: 660px; ">
                            <embed style='overflow: hidden' type='text/html' src= "<?= \Yii::$app->request->BaseUrl ?>/proyectos/<?= $proyecto->proyecto_archivo2 ?>" width=100% height=100% >
                        </div>
                        <div class="col-md-12" >
                            <?php //if($etapa->etapa==2 || $etapa->etapa==3){  ?>
                            <?php //= \app\widgets\foro\ForoPrimeraEntregaWidget::widget(['proyecto_id'=>$proyecto->id,'seccion'=>$seccion]); ?> 
                            <?php //}?>
                        </div>

                    <?php } ?>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_12">
                    <div class="clearfix"></div>
                    <?php if ($videosegunda) { ?>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <?php
                            if ($videosegunda->ruta && $videosegunda->tipo == 1) {
                                $url = $videosegunda->ruta;
                                parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
                                $v_variable = "";

                                if (!empty($my_array_of_vars['v'])) {
                                    $v_variable = $my_array_of_vars['v'];
                                }
                                ?>
                                <br>
                                <iframe allowfullscreen="allowfullscreen"  type="text/html" 
                                        width="320" 
                                        height="240" 
                                        src="https://www.youtube.com/embed/<?= $v_variable ?>" 
                                        frameborder="0">
                                </iframe>
                            <?php } elseif ($videosegunda->tipo == 2) { ?>
                                <video width="320" height="240" controls>
                                    <source src="<?= Yii::getAlias('@video') . $videosegunda->ruta ?>" >  
                                </video>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div>

            </div><!-- /.tab-content -->
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>



<?php ActiveForm::end(); ?>

<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.7/jquery.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/jquery.form.js"></script>

<?php
$this->registerJs(
        "$('document').ready(function(){})");
?>
<?php
$eliminaractividad = Yii::$app->getUrlManager()->createUrl('proyecto/eliminaractividad');
$reflexion = Yii::$app->getUrlManager()->createUrl('proyecto/reflexion');
$evaluacion = Yii::$app->getUrlManager()->createUrl('proyecto/evaluacion');
?>
<script>


    $("#btn_objetivo_general").click(function (event) {
        if ($('#proyecto-objetivo_general').val() == '') {
            $.notify({
                message: 'Ingrese el Objetivo General'
            }, {
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
        $('.field-proyecto-objetivo_general').css('color', 'black');
        $("#txt_objetivo_general").html($('#proyecto-objetivo_general').val());
        return true;
    });

    $("#btn_objetivo_especifico_1").click(function (event) {
        var error = '';
        if ($('#proyecto-objetivo_especifico_1').val() == '') {
            error = error + ' Ingrese el Objetivo especifico 1 <br>';
            $('.field-proyecto-objetivo_especifico_1').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_1').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_1').removeClass('has-error');
        }

        var objetivo1 = $('input[name=\'Proyecto[actividades_1][]\']').length;
        for (var i = 0; i < objetivo1; i++) {
            if ($('#proyecto-actividad_objetivo1_' + i).val() == '')
            {
                error = error + 'ingrese si quiera ' + i + ' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo1_' + i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo1_' + i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo1_' + i).removeClass('has-error');
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
        else
        {
            $("#txt_objetivo_especifico_1").html($('#proyecto-objetivo_especifico_1').val());
            $('.field-proyecto-objetivo_especifico_1').css('color', 'black');
            $("#w0").submit();
            return true;
        }

    });

    $("#btn_objetivo_especifico_2").click(function (event) {
        var error = '';

        var objetivo2 = $('input[name=\'Proyecto[actividades_2][]\']').length;
        for (var i = 0; i < objetivo2; i++) {
            if ($('#proyecto-actividad_objetivo2_' + i).val() == '')
            {
                error = error + 'ingrese si quiera ' + i + ' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo2_' + i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo2_' + i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo2_' + i).removeClass('has-error');
            }
        }

        if ($('#proyecto-objetivo_especifico_2').val() == '') {
            error = error + 'Ingrese el Objetivo especifico 2 <br>';
            $('.field-proyecto-objetivo_especifico_2').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_2').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_2').removeClass('has-error');
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
        else
        {
            $("#txt_objetivo_especifico_2").html($('#proyecto-objetivo_especifico_2').val());
            $('.field-proyecto-objetivo_especifico_2').css('color', 'black');
            $("#w0").submit();
            return true;
        }
    });

    $("#btn_objetivo_especifico_3").click(function (event) {
        var error = '';

        if ($('#proyecto-objetivo_especifico_3').val() == '') {
            error = error + 'Ingrese el Objetivo especifico 3 <br>';
            $('.field-proyecto-objetivo_especifico_3').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_3').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_3').removeClass('has-error');
        }

        var objetivo3 = $('input[name=\'Proyecto[actividades_3][]\']').length;
        for (var i = 0; i < objetivo3; i++) {
            if ($('#proyecto-actividad_objetivo3_' + i).val() == '')
            {
                error = error + 'ingrese si quiera ' + i + ' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo3_' + i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo3_' + i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo3_' + i).removeClass('has-error');
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
        else
        {
            $("#txt_objetivo_especifico_3").html($('#proyecto-objetivo_especifico_3').val());
            $('.field-proyecto-objetivo_especifico_3').css('color', 'black');
            $("#w0").submit();
            return true;
        }
    });

    $("#btnproyecto").click(function (event) {
        var error = '';

        if ($('#proyecto-titulo').val() == '')
        {
            error = error + 'ingrese titulo del proyecto <br>';
            $('.field-proyecto-titulo').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-titulo').addClass('has-success');
            $('.field-proyecto-titulo').removeClass('has-error');
        }

        if ($('#proyecto-resumen').val() == '')
        {
            error = error + 'ingrese resumen del proyecto <br>';
            $('.field-proyecto-resumen').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-resumen').addClass('has-success');
            $('.field-proyecto-resumen').removeClass('has-error');
        }

        if ($('#proyecto-beneficiario').val() == '')
        {
            error = error + 'ingrese objetivo general del proyecto <br>';
            $('.field-proyecto-beneficiario').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-beneficiario').addClass('has-success');
            $('.field-proyecto-beneficiario').removeClass('has-error');
        }


        if ($('#proyecto-objetivo_general').val() == '')
        {
            error = error + 'ingrese objetivo general del proyecto <br>';
            $('.field-proyecto-objetivo_general').addClass('has-error');
            $('.field-proyecto-objetivo_general').css('color', '#a94442');

        }
        else
        {
            $('.field-proyecto-objetivo_general').addClass('has-success');
            $('.field-proyecto-objetivo_general').removeClass('has-error');
            $('.field-proyecto-objetivo_general').css('color', 'black');
        }

        if ($('#proyecto-objetivo_especifico_1').val() == '')
        {
            error = error + 'ingrese objetivo especifico 1   <br>';
            $('.field-proyecto-objetivo_especifico_1').addClass('has-error');
            $('.field-proyecto-objetivo_especifico_1').css('color', '#a94442');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_1').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_1').removeClass('has-error');
            $('.field-proyecto-objetivo_especifico_1').css('color', 'black');
        }

        if ($('#proyecto-objetivo_especifico_2').val() == '')
        {
            error = error + 'ingrese objetivo especifico 2   <br>';
            $('.field-proyecto-objetivo_especifico_2').addClass('has-error');
            $('.field-proyecto-objetivo_especifico_2').css('color', '#a94442');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_2').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_2').removeClass('has-error');
            $('.field-proyecto-objetivo_especifico_2').css('color', 'black');
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
        return true;
    });

    $('.numerico').keypress(function (tecla) {
        var reg = /^[0-9\s]+$/;
        if (!reg.test(String.fromCharCode(tecla.which))) {
            return false;
        }
        return true;
    });

    $('#btnproyectoreflexion').click(function (events) {
        var error = '';

        if ($.trim($('#proyecto-reflexion').val()) == '')
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


        var error = '';

        if ($.trim($('#proyecto-evaluacion').val()) == '')
        {
            error = error + 'ingrese una evaluacion del proyecto <br>';
            $('.field-proyecto-evaluacion').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-evaluacion').addClass('has-success');
            $('.field-proyecto-evaluacion').removeClass('has-error');
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
                url: '<?= $evaluacion ?>',
                type: 'POST',
                async: true,
                data: {'Evaluacion[evaluacion]': $('#proyecto-evaluacion').val(), 'Evaluacion[proyecto_id]':<?= $proyecto->id ?>, 'Evaluacion[user_id]':<?= \Yii::$app->user->id ?>},
                success: function (data) {
                    $.notify({
                        message: 'Se ha guardado tu evaluación'
                    }, {
                        type: 'success',
                        z_index: 1000000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                    });
                    $("#w0").submit();
                }
            });

            setTimeout(function () {
                window.location.reload(1);
            }, 1000);
            return true;
        }

    });


    (function () {

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
                $("#w0").submit();
            },
            complete: function (xhr) {
                status.html(xhr.responseText);
                $("#w0").submit();
                /*setTimeout(function(){
                 window.location.reload(1);
                 }, 10);*/
            }
        });
    })();

    $(document).ready(function () {
// Handler for .ready() called.

        $("#lnk_segunda").attr("class", "active");
    });
</script>





 