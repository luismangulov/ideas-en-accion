<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Equipo */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_send_big.png" alt=""> Finalizando equipo
</div>
<div class="box_content contenido_seccion_crear_equipo">
<?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
        <div class="form-group label-floating field-equipo-email required" style="margin-top: 15px">
            <label class="control-label" for="equipo-email">Correo electrónico*</label>
            <input  style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="email" id="equipo-email" class="form-control" name="Equipo[email]">
        </div>
    </div>
    <div class="col-md-6">
        <button type="submit" id="finalizar"  class="btn  btn-default" >
            Finalizar
        </button>
    </div>
    <div class="col-md-12">
        <?= $mensaje ?>
    </div>
<?php ActiveForm::end(); ?>
</div>

<script>
    $( '#finalizar' ).click(function( event ) {
        if (jQuery.trim($("#equipo-email").val())=='') {
            $.notify({
                    // options
                    message: 'Ingrese un email' 
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