<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ForoComentarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Foro Comentarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foro-comentario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Foro Comentario', ['create'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'contenido',
            'foro_id',
            'user_id',
            'creado_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
