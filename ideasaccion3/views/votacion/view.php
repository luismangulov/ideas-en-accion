<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Votacion */

$this->title = $model->asunto_id;
$this->params['breadcrumbs'][] = ['label' => 'Votacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="votacion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'asunto_id' => $model->asunto_id, 'region_id' => $model->region_id, 'participante_id' => $model->participante_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'asunto_id' => $model->asunto_id, 'region_id' => $model->region_id, 'participante_id' => $model->participante_id], [
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
            'asunto_id',
            'region_id',
            'participante_id',
            'fecha_registro',
            'estado',
        ],
    ]) ?>

</div>
