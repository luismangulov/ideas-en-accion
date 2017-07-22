<?php 
$regiones = $model->getRegion($sort->orders);

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;

$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($votos['pages']->pageSize * $_GET['page']) - $votos['pages']->pageSize;

?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_team_big.jpg" alt=""> Reporte 
</div>
<div ng-app="ideasaccion" class="box_content contenido_seccion_crear_equipo">
    
    
    <table class="table">
        <thead style="background: #D9D9D9">
            <th><b><?= $sort->link('region_id')?></b></th>
            <th align="center"><b><?= $sort->link('voto_emitido')?></b></th>
        </thead>
        <tbody>
        <?php
            $a=0;
        ?>
        <?php foreach($regiones['regiones'] as $region):
            $floor_number=$floor++; //?????
            ?>
            <tr>
                <td><?= $region['region_id'] ?></td>
                <td ><?= $region['voto_emitido'] ?></td>
            </tr>
        <?php
            $a=$a+$region['voto_emitido'];
        ?>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Total</b></td>
                <td><b><?= $a ?></b></td>
            </tr>
        </tfoot>
    </table>    
        <?= LinkPager::widget([
            'pagination' => $regiones['pages'],
            'lastPageLabel' => true,
            'firstPageLabel' => true
        ]);?>
        
        <div class='clearfix'></div>
            <div class="form-group pull-rigth col-md-4" >
            <?php /*= Html::a('Descargar',['reporte/region_descargar'],['class'=>' btn btn-default']); */?>
            </div>
        <div class='clearfix'></div>
        
        
    
</div>
<script>
    function Region(event) {
        event.preventDefault();
        $( "#w0" ).submit();
    }
</script>
