<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlanPresupuestalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plan Presupuestals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-presupuestal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Plan Presupuestal', ['create'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'recurso',
            'como_conseguirlo',
            'precio_unitario',
            'cantidad',
            // 'subtotal',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
