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
    <img src="../img/icon_team_big.jpg" alt="">Aporta a otros proyectos
</div>
<div class="box_content contenido_seccion_crear_equipo">
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
       <b> Haz clic aquí y encuentra otros proyectos a nivel nacional.</b><br>
       <b style="font-size: 11px">Si quieres ver tu proyecto, haz clic en “mi proyecto”</b>
    </div>
    
<?php Pjax::begin(); ?>
<?php $form = ActiveForm::begin([
        'action' => ['buscar'],
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
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group label-floating field-proyecto-asunto_id required">
            <label class="control-label" for="proyecto-asunto_id" >Asunto público</label>
            <select id="proyecto-asunto_id" class="form-control" name="ProyectoSearch[asunto_id]" onchange="Asunto($(this).val())">
                <option value></option>
                <?= $model->Asuntos($searchModel->asunto_id,$searchModel->region_id)?>
            </select>
        </div>
    </div>
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
        

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url,$model,$key) {
                    return Html::a('<span class="glyphicon glyphicon-edit"></span>',['foro/proyecto?id='.$model->foro_id],[]);
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
        
        $.get( "<?= $asunto ?>?region="+value, function( data ) {
            $( "#proyecto-asunto_id" ).html( data );
        });
        $( "#w1" ).submit();
    }
    
    function Asunto(value) {
        //code
        $( "#w1" ).submit();
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#lnk_aporte").attr("class", "active");
    });



</script>