<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<button class="btn" id="cerrarvoto">cerrar voto</button>


<?php
    //$url= Yii::$app->getUrlManager()->createUrl('voto/validardni');
    $this->registerJs(
    "$('document').ready(function(){
        $( '#cerrarvoto' ).click(function() {
            $.ajax({
                url: 'cerrar',
                //dataType: 'json',
                type: 'GET',
                async: true,
                data: {bandera:1},
                success: function(data){
                    if(data==1)
                    {
                        $.notify({
                            // options
                            message: 'El DNI ya existe' 
                        },{
                            // settings
                            type: 'danger',
                            z_index: 1000000,
                            placement: {
                                    from: 'bottom',
                                    align: 'right'
                            },
                        });
                        $('#voto-dni').val('');
                        return false;
                    }
                }
            });
        });
    });");
?>