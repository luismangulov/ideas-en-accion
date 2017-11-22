<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ubigeo */

$this->title = 'Create Ubigeo';
$this->params['breadcrumbs'][] = ['label' => 'Ubigeos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ubigeo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
