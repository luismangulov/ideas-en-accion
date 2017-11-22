<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VotacionInterna */

$this->title = 'Create Votacion Interna';
$this->params['breadcrumbs'][] = ['label' => 'Votacion Internas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="votacion-interna-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
