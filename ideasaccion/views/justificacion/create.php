<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Justificacion */

$this->title = 'Create Justificacion';
$this->params['breadcrumbs'][] = ['label' => 'Justificacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="justificacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
