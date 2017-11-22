<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PlanPresupuestal */

$this->title = 'Update Plan Presupuestal: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Plan Presupuestals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="plan-presupuestal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
