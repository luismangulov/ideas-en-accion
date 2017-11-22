<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;
use app\models\Asunto;
use yii\helpers\ArrayHelper;
use app\models\Resultados;
Modal::begin([
    'header' => '<h2>Hello world</h2>',
   // 'toggleButton' => ['label' => 'click me'],
]);


Modal::end();
$variable="prueba";
$resultados=Resultados::find()->all();
?>
    <div id="fullpage">
	<div class="section" id="section0">
	    <div class="slide" id="slide0">
		<?php if($resultados){ ?>
                <div style="float: right">
                    <ul class="nav navbar-nav" >
                        <li class="dropdown ingresar">
                            <a href="#" class="dropdown-toggle btn btn-small btn-default" data-toggle="dropdown">Ingresar</a>
                            <ul class="dropdown-menu" style="padding: 15px;min-width: 250px;left:-165px !important;" >
                            <li>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= \app\widgets\login\LoginWidget::widget(['tipo'=>2]); ?>
                                    </div>
                                </div>
                            </li>
                           
                         </ul>
                      </li>
                   </ul>
                </div>
		<?php }?>
                <div class="intro">
                    
                    <h1>Presentación 1</h1>
                    <p>
                        1
                    </p>
                </div>
	    </div>
	    <div class="slide" id="slide1">
		<h1>Presentación 2</h1>
                <p>
                    2
                </p>
	    </div>
            <div class="slide" id="slide2">
		<h1>Presentación 3</h1>
                <p>
                    3
                </p>
	    </div>
            <div class="slide" id="slide3">
		<h1>Presentación 4</h1>
                <p>
                    4
                </p>
	    </div>
	</div>
        <div class="section " id="section1" style="padding-left:30px;padding-right:20px">
            <?= $this->render('_section1') ?>
        </div>
	<div class="section" id="section2" style="padding-left:30px;padding-right:20px">
            <?= $this->render('_section2') ?>
        </div>
        <div class="section" id="section3" style="padding-left:30px;padding-right:20px">
            <div class="slide" id="slide4">
                <div class="intro">
                    
                    <?= $this->render('_section3') ?>
                </div>
	    </div>
            <div class="slide" id="slide5">
                <div class="intro">
                    <?= $this->render('_resultados') ?>
                </div>
	    </div>
            
        </div>
    </div>
    

<?php
    $asuntos=Asunto::find()->all();
    foreach($asuntos as $asunto)
    {
?>

<div class="modal fade" id="myModalCompleto<?= $asunto->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= htmlentities($asunto->descripcion_cabecera,ENT_QUOTES) ?></h4>
            </div>
            <div class="modal-body">
                <?= htmlentities($asunto->descripcion_larga, ENT_QUOTES) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="proyectoxs1c">Save changes</button>
            </div>
        </div>
    </div>
</div>

<?php } ?>

    
<!-- Modal Votar -->
<?php $form = ActiveForm::begin(); ?>
<div class="modal fade" id="myModalVotar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
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
		    </div>
		</div>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12">
		    <div class="form-group field-voto-region required">
			<label class="control-label" for="voto-region">Región: *</label>
			<select id="voto-region" class="form-control" name="Voto[region]" >
			    <option value>Seleccionar</option>
			    <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
				<option value="<?= $departamento->department_id ?>"><?= $departamento->department ?></option>
			    <?php } ?>
			</select>
		    </div>
		</div>
		<div class="clearfix"></div>
		
                <?php //= Html::label('DNI', 'Voto[dni]', ['class' => '']) ?>
                <?php //= Html::input('text', 'Voto[dni]', '', ['id'=>'voto-dni','class' => 'form-control numerico','maxlength'=>8,'pattern'=>'.{8,8}']) ?>
                
                <?php //= Html::label('Región', 'Voto[region]', ['class' => '']) ?>
                <?php //= Html::dropDownList('Voto[region]', '', ArrayHelper::map(Ubigeo::find()->select('department_id,department')->groupBy('department')->all(), 'department_id', 'department'),['id'=>'voto-region','class' => 'form-control','prompt'=>'seleccionar']) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="votar2">Votar</button>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<!-- Modal Asuntos mobil solo para celulares -->
<?= $this->render('_mobile') ?>



<?php
    $url= Yii::$app->getUrlManager()->createUrl('voto/validardni');
    $urlinsert= Yii::$app->getUrlManager()->createUrl('voto/registrar');
    if(!$resultados){
    $this->registerJs(
    "$('document').ready(function(){
    
        $('.numerico').keypress(function (tecla) {
            var reg = /^[0-9\s]+$/;
            if(!reg.test(String.fromCharCode(tecla.which))){
                return false;
            }
        });
        
        var myArray = [];
	
	$( '#votar' ).click(function() {
	   
	    if(myArray.length<3)
	    {
		$.notify({
		    // options
		    
		    message: 'Debe seleccionar 3 proyectos' 
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
	    else
	    {
		$('#myModalVotar').modal('show');
	    }
	});
	
        var myNumeracion=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33];
	jQuery.each(myNumeracion , function(index, value){
            
	    $( '#proyecto'+value+'c' ).click(function() { myfunction(value,'proyecto'+value); });
        });
        
	
	function myfunction(value,identificador){
	
	    var notificacion;
            
            notificacion=jQuery.inArray( value, myArray );
            if(notificacion!=-1)
            {
                $(elemntIndentificar).each(function(indice, elemento) {
                    $( '#proyecto'+value ).css( 'color', 'white' );
                    $( '#proyecto'+value ).css( 'background-color', '#777' );
                });
                myArray.splice(notificacion, 1);
                $.notify({
                        // options
                        message: 'Ha retirado el asunto  '+ value +'' 
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
            
	    if(myArray.length>2)
	    {
		$.notify({
                    // options
                    message: 'Solo se puede votar por 3 proyectos' 
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
	    else
	    {
		elemntIndentificar=['lg','md','sm','xs'];
		$(elemntIndentificar).each(function(indice, elemento) {
		    $( '#proyecto'+value ).css( 'color', 'white' );
		    $( '#proyecto'+value ).css( 'background-color', 'green' );
		});
		
		
                myArray.push(value);
                $.notify({
                        // options
                        message: 'Se ha agregado el proyecto '+ value +' ' 
                },{
                        // settings
                        type: 'success',
                        z_index: 1000000,
                        placement: {
                                from: 'bottom',
                                align: 'right'
                        },
                });
                return true;
		
	    }
	    
	}
        
        /**/
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
                    url: '$url',
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
			    
                            return false;
                        }
                    }
                });
                
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
	    
            if($('#voto-region').val()=='')
            {
                error=error+'Ingrese Región <br>';
		$('.field-voto-region').addClass('has-error');
            }
	    else
	    {
		$('.field-voto-region').addClass('has-success');
		$('.field-voto-region').removeClass('has-error');
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
		$('.field-voto-dni').addClass('has-success');
		$('.field-voto-dni').removeClass('has-error');
		$('.field-voto-region').addClass('has-success');
		$('.field-voto-region').removeClass('has-error');
                $.ajax({
                    url: '$urlinsert',
                    type: 'GET',
                    async: true,
                    data: {'Voto[dni]':$('#voto-dni').val(),'Voto[region]':$('#voto-region').val(),Asuntos: myArray},
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
                        else
                        {
                            $.notify({
                                // options
                                message: 'Hubo un problema en el registro' 
                            },{
                                // settings
                                type: 'danger',
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
            }
            
            
	});
        
    });"
    );
    }
?>
    
    