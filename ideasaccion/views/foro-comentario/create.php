<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ForoComentario */

$this->title = 'Create Foro Comentario';
$this->params['breadcrumbs'][] = ['label' => 'Foro Comentarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foro-comentario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
