<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;
use app\models\Proyecto;
use app\models\VotacionInterna;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\ProyectoSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">Evaluación de proyectos
</div>
<div class="box_content contenido_seccion_crear_equipo" >
    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin([
            'action' => ['votacioninterna'],
            'method' => 'get',
        ]); ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group label-floating field-votacion_interna_search-region_id required">
                <label class="control-label" for="votacion_interna_search-region_id">Región</label>
                <select id="votacion_interna_search-region_id" class="form-control" name="VotacionInternaSearch[region_id]" >
                    <option value></option>
                    <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
                        <option value="<?= $departamento->department_id ?>" <?= ($searchModel->region_id==$departamento->department_id)?'selected':'' ?>><?= $departamento->department ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-raised btn-default']) ?>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    
    <div class="col-md-12">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label'=>'Proyecto',
                    'format'=>'raw',
                    'value'=>function($data)
                    {
                        return Html::a(htmlentities($data->titulo,ENT_QUOTES),['foro/proyecto-monitor-votacion','id'=>$data->id],['target'=>'blank']);
                    },
                ],
                
                'voto',
                [
                    'label'=>'Valor del 0-40',
                    //'attribute' => 'codigo_modular',
                    'format'=>'raw',
                    'value'=>function($data) {
                        return "<input type='number'  onfocusout='grabado_automatico($(this),".$data->id.",".$data->voto.")' class='form-group' maxlength=3 value='".$data->valor."'>";
                    },
                ],
                [
                    'label'=>'Resultado',
                    //'attribute' => 'codigo_modular',
                    'format'=>'raw',
                    'value'=>function($data) {
                        return "<div id='proyecto_".$data->id."'> ".(double)$data->resultado."</div>";
                    },
                ]
                
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php
    $valoraporcentualadministrador= Yii::$app->getUrlManager()->createUrl('proyecto/valoraporcentualadministrador');
?>
<script type="application/x-javascript">

function grabado_automatico(element,proyecto_id,voto) {
    console.log(voto);
    console.log(<?= $countInterna->maximo ?>);
    console.log(element.val());
    var resultado=((voto/<?= $countInterna->maximo ?>)*(0.7)+(element.val()/40)*(0.3))*100;
    console.log(resultado);
    resultado = resultado.toFixed(2);
    console.log(resultado);

    if (element.val()<0 || element.val()>40) {
        $.notify({
            message: 'Debe estar en el intervalo de 1 a 40' 
        },{
            type: 'danger',
            z_index: 1000000,
            placement: {
                from: 'bottom',
                align: 'right'
            },
        });
        element.val('');
        return false;
    }
    
    $.ajax({
        url: '<?= $valoraporcentualadministrador ?>',
        type: 'GET',
        async: true,
        data: {proyecto_id:proyecto_id,valor:element.val(),resultatotal:resultado},
        success: function(data){
            
            
            $('#proyecto_'+proyecto_id).html(resultado);
            if(data==1)
            {   
                $.notify({
                    // options
                    message: 'Se ha registrado el valor' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                
            }
        }
    });
    
    return true;
}

</script>


<script type="text/javascript">
    $(document).ready(function() {
// Handler for .ready() called.

        $("#lnk_votacioninterna").addClass("active");

    });



</script>