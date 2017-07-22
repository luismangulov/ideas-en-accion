<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\VotacionPublica;
use app\models\Ubigeo;
use yii\widgets\Pjax;
use yii\web\JsExpression;

Modal::begin([
    'header' => '<h2>Hello world</h2>',
   // 'toggleButton' => ['label' => 'click me'],
]);


Modal::end();

$votacionpublica=VotacionPublica::find()->all();
?>
<h1>
¿Bases?
</h1>
<p class="text-justify">
Todo tema que resulta de interés general porque compromete nuestros derechos fundamentales y el bienestar
colectivo, relacionado con aspectos  sociales, políticos, económicos, éticos, culturales y medio ambientales.
</p>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group field-voto-region required">
            <label class="control-label" for="voto-region">Región: *</label>
            <select id="voto-region" class="form-control" name="Voto[region]" onchange="MostrarResultadosPublicos($(this).val())">
                <option value>Seleccionar</option>
                <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
                    <option value="<?= $departamento->department_id ?>"><?= $departamento->department ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div id="mostrarvotacionpublica" class="col-xs-12 col-sm-12 col-md-12"></div>
</div>


<!-- Modal Votar -->
<?php $form = ActiveForm::begin(); ?>
<div class="modal fade" id="myModalVotacionPublica" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 5000 !important">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Votar</h4>
            </div>
            <div class="modal-body">
		<div class="col-xs-12 col-sm-12 col-md-12">
		    <div class="form-group field-voto-dni required">
			<label class="control-label" for="voto-dni">DNI: *</label>
			<input type="text" id="voto-dni" class="form-control numerico" name="Voto[dni]" placeholder="DNI" maxlength="8" pattern=".{8,8}">
                        <input type="hidden" id="voto-proyecto_id">
                    </div>
		</div>
		<div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="votar2">Votar</button>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
    $mostrarvotacionpublica= Yii::$app->getUrlManager()->createUrl('voto/mostrarvotacionpublica');
    $validardnivotacionpublica= Yii::$app->getUrlManager()->createUrl('voto/validardnivotacionpublica');
    $votacionfinal= Yii::$app->getUrlManager()->createUrl('voto/votacionfinal');
?>
<script>
    var proyecto_id=0;
    function MostrarResultadosPublicos(region) {
        $.ajax({
            url: '<?= $mostrarvotacionpublica ?>',
            dataType: 'html',
            type: 'GET',
            async: true,
            data: {region:region},
            success: function(data){
                $('#mostrarvotacionpublica').html(data);
            }
        });
    }
    function votar(proyecto) {
        $('#myModalVotacionPublica').modal('show');
        $('#voto-proyecto_id').val(proyecto);
        proyecto_id=proyecto;
    }
    
    
    $( '#voto-dni' ).focusout(function() {
        if($(this).val()!='')
        {
            if($(this).val().length<8)
            {
                $.notify({
                            // options
                            message: 'El DNI debe contener 8 caracteres' 
                        },{
                            // settings
                            type: 'danger',
                            z_index: 1000000,
                            placement: {
                                    from: 'bottom',
                                    align: 'right'
                            },
                        });
                $('.field-voto-dni').addClass('has-error');
                $('#voto-dni').val('');
                return false;
            }
            
            $.ajax({
                url: '<?= $validardnivotacionpublica ?>',
                //dataType: 'json',
                type: 'GET',
                async: true,
                data: {dni:$(this).val()},
                success: function(data){
                    if(data==1)
                    {
                        $('.field-voto-dni').addClass('has-error');
                        $.notify({
                            // options
                            message: 'El DNI ya existe' 
                        },{
                            // settings
                            type: 'danger',
                            z_index: 1000000,
                            placement: {
                                    from: 'bottom',
                                    align: 'right'
                            },
                        });
                        $('#voto-dni').val('');
                    }
                }
            });
            return true;
            
        }
        return false;
    });
    
    
    $( '#votar2' ).click(function() {
            var error='';
	    if($('#voto-dni').val()=='')
            {
                error='Ingrese DNI <br>';
		$('.field-voto-dni').addClass('has-error');
            }
	    else
	    {
		$('.field-voto-dni').addClass('has-success');
		$('.field-voto-dni').removeClass('has-error');
	    }
	    
	    
            if(error!='')
            {
		$.notify({
		    message: error 
		},{
		    type: 'danger',
		    z_index: 1000000,
		    placement: {
			from: 'bottom',
			align: 'right'
		    },
		});
                return false;
            }
            else
            {
                $.ajax({
                    url: '<?= $votacionfinal ?>',
                    type: 'GET',
                    async: true,
                    data: {'dni':$('#voto-dni').val(),'proyecto':$('#voto-proyecto_id').val()},
                    success: function(data){
                    
                        if(data==1)
                        {
                            $.notify({
                                // options
                                message: 'Gracias por registrar su voto' 
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
                            }, 1000);
                        }
                    }
                });
                return true;
            }
            
	});
    
</script>

