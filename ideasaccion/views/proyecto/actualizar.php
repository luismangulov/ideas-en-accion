<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProyectoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proyectos';
?>

<?= \app\widgets\proyecto\ActualizarProyectoWidget::widget(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        // Handler for .ready() called.

        $("#lnk_proyecto").attr("class", "active");
    });



</script>