<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UbigeoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ubigeos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ubigeo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ubigeo', ['create'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'department_id',
            'province_id',
            'district_id',
            'pais',
            // 'department',
            // 'province',
            // 'district',
            // 'pais_id',
            // 'latitude',
            // 'longitud',
            // 'district_id_standart',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
