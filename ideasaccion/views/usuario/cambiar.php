<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_team_big.jpg" alt=""> Cambiar de contraseña
</div>
<div  class="box_content contenido_seccion_crear_equipo">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Contraseña') ?>
        
        <div class="form-group">
            <?= Html::submitButton('cambiar', ['class' => 'btn btn-default' ]) ?>
        </div>
        
    <?php ActiveForm::end(); ?>
</div>

<?php if (Yii::$app->session->hasFlash('contrasena')): ?>
<script>
    $.notify({
        // options
        message: 'Se ha cambiado la contraseña' 
    },{
        // settings
        type: 'success',
        z_index: 1000000,
        placement: {
                from: 'bottom',
                align: 'right'
        },
    });

</script>
<?php endif; ?>