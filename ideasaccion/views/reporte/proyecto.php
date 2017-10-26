<?php 
$proyectos = $model->getProyectos($sort->orders,$model->region_id);

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;

$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($proyectos['pages']->pageSize * $_GET['page']) - $proyectos['pages']->pageSize;

?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_team_big.jpg" alt=""> Reporte de proyectos
</div>
<div ng-app="ideasaccion" class="box_content contenido_seccion_crear_equipo">
    <?php $form = ActiveForm::begin([
        'action' => ['proyecto'],
        'method' => 'get',
    ]); ?>
        <div class="md-col-6">
            <div class="form-group label-floating field-voto-region required">
                <select id="proyecto-region_id" class="form-control" name="Proyecto[region_id]" onchange="Region(event)">
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
            <th><b>Institución educativa</b></th>
            <th><b>Título del proyecto</b></th>
            <th><b>Proyecto finalizado</b></th>
            <th><b>Registro del video</b></th>
            
        </thead>
        <tbody>
        <?php foreach($proyectos['proyectos'] as $proyecto):
            $floor_number=$floor++; //?????
            ?>
            <tr>
                <td><?= htmlentities($proyecto['denominacion'],ENT_QUOTES) ?></td>
                <td><span class="popover1" data-type='html' style="cursor: pointer"  title  ='<?= str_replace(['\'\'','\''],'"',htmlentities($proyecto['titulo'],ENT_QUOTES)) ?>' data-placement="top"><?= htmlentities(substr(str_replace(['\'\'','\''],'"',$proyecto['titulo']),0,20),ENT_QUOTES) ?> </span></td>
                
               
                <td><?= ($proyecto['proyecto_finalizado']==1)?'<span class="fa fa-fw fa-check-square"></span>':'<span class="fa fa-fw fa-square"></span>' ?></td>
                <td><?= ($proyecto['video_check']==1)?'<span class="fa fa-fw fa-check-square"></span>':'<span class="fa fa-fw fa-square"></span>' ?></td>
                
            </tr>
        <?php endforeach; ?>
        </tbody>
        <?php if (count($proyectos['proyectos'])==0){ ?>
        <tbody>
            <tr><td colspan="6" class="text-center" width="100%">No se encontraron resultados</td></tr>
        </tbody>
        <?php } ?>
    </table>
        <?= LinkPager::widget([
            'pagination' => $proyectos['pages'],
            'lastPageLabel' => true,
            'firstPageLabel' => true
        ]);?>
        
        <div class='clearfix'></div>
            <div class="form-group pull-rigth col-md-4" >
            <?php /*= Html::a('Descargar',['reporte/proyecto-descargar','region'=>$model->region_id],['class'=>' btn btn-default']);*/ ?>
            </div>
        <div class='clearfix'></div>
        
        
    
</div>
<script>
    $('.popover1').webuiPopover();
    function Region(event) {
        event.preventDefault();
        $( "#w0" ).submit();
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
// Handler for .ready() called.

        $("#lnk_reporteprimera").addClass("active");
        $("#lnk_reporteprimera").parent().find("ul").show();
        $("#lnk_reporteproyectos").addClass("active");


    });



</script>