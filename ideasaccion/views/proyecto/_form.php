<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Proyecto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proyecto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resumen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'justificacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'objetivo_general')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'beneficiario_directo_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'beneficiario_directo_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'beneficiario_directo_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'beneficiario_indirecto_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'beneficiario_indirecto_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'beneficiario_indirecto_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-default' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
