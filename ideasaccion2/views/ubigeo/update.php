<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ubigeo */

$this->title = 'Update Ubigeo: ' . ' ' . $model->department_id;
$this->params['breadcrumbs'][] = ['label' => 'Ubigeos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->department_id, 'url' => ['view', 'department_id' => $model->department_id, 'district_id' => $model->district_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ubigeo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
