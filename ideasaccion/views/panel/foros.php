<?php
use yii\helpers\Html;
use app\models\Ubigeo;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
$this->title="Ideas en acción";

$foros = $resultado->getForos($resultado->region_id,$sort->orders);

$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($votos['pages']->pageSize * $_GET['page']) - $votos['pages']->pageSize;
    
?>

<style>
    hr{
        margin-top:10px !important;
        
        margin-bottom: 10px !important;
    }
</style>
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">Foros
</div>
<div class="box_content contenido_seccion_crear_equipo" >
    <?php /*
    <?php $form = ActiveForm::begin([
        'action' => ['panel/foros'],
        'method' => 'get',
    ]); ?>
        <div class="md-col-6">
            <div class="form-group label-floating field-voto-region required">
                <select id="resultados-region_id" class="form-control" name="Resultados[region_id]" onchange="Region(event)">
                    <option value>Selecciona tu región</option>
                    <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
                        <option value="<?= $departamento->department_id ?>" <?= ($resultado->region_id==$departamento->department_id)?'selected':'' ?>  ><?= $departamento->department ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    
    <table class="table">
        <thead style="background: #D9D9D9">
            <th><b>Asunto</b></th>
            <th><b>Total</b></th>
            <th><b>Valorados</b></th>
            <th><b>Pendientes</b></th>
            <th><b>Emitidos</b></th>
        </thead>
        <tbody>
        <?php foreach($foros['resultados'] as $foro):
            $floor_number=$floor++; //?????
            ?>
            <tr>
                <td><?= Html::a($foro['titulo'],['foro/viewadmin','id'=>$foro['id']],[]);?></td>
                <td><?= $foro['total'] ?> </td>
                <td><?= $foro['valorado'] ?></td>
                <td><?= $foro['pendiente'] ?></td>
                <td><?= $foro['emitido'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>    
        <?= LinkPager::widget([
            'pagination' => $foros['pages'],
            'lastPageLabel' => true,
            'firstPageLabel' => true
        ]);?>
    */ ?>   
  
    <div class="clearfix"></div>
    <div class="col-md-4 text-center" >Asunto</div>
    <div class="col-md-2 text-center">Total</div>
    <div class="col-md-2 text-center">Valorados</div>
    <div class="col-md-2 text-center">Pendientes</div>
    <div class="col-md-2 text-center">Emitidos</div>
    <div class="clearfix"></div>
    <hr>
    <div class="col-md-4 text-left"><?= Html::a('Participación estudiantil',['foro/viewadmin','id'=>$foroparticipacion->id],[]);?>  </div>
    <div class="col-md-2 text-right"><?= $foroparticipacion->total ?></div>
    <div class="col-md-2 text-right"><?= $foroparticipacion->valorado ?></div>
    <div class="col-md-2 text-right"><?= $foroparticipacion->pendiente ?></div>
    <div class="col-md-2 text-right"><?= $foroparticipacion->emitido ?></div>
    <div class="clearfix"></div>
    <?php foreach($forospublicos as $foropublico): ?>
        <hr>
        <div class="col-md-4 text-left"><?= Html::a($foropublico->titulo,['foro/viewadmin','id'=>$foropublico->id],[]);?> </div>
        <div class="col-md-2 text-right"><?= $foropublico->total ?></div>
        <div class="col-md-2 text-right"><?= $foropublico->valorado ?></div>
        <div class="col-md-2 text-right"><?= $foropublico->pendiente ?></div>
        <div class="col-md-2 text-right"><?= $foropublico->emitido ?></div>
        <div class="clearfix"></div>
    <?php endforeach; ?>
    <div class='clearfix'></div>
        <div class="form-group pull-rigth col-md-4" >
        <?php /*= Html::a('Descargar',['reporte/foro_descargar'],['class'=>' btn btn-default']); */ ?>
        </div>
    <div class='clearfix'></div>
    
</div>
<script>
    function Region(event) {
        event.preventDefault();
        $( "#w0" ).submit();
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
// Handler for .ready() called.

        $("#lnk_forosgeneral").attr("class", "active");
    });



</script>