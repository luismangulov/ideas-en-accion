<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VotacionInterna */

$this->title = 'Update Votacion Interna: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Votacion Internas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="votacion-interna-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
