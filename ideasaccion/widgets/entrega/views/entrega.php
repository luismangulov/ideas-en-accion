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
<style>
    .bootbox-confirm .modal-dialog
    {
        z-index: 5000 !important;
    }
    .btn-default{
        width: 100%;
        background: #f6de34 !important;
        color: #1f2a69 !important;
        border-color: #f6de34;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 14px;
        line-height: 34px;
        padding-top: 0;
        padding-bottom: 0;
    }

    .btn-default:hover{
        border-color: #1f2a69 !important;
    }

    .btn-primary{
        width: 100%;
        background: #f6de34 !important;
        color: #1f2a69;
        border-color: #f6de34;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 14px;
        line-height: 34px;
        padding-top: 0;
        padding-bottom: 0;
    }

    .btn-primary:hover{
        border-color: #1f2a69 !important;
    }
</style>
<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.11.1/jquery.min.js"></script>
<?php if ($etapa1 && $equipo->etapa == 0) { ?>
    <button class="btn btn-default" type="button" id="btnprimeraentrega" <?= (!$etapa1 || $equipo->etapa == 1) ? 'disabled' : '' ?>>Finalizar 1ra entrega</button>
<?php } ?>
<?php if ($etapa2 && $equipo->etapa == 1) { ?>
    <button class="btn btn-default" type="button" id="btnsegundaentrega" <?= (!$etapa2 || $equipo->etapa == 2) ? 'disabled' : '' ?>>Finalizar 2da entrega</button>
<?php } ?>
<?php /* if($equipo->etapa==1){ ?>
  <button class="btn btn-default" type="button" id="btnsegundaentrega" >Finalizar 2da entrega</button>
  <?php } */ ?>



<?php if ($equipo->etapa == 1 || $equipo->etapa == 2) { ?>
    <?php //= \app\widgets\proyecto\ProyectoPrimeraEntregaWidget::widget(); ?>
<?php } ?>

<?php if ($equipo->etapa == 2) { ?>
    <?php //= \app\widgets\proyecto\ProyectoSegundaEntregaWidget::widget(); ?>
<?php } ?>

<?php
$finalizarprimerentrega = Yii::$app->getUrlManager()->createUrl('proyecto/finalizarprimeraentrega');
$finalizarsegundaentrega = Yii::$app->getUrlManager()->createUrl('proyecto/finalizarsegundaentrega');
?>
<script>

    $('#btnprimeraentrega').click(function(event) {
        var texto = "¿Estás seguro de finalizar la 1ra entrega?";
        var actividad =<?= $actividades ?>;
        var cronograma =<?= $cronogramas ?>;
        var planepresupuestales =<?= $planepresupuestales ?>;
        var asuntosprivados = '<?= $errorasuntoprivado ?>';
        var asuntospublicos = '<?= $errorasuntopublico ?>';
        var reflexion = "<?= $errorreflexion ?>";

        var video =<?= $videoprimera ?>;
        var error = '';
        if (video < 1) {
            error = 'Debe guardar el video del proyecto <br>' + error;
        }

        var proyectoresumen = '<?= nl2br(htmlentities($proyecto->resumen,ENT_QUOTES)) ?>';

        var proyectobeneficiario = '<?= nl2br(htmlentities($proyecto->beneficiario,ENT_QUOTES)) ?>';


        if (jQuery.trim(proyectoresumen) == '') {
            error = 'Debe guardar el resumen del proyecto <br>' + error;
        }

        if (jQuery.trim(proyectobeneficiario) == '') {
            error = 'Debe guardar el objetivo general del proyecto <br>' + error;
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
            bootbox.confirm({
                message: texto,
                buttons: {
                    'cancel': {
                        label: 'Cancelar',
                    },
                    'confirm': {
                        label: 'Aceptar',
                    }
                },
                callback: function(result) {

                    if (result) {

                        $.post("<?= $finalizarprimerentrega ?>", {'Proyecto[id]':<?= $proyecto->id ?>})
                                .done(function(data) {
                                    if (data == 1) {
                                        $.notify({
                                            message: 'Gracias se ha cerrado la 1era entrega'
                                        }, {
                                            type: 'success',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                        setTimeout(function() {
                                            window.location.reload(1);
                                        }, 1);
                                    }
                                });
                    }

                }
            });
            /*
             $.ajax({
             url: '<?= $finalizarprimerentrega ?>',
             type: 'POST',
             async: true,
             data: {'Proyecto[id]':<?= $proyecto->id ?>},
             success: function(data){
             
             
             }
             });*/
            return true;
        }
    });
    $('#btnsegundaentrega').click(function(event) {
        var error = '';
        //var evaluacion='<?= $errorevaluacion ?>';
        // var recomendacion='<?= $errorrecomendaciones ?>';
        var video =<?= $videosegunda ?>;
        /*if (evaluacion!='') {
         error=evaluacion+error;
         }*/
        /*
         if (recomendacion!='') {
         error=recomendacion+error;
         }*/
        if (video < 1) {
            error = 'Debe ingresar el video de la Segunda etapa del proyecto <br>' + error;
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
            $.ajax({
                url: '<?= $finalizarsegundaentrega ?>',
                type: 'POST',
                async: true,
                data: {'Proyecto[id]':<?= $proyecto->id ?>},
                success: function(data) {
                    if (data == 1) {
                        $.notify({
                            message: 'Gracias se ha cerrado la 2da entrega'
                        }, {
                            type: 'success',
                            z_index: 1000000,
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                        });
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1000);
                    }

                }
            });
            return true;
        }
    });
</script>