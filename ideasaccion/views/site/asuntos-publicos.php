<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Asunto;
use app\models\Resultados;
use app\models\Ubigeo;
Modal::begin([
    'header' => '<h2>Hello world</h2>',
   // 'toggleButton' => ['label' => 'click me'],
]);


Modal::end();

$resultados=Resultados::find()->all();
?>
<h1>
¿Qué son los asuntos públicos?
</h1>
<p class="text-justify">
Todo tema que resulta de interés general porque compromete nuestros derechos fundamentales y el bienestar
colectivo, relacionado con aspectos  sociales, políticos, económicos, éticos, culturales y medio ambientales.
</p>
<p class="text-justify">
Por ejemplo:
<ul>
    <li>La contaminación ambiental causada por el arrojo de desperdicios en los ríos.</li>
    <li>El alto índice de abandono escolar entre las adolescentes que han sido madres.</li>
</ul>
</p>
<p class="text-justify">
<b>Ejemplo específico</b><br>
Manolo se ha percatado que en algunos locales de entretenimiento de su localidad no permiten el ingreso de
personas con rasgos amazónicos. Además, observa que esto sucede sin que nadie proteste, lo que genera que
algunas se sientan excluidas, prácticamente invisibilizados. A Manolo le queda claro que la discriminación
impide el bienestar colectivo al generar malestar en algunas personas y violar los derechos fundamentales
que les pertenecen a todos, él piensa que sin duda es un asunto público que debe ser discutido y solucionado.
</p>
<p class="text-justify">
<b>REDACCIÓN DE ASUNTOS PÚBLICOS</b>
Hay un listado de 33 asuntos públicos. Cada uno debe tener:
<ul>
    <li>Qué es un asunto público (40 palabras)</li>
    <li>Enunciado de cada asunto público con lenguaje más cercano al estudiante</li>
    <li>2 o 3 ejemplos concretos del asunto público</li>
    <li>Redacción de 60 palabras explicando el asunto público</li>
</ul>
</p>


<h1>
¿Cúales son?
</h1>
<p class="text-justify">
    <b>Asuntos públicos en nuestro día a día</b><br>
    <b>Relacionados a las vivencias de los niños y niñas y adolescentes</b><br>
    En el día a día los niños, las niñas  y los jóvenes nos enfrentamos con diversas situaciones que resultan
    complicadas, incluso para los adultos; sin embargo, nosotros no tenemos miedo a enfrentarlas y estamos
    dispuestos a buscar soluciones.
    <div class="">
        <?php
            $categorias1=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>1])->all();
            foreach($categorias1 as $categoria1)
            {
                echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoria1->id.'"  id="proyecto'.$categoria1->id.'" class="" style="cursor: pointer" ><u>'.$categoria1->descripcion_cabecera.'</u></span> <br>';
            }
        ?>
    </div>
</p>
<div class="clearfix"></div>
<p class="text-justify">
    <b>Relacionados a la cultura escolar</b><br>
    Para nosotros la escuela en verdad es un segundo hogar, y a veces como en todo hogar hay problemas que
    nos mueven el piso, situaciones que nos fastidian; son esos momentos  en los que debemos actuar para
    recuperar la armonía, porque también depende de nosotros que las cosas marchen bien.
    <div class="">
        <?php
            $categorias2=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>2])->all();
            foreach($categorias2 as $categoria2)
            {
                echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoria2->id.'"  id="proyecto'.$categoria2->id.'" class="" style="cursor: pointer" ><u>'.$categoria2->descripcion_cabecera.'</u></span> <br>';
            }
        ?>
    </div>
</p>
<div class="clearfix"></div>
<p class="text-justify">
    <b>Asuntos públicos sobre mi realidad local, regional y nacional</b><br>
    <b>Relacionados a la vida local, regional y nacional</b><br>
    Sabemos que somos una parte importante de nuestra nación, y que los ojos de muchos están puestos en nosotros
    porque nos llaman futuro. Pues, es hora que sepan que también somos presente y valemos también por lo que
    hacemos hoy.
    <div class="">
        <?php
            $categorias3=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>3])->all();
            foreach($categorias3 as $categoria3)
            {
                echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoria3->id.'"  id="proyecto'.$categoria3->id.'" class="" style="cursor: pointer" ><u>'.$categoria3->descripcion_cabecera.'</u></span> <br>';
            }
        ?>
    </div>
</p>
<div class="clearfix"></div>
<?php if(!$resultados){ ?>
<button id="votar" type="button" class="btn btn-small btn-primary" >votar</button>
<br>
<?php } ?>
<br>
<a href="resultados" class="btn btn-small btn-default">Resultados</a>
<br><br>
<?= $this->render('_mobile') ?>



<!-- Modal Votar -->
<?php $form = ActiveForm::begin(); ?>
<div class="modal fade" id="myModalVotar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" >
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="votar2">Votar</button>
            </div>
        </div>
    </div>
</div>


<?php
    $url= Yii::$app->getUrlManager()->createUrl('voto/validardni');
    $urlinsert= Yii::$app->getUrlManager()->createUrl('voto/registrar');
    if(!$resultados){
?>
<script>
    
        $('.numerico').keypress(function (tecla) {
            var reg = /^[0-9\s]+$/;
            if(!reg.test(String.fromCharCode(tecla.which))){
                return false;
            }
            return true;
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
                return true;
	    }
	});
	
        var myNumeracion=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33];
	jQuery.each(myNumeracion , function(index, value){
            console.log(value);
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
                
                <?php
                    $asuntosp=Asunto::find()->all();
                    foreach($asuntosp as $asuntop)
                    {
                ?>
                    var asuntop=<?= $asuntop->id ?>;
                    var asuntonombre="<?= $asuntop->descripcion_cabecera ?>";
                    if (asuntop==value) {
                        $.notify({
                            // options
                            message: 'Se ha agregado el asunto "'+ asuntonombre +'" ' 
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
                    
                <?php
                    }
                ?>
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
                    url: '<?= $url ?>',
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
                    url: '<?= $urlinsert ?>',
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
                return true;
            }
            
	});
        
    
    </script>
   
    
    <?php }
?>
    
<?php ActiveForm::end(); ?>