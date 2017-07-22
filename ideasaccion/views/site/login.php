<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;




$this->title = 'Iniciar sesión';
?>

<script src="<?= \Yii::$app->request->BaseUrl ?>/js/bootstrap-notify.js"></script>

    <?= \app\widgets\login\LoginWidget::widget(['tipo'=>2]); ?>

<?php if (Yii::$app->session->hasFlash('registrar')): ?>
<script>
    $.notify({
        // options
        message:    '¡Has completado tu registro! Ahora solo tienes que seguir las instrucciones del correo'+
                    ' de confirmación que te acabamos de enviar. Búscalo en tus bandejas (¡por si acaso revisa también en spam!).' 
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


