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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">Votación regional
</div>
<div class="box_content contenido_seccion_crear_equipo" >
    <?php if (!$votacionesinternasfinalizadasCount || $votacion_publica){?>
    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin([
            'action' => ['votacion'],
            'method' => 'get',
        ]); ?>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group label-floating field-proyecto-region_id required">
                <label class="control-label" for="proyecto-region_id">Región</label>
                <select id="proyecto-region_id" class="form-control" name="ProyectoSearch[region_id]" >
                    <option value></option>
                    <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
                        <option value="<?= $departamento->department_id ?>" <?= ($searchModel->region_id==$departamento->department_id)?'selected':'' ?>><?= $departamento->department ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group label-floating field-proyecto-titulo required">
                <label class="control-label" for="proyecto-titulo">Proyecto</label>
                <input type="text" name="ProyectoSearch[titulo]" class="form-control" value="<?= $searchModel->titulo?>">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-raised btn-default pull-right']) ?>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'titulo',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{like}',
                    'buttons' => [
                        'view' => function ($url,$model,$key) {
                            return Html::a('<span class="glyphicon glyphicon-edit" ></span>',['foro/view?id='.$model->foro_id],[]);
                        },//style="color:green"
                        'like' => function ($url,$model,$key) {
                            $votacioninterna=VotacionInterna::find()
                                ->where('proyecto_id=:proyecto_id and user_id=:user_id',
                                        [':proyecto_id'=>$model->id,':user_id'=>\Yii::$app->user->id])
                                ->one();
                            if($votacioninterna)
                            {
                                return Html::a('<span class="glyphicon glyphicon-thumbs-up" style="color:green"></span>',['votacion#'],['onclick'=>'Seleccionar2('.$model->id.',event)']);
                            }
                            else
                            {
                                return Html::a('<span class="glyphicon glyphicon-thumbs-up" ></span>',['votacion#'],['onclick'=>'Seleccionar2('.$model->id.',event)']);
                            }
                        }
                    ],
                ]
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
    <?php } ?>
    <div class="col-md-6">
        <table class="table">
            <th>Proyecto</th>
            <th>Equipo</th>
            <?php foreach($votacionesinternas as $votacioninterna){ ?>
            <tr>
                <td><?= htmlentities($votacioninterna->proyecto->titulo,ENT_QUOTES) ?></td>
                <td><?= htmlentities($votacioninterna->proyecto->equipo->descripcion_equipo,ENT_QUOTES) ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php if (!$votacionesinternasfinalizadasCount){?>
        <button type="button" id="btnfinalizarvotacion" class="btn btn-raised btn-default pull-right">Finalizar votación</button>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
</div>
<?php
    $votacion= Yii::$app->getUrlManager()->createUrl('proyecto/votacioninterna');
    $finalizarvotacion= Yii::$app->getUrlManager()->createUrl('proyecto/finalizarvotacioninterna');
?>
<script>
var countvotacion=<?= $votacionesinternasCount ?>;
    
function Seleccionar2(id,event) {
    event.preventDefault();
    $.ajax({
        url: '<?= $votacion ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            
            if (data==1) {
                $.notify({
                    // options
                    message: 'Tu voto ha sido registrado' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                setTimeout(function(){
                        window.location.reload(1);
                    }, 2000);
            }
            else if (data==2) {
                $.notify({
                    // options
                    message: 'Tu voto se ha deseleccionado' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                
                setTimeout(function(){
                        window.location.reload(1);
                    }, 2000);
            }
            else if (data==3) {
                $.notify({
                    // options
                    message: 'Solo puedes votar por 3 proyectos' 
                },{
                    // settings
                    type: 'danger',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                }); 
            }
        }
    });
}

$('#btnfinalizarvotacion').click(function(event){
    if (countvotacion<3) {
        $.notify({
            // options
            message: 'Debes votar por 3 proyectos' 
        },{
            // settings
            type: 'danger',
            z_index: 1000000,
            placement: {
                    from: 'bottom',
                    align: 'right'
            },
        });
        return false;
    }
    
    
    $.ajax({
        url: '<?= $finalizarvotacion ?>',
        type: 'GET',
        async: true,
        success: function(data){
            if (data==1) {
                $.notify({
                    // options
                    message: 'Ha finalizado el proceso de votación interna' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                setTimeout(function(){
                        window.location.reload(1);
                    }, 2000);
            }
        }
    });
    return true;
    
});

</script>