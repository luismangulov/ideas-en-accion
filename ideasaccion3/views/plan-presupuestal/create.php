<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PlanPresupuestal */

$this->title = 'Create Plan Presupuestal';
$this->params['breadcrumbs'][] = ['label' => 'Plan Presupuestals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-presupuestal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
