<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ForoComentario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="foro-comentario-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group label-floating">
        <label class="control-label " for="foro_comentario-contenido" style="padding-left: 10px"> Ingrese comentario</label>
        <textarea style="border: 2px solid #1f2a69;padding: 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="foro_comentario-contenido" name="ForoComentario[contenido]" class="textarea form-control" style="width: 100%; height: 80px; font-size: 14px; line-height: 18px; padding: 10px; " ></textarea>
    </div>
    
    
    <div class="col-md-4"></div>
    <div class="col-md-4 text-center">
    <?= Html::submitButton(Yii::t('app', 'Comentar'), ['id'=>'btncomentar','class' => 'btn btn-raised btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<script nonce="<?= getnonceideas() ?>" >
    $( '#btncomentar' ).click(function( event ) {

        var error="";
        
        if (jQuery.trim($("#foro_comentario-contenido").val())=='') {
            error=error+"No ha comentado <br>";
            
        }
        
        
        if (jQuery.trim($("#proyecto-seccion").val())=='') {
            error=error+"Seleccione un sección <br>";
            
        }
        
        if (error!="") {
            $.notify({
                    // options
                    message: error
                },{
                    // settings
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
</script>