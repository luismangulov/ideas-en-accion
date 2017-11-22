<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JustificacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Justificacions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="justificacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Justificacion', ['create'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'actividad_id',
            'plan_presupuestal_id',
            'como_financian',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
