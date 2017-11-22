<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ForoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Foros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foro-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Foro', ['create'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'titulo',
            'descripcion',
            'creado_at',
            'actualizado_at',
            // 'user_id',
            // 'post_count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
