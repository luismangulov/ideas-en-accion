<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ubigeo */

$this->title = $model->department_id;
$this->params['breadcrumbs'][] = ['label' => 'Ubigeos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ubigeo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'department_id' => $model->department_id, 'district_id' => $model->district_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'department_id' => $model->department_id, 'district_id' => $model->district_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'department_id',
            'province_id',
            'district_id',
            'pais',
            'department',
            'province',
            'district',
            'pais_id',
            'latitude',
            'longitud',
            'district_id_standart',
        ],
    ]) ?>

</div>
