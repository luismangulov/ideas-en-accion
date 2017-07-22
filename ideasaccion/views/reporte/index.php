<?php 
$votos = $model->getVotos($model->region_id,$sort->orders);

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
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
        <div class="md-col-6">
            <div class="form-group label-floating field-voto-region required">
                <select id="voto-region_id" class="form-control" name="Voto[region_id]" onchange="Region(event)">
                    <option value>Selecciona tu región</option>
                    <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
                        <option value="<?= $departamento->department_id ?>" <?= ($model->region_id==$departamento->department_id)?'selected':'' ?>  ><?= $departamento->department ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    
    
    <table class="table">
        <thead style="background: #D9D9D9">
            <th><b><?= $sort->link('descripcion_cabecera')?></b></th>
            <th align="center"><b><?= $sort->link('voto_emitido')?></b></th>
        </thead>
        <tbody>
        <?php
            $a=0;
        ?>
        <?php foreach($votos['votos'] as $voto):
            $floor_number=$floor++; //?????
            ?>
            <tr>
                <td><?= $voto['descripcion_cabecera'] ?></td>
                <td align="center"><?= $voto['voto_emitido'] ?></td>
            </tr>
        <?php
            $a=$a+$voto['voto_emitido'];
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
            'pagination' => $votos['pages'],
            'lastPageLabel' => true,
            'firstPageLabel' => true
        ]);?>
        
        <div class='clearfix'></div>
            <div class="form-group pull-rigth col-md-4" >
            <?php /*= Html::a('Descargar',['reporte/index_descargar','region'=>$model->region_id],['class'=>' btn btn-default']); */ ?>
            </div>
        <div class='clearfix'></div>
        
        
    
</div>
<script>
    function Region(event) {
        event.preventDefault();
        $( "#w0" ).submit();
    }
</script>
