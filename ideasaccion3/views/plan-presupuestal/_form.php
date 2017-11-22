<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PlanPresupuestal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-presupuestal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'recurso')->textInput() ?>

    <?= $form->field($model, 'como_conseguirlo')->textInput() ?>

    <?= $form->field($model, 'precio_unitario')->textInput() ?>

    <?= $form->field($model, 'cantidad')->textInput() ?>

    <?= $form->field($model, 'subtotal')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
