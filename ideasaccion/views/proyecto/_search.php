<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProyectoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proyecto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'resumen') ?>

    <?= $form->field($model, 'justificacion') ?>

    <?= $form->field($model, 'objetivo_general') ?>

    <?php // echo $form->field($model, 'beneficiario_directo_1') ?>

    <?php // echo $form->field($model, 'beneficiario_directo_2') ?>

    <?php // echo $form->field($model, 'beneficiario_directo_3') ?>

    <?php // echo $form->field($model, 'beneficiario_indirecto_1') ?>

    <?php // echo $form->field($model, 'beneficiario_indirecto_2') ?>

    <?php // echo $form->field($model, 'beneficiario_indirecto_3') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
