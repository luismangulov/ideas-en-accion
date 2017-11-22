<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Votacion */

$this->title = 'Update Votacion: ' . ' ' . $model->asunto_id;
$this->params['breadcrumbs'][] = ['label' => 'Votacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->asunto_id, 'url' => ['view', 'asunto_id' => $model->asunto_id, 'region_id' => $model->region_id, 'participante_id' => $model->participante_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="votacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
