<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Resultados;
use yii\widgets\Pjax;
use yii\web\JsExpression;

$this->title = "Ideas en acción";
/* @var $this \yii\web\View */
/* @var $user \common\models\LoginForm */
/* @var $title string */
?>
<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.11.1/jquery.min.js"></script>

<?= \app\widgets\proyecto\ProyectoSegundaEntregaWidget::widget(); ?>


