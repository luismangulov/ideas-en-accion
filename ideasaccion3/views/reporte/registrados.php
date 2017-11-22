<?php 
$registrados = $model->getRegistrados($sort->orders);

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;

$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($registrados['pages']->pageSize * $_GET['page']) - $registrados['pages']->pageSize;

?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_team_big.jpg" alt=""> Reporte de Participantes
</div>
<div class="box_content contenido_seccion_crear_equipo">
    
    
    
    <table class="table">
        <thead style="background: #D9D9D9">
            <th class="text-center"><b><?= $sort->link('department')?></b></th>
            <th class="text-center"><b>Total</b></th>
            <th class="text-center"><b>Finalizaron equipos</b></th>
            <th class="text-center"><b>Falta finalizar equipo</b></th>
            <th class="text-center"><b>Invitaciones pendientes</b></th>
            <th class="text-center"><b>Sin equipo</b></th>
        </thead>
        <tbody>
        <?php
            $a=0;
            $b=0;
            $c=0;
            $d=0;
            $e=0;
        ?>
        <?php foreach($registrados['registrados'] as $registrado):
            $floor_number=$floor++; //?????
            ?>
            <tr>
                <td class="text-left"><?= $registrado['department'] ?></td>
                <td class="text-right"><?= $registrado['total_estudiantes'] ?></td>
                <td class="text-right"><?= $registrado['estudiantes_finalizaron_equipo'] ?></td>
                <td class="text-right"><?= $registrado['estudiantes_aceptaron_invitacion'] ?></td>
                <td class="text-right"><?= $registrado['estudiantes_invitaciones_pendientes'] ?></td>
                <td class="text-right"><?= $registrado['estudiantes_huerfanos'] ?></td>
            </tr>
            <?php
                $a=$a+$registrado['total_estudiantes'];
                $b=$b+$registrado['estudiantes_finalizaron_equipo'];
                $c=$c+$registrado['estudiantes_aceptaron_invitacion'];
                $d=$d+$registrado['estudiantes_invitaciones_pendientes'];
                $e=$e+$registrado['estudiantes_huerfanos'];
            ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Total</b></td>
                <td class="text-right"><b><?= $a ?></b></td>
                <td class="text-right"><b><?= $b ?></b></td>
                <td class="text-right"><b><?= $c ?></b></td>
                <td class="text-right"><b><?= $d ?></b></td>
                <td class="text-right"><b><?= $e ?></b></td>
            </tr>
        </tfoot>
    </table>    
       
        
        <div class='clearfix'></div>
    <div class='clearfix'></div>
            <div class="form-group pull-rigth col-md-4" >
            <?php /*= Html::a('Descargar',['reporte/registrados_descargar'],['class'=>' btn btn-default']); */ ?>
            </div>
        <div class='clearfix'></div>
        
    
</div>
<script nonce="<?= getnonceideas() ?>"  type="text/javascript">
    $(document).ready(function() {
// Handler for .ready() called.

        $("#lnk_reporteinscripcion").addClass("active");
        $("#lnk_reporteinscripcion").parent().find("ul").show();
        $("#lnk_reporteestudiantes").addClass("active");
        
        
    });



</script>