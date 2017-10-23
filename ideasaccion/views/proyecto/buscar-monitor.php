<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;
use app\models\Proyecto;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\ProyectoSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">Reporte de  aportes de proyectos
</div>
<div class="box_content contenido_seccion_crear_equipo">
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
       <b> Busca los proyectos a nivel nacional para conocerlos y dar tus aportes.</b>
    </div>
    
<?php Pjax::begin(); ?>
<?php $form = ActiveForm::begin([
        'action' => ['buscar-monitor'],
        'method' => 'get',
    ]); ?>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group label-floating field-proyecto-region_id required">
            <label class="control-label" for="proyecto-region_id">Región</label>
            <select id="proyecto-region_id" class="form-control" name="ProyectoSearch[region_id]" onchange="Region($(this).val())">
                <option value></option>
                <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
                    <option value="<?= $departamento->department_id ?>" <?= ($searchModel->region_id==$departamento->department_id)?'selected':'' ?> ><?= $departamento->department ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php /*<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group label-floating field-proyecto-asunto_id required">
            <label class="control-label" for="proyecto-asunto_id" >Asunto público</label>
            <select id="proyecto-asunto_id" class="form-control" name="ProyectoSearch[asunto_id]" onchange="Asunto($(this).val())">
                <option value></option>
                <?= $model->Asuntos($searchModel->asunto_id,$searchModel->region_id)?>
            </select>
        </div>
    </div> */ ?>
    <div class="clearfix"></div>
    <!--<div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group label-floating field-proyecto-titulo required">
            <label class="control-label" for="proyecto-titulo">Proyecto</label>
            <input type="text" name="ProyectoSearch[titulo]" class="form-control" value="<?= $searchModel->titulo?>">
        </div>
    </div>-->
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <?php //= Html::submitButton('Buscar', ['class' => 'btn btn-raised btn-default pull-right']) ?>
        </div>
    </div>
    <div class="clearfix"></div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<div class="col-xs-12 col-sm-12 col-md-12">

<?php Pjax::begin(); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'titulo',
        'total_monitor',
        'total_estudiante',
        'total_monitor_respuesta',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url,$model,$key) {
                    return Html::a('<span class="glyphicon glyphicon-edit"></span>',['foro/proyecto-monitor?id='.$model->foro_id],[]);
                }
            ],
        ]
    ],
]); ?>
</div>

<?php Pjax::end(); ?>
</div>
<div class="clearfix"></div>
<?php 
    $asunto= Yii::$app->getUrlManager()->createUrl('proyecto/asunto');
?>
<script>
    function Region(value) {
        $( "#w1" ).submit();
       /* $.get( "<?= $asunto ?>?region="+value, function( data ) {
            $( "#proyecto-asunto_id" ).html( data );
        });*/
        //$( "#w1" ).submit();
    }
    
    function Asunto(value) {
        //code
        
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
// Handler for .ready() called.

        $("#lnk_reportesegunda").addClass("active");
        $("#lnk_reportesegunda").parent().find("ul").show();
        $("#lnk_reportesegunda_aporte").addClass("active");


    });



</script>