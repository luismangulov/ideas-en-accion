<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Foro */

$this->title="Ideas en acción";
$this->params['breadcrumbs'][] = ['label' => 'Foros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$usuario=$model->usuario;
$posts = $model->getPosts($model->id);
?>
   <?= \app\widgets\proyecto\ProyectoBuscarMonitorPrimeraEntregaWidget::widget(['proyecto_id'=>$model->proyecto_id]); ?>

<script nonce="<?= getnonceideas() ?>"  type="text/javascript">
    $(document).ready(function() {
// Handler for .ready() called.

        $("#lnk_reportesegunda").addClass("active");
        $("#lnk_reportesegunda").parent().find("ul").show();
        $("#lnk_reportesegunda_aporte").addClass("active");


    });



</script>