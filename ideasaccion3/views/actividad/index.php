<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProyectoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actividades';
?>

<?= \app\widgets\actividad\ActividadWidget::widget(['id'=>$id]); ?>