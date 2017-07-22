<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VotacionInterna */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="votacion-interna-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'proyecto_id')->textInput() ?>

    <?= $form->field($model, 'region_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
