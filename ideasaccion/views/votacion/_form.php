<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Votacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="votacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'asunto_id')->textInput() ?>

    <?= $form->field($model, 'region_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'participante_id')->textInput() ?>

    <?= $form->field($model, 'fecha_registro')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
