<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use yii\widgets\Pjax;
use yii\web\JsExpression;

/* @var $this \yii\web\View */
/* @var $user \common\models\LoginForm */
/* @var $title string */
$opciones_objetivos='';
foreach($objetivos as $objetivo){ 
    $opciones_objetivos=$opciones_objetivos.'<option value='.$objetivo->id.'>'.htmlentities($objetivo->descripcion,ENT_QUOTES).'</option>';
}




?>
<script nonce="<?= getnonceideas() ?>" src="<?= \Yii::$app->request->BaseUrl ?>/autoNumeric-master/autoNumeric.js"></script>
<script nonce="<?= getnonceideas() ?>" src="<?= \Yii::$app->request->BaseUrl ?>/jQuery-Plugins-master/numeric/jquery.numeric.js"></script>
<style>.image-upload > input
{
    display: none;
}

.image-upload img
{
    width: 80px;
    cursor: pointer;
}
label{
    display:inline-block !important ;
    max-width:100% !important;
    margin-bottom:5px !important;
    font-size:14px !important;
    font-weight:700 !important;
    color:#1f2a69 !important;
}
.form-control
{
    color:#59595b !important;
    font-size:14px !important;
}

    ul #oespe{
        content: "";
        list-style: none; 
    }
    ul #act{
        content: "";
        list-style: none; 
    }
    /*
    li {
        
    }*/
    #oespe::before
    {
        padding-right: 5px;
        content: "\25BA";
    }
    #act::before
    {
        padding-right: 5px;
        content: "\25CF";
    }
    
    #act
    {
        padding-top:10px;
        padding-bottom:10px;
    }
</style>


    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group label-floating field-proyecto-titulo required">
        <label class="control-label" for="proyecto-titulo"><span style="line-height: 20px; font-weight: normal !important;">Si la actividad genera algún costo, piensen en cómo podrían organizarse para obtener sus recursos; por otro lado, si van a PEDIR o CREAR el recurso, no es necesario que incluyas PRECIO UNITARIO ni TOTAL</span></label>

    </div><BR>
	<div class="form-group  field-proyecto-plan_presupuestal_objetivo_99 required" style="margin: 0px;padding: 0px">
	    <ul>
	    <label class="control-label" for="proyecto-plan_presupuestal_objetivo_99"><li id='oespe'><b>Objetivo Específico</b></li></label>
	    <select id="proyecto-plan_presupuestal_objetivo_99" class="form-control" name="Proyecto[planes_presupuestales_objetivos][]" onchange="actividad($(this).val(),99)" >
		<option value>Seleccionar</option>
		<?= $opciones_objetivos ?>
	    </select>
	    </ul>
	</div>
    </div>
    
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
	<div class="form-group field-proyecto-plan_presupuestal_actividad_99 required" style="margin: 0px;padding: 0px">
	    <ul>
	    <label class="control-label" for="registrar-plan_presupuestal_actividad_99"><li id='oespe'><b>Actividad</b></li></label>
	    <select id="proyecto-plan_presupuestal_actividad_99" class="form-control" name="Proyecto[planes_presupuestales_actividades]" onchange="presupuesto($(this).val())" >
		<option value>Seleccionar</option>
	    </select>
	    </ul>
	</div>
    </div>
    <div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12">
	    <table class="table table-hover" id="presupuesto" style="display: none">
		<thead>
		    <th>Recursos</th>
		    <th>¿Cómo conseguirlo?</th>
		    <th>¿A quién podemos pedirselo?</th>
		    <th>Precio unitario</th>
		    <th>Cantidad</th>
		    <th>Total</th>
		</thead>
		<tbody id="presupuesto_cuerpo">
		    
		</tbody>
		<tr>
		    <td>Total</td>
		    <td colspan="4" ></td>
		    <td><div  class="total"></div></td>
		    <!--<input type="hidden"  id="total">-->
		</tr>
	    </table>
	    <?php if($disabled==''){?>
		<div id="btn_presupuesto" class="btn btn-default pull-right" onclick="InsertarPlanPresupuestal()" style="display: none">Agregar</div>
	    <?php } ?>
	</div>
    <div class="clearfix"></div>

<?php
    $eliminarplanpresupuestal= Yii::$app->getUrlManager()->createUrl('actividad/eliminarplanpresupuestal');
    $cargatablapresupuesto= Yii::$app->getUrlManager()->createUrl('plan-presupuestal/cargatablapresupuesto2');
?>
<script>
    
    
    var opciones_objetivos="<?= $opciones_objetivos ?>";
    function actividad(value,contador) {
	$.get( '<?= Yii::$app->urlManager->createUrl('plan-presupuestal/actividades2?id=') ?>'+value, function( data ) {
	    $( '#proyecto-plan_presupuestal_actividad_'+contador ).html( data );
	});
    }
    
    $("#presupuesto").on('click',' .remCF',function(){
	
	
        var r = confirm("¿Estás seguro?");
        if (r == true) {
            id=$(this).children().val();
	
	    if (id) {
		$.ajax({
		    url: '<?= $eliminarplanpresupuestal ?>',
		    type: 'GET',
		    async: true,
		    data: {id:id},
		    success: function(data){
			
		    }
		});
		$(this).parent().parent().remove();	
	    }
	    else
	    {
		$(this).parent().parent().remove();
	    }
            
        } 
    });
    $('.numerico').keypress(function (tecla) {
	var reg = /^[0-9\s]+$/;
	if(!reg.test(String.fromCharCode(tecla.which))){
	    return false;
	}
	return true;
    });		
    $('.texto').keypress(function(tecla) {
	var reg = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ'_\s]+$/;
	if(!reg.test(String.fromCharCode(tecla.which))){
	    return false;
	}
	return true;
    });
    
    function Numerico(evt)
    {
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]|\./;
	if( !regex.test(key) ) {
	  theEvent.returnValue = false;
	  if(theEvent.preventDefault) theEvent.preventDefault();
	}
    }
    
    
    var x=0;
    var y=0;
    
    
    function Subtotal11(id,tipo) {
	$('#proyecto-plan_presupuestal_precio_unitario1_'+id).val("");
	$('#proyecto-plan_presupuestal_precio_unitario1_'+id).val("S/."+$('#proyecto-plan_presupuestal_precio_unitario1_'+id).val());
	
    }
    
    function Subtotal1(id,tipo) {
	
	var unitario1 = $('#proyecto-plan_presupuestal_precio_unitario1_'+id).val();

	if (tipo==1) {
	    x=unitario1.replace("S/.", "");
	}
	if ($('#proyecto-plan_presupuestal_cantidad_'+id).val()!='') {
	    y=$('#proyecto-plan_presupuestal_cantidad_'+id).val();
	}
	
	var subtotal=x*y;
	$('#proyecto-plan_presupuestal_subtotal_'+id).val(subtotal);
	$('#proyecto-plan_presupuestal_subtotal1_'+id).val("S/."+subtotal.toFixed(2));
	$('#proyecto-plan_presupuestal_precio_unitario_'+id).val($('#proyecto-plan_presupuestal_precio_unitario1_'+id).val());
	var total=0;
	$('#presupuesto .totales').each(function(){
		//console.log($(this).val());
		total=total+parseInt($(this).val());
	});
	$('#proyecto-plan_presupuestal_precio_unitario1_'+id).val("S/."+parseInt(x).toFixed(2));
	$('.total').html("S/."+total.toFixed(2));
    }
    
    function Subtotal2(id,tipo) {
	var unitario1 = $('#proyecto-plan_presupuestal_precio_unitario1_'+id).val();
	
	if (tipo==2) {
	    y=$('#proyecto-plan_presupuestal_cantidad_'+id).val();
	}
	
	if (unitario1.replace("S/.", "")!='') {
	    x=unitario1.replace("S/.", "");
	}
	var subtotal=x*y;
	$('#proyecto-plan_presupuestal_subtotal_'+id).val(subtotal);
	$('#proyecto-plan_presupuestal_subtotal1_'+id).val("S/."+subtotal.toFixed(2));
	
	var total=0;
	$('#presupuesto .totales').each(function(){
		//console.log($(this).val());
		total=total+parseInt($(this).val());
	});
	
	$('.total').html("S/."+total.toFixed(2));
    }
    
    function ComoConseguirlo(value,id) {
	var total=0;
	if (value==1 || value==2)
	{
	    $('#proyecto-plan_presupuestal_precio_unitario1_'+id).val("S/."+total.toFixed(2));
	    $('#proyecto-plan_presupuestal_precio_unitario1_'+id).prop( "disabled", true );
	    $('#proyecto-plan_presupuestal_precio_unitario_'+id).val(total.toFixed(2));
	    
	    $('#proyecto-plan_presupuestal_subtotal_'+id).val(total.toFixed(2));
	    $('#proyecto-plan_presupuestal_subtotal1_'+id).val("S/."+total.toFixed(2));
	    
	    
	    
	    
	}
	else
	{
	    $('#proyecto-plan_presupuestal_precio_unitario1_'+id).prop( "disabled", false );
	}
	
	
	$('#presupuesto .totales').each(function(){
		//console.log($(this).val());
		total+=parseInt($(this).val());
		//console.log(total);
	});
	//console.log(total);
	$('.total').html("S/."+total.toFixed(2));
    }
    
    
    function presupuesto(valor) {
        
	$('#presupuesto').hide();
	$.ajax({
	    url: '<?= $cargatablapresupuesto ?>',
	    type: 'GET',
	    async: true,
	    dataType: 'json',
	    data: {valor:valor},
	    success: function(data){
		var tebody="";
		var i=data[0];
		var total=0;
		
		if (data) {
		    data.splice(0,1);
		    $.each(data, function(i,star) {
			total=total+star.subtotal;
			//$('#total').val(total);
			
			var select1="";
			var select2="";
			var select3="";
			$("#proyecto-plan_presupuestal_como_conseguirlo_"+i+" selected").val(star.como_conseguirlo);
			if (star.como_conseguirlo=='1') {
			    select1="selected";
			}
			if (star.como_conseguirlo=='2') {
			    select2="selected";
			}
			if (star.como_conseguirlo=='3') {
			    select3="selected";
			}
			tebody=tebody+"<tr id='plan_presupuestal_"+i+"'>"+
					"<td style='padding: 2px'>"+
					    
					    "<div class='form-group field-proyecto-plan_presupuestal_recurso_descripcion_"+i+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_recurso_descripcion_"+i+"' class='form-control' name='Proyecto[planes_presupuestales_recursos_descripciones][]' placeholder='Recurso' value='"+xescape(star.recurso_descripcion)+"' <?= $disabled?> />"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_como_conseguirlo_"+i+"' required' style='margin-top: 0px'>"+
						"<select onchange='ComoConseguirlo($(this).val(),"+i+")' id='proyecto-plan_presupuestal_como_conseguirlo_"+i+"' class='form-control' name='Proyecto[planes_presupuestales_comos_conseguirlos][]' <?= $disabled?>>"+
						    "<option value>seleccionar</option>"+
						    "<option value='1' "+select1+">Pedir</option>"+
						    "<option value='2' "+select2+">Crear</option>"+
						    "<option value='3' "+select3+">Comprar</option>"+
						"</select>"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_dirigido_"+i+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_dirigido_"+i+"' class='form-control' name='Proyecto[planes_presupuestales_dirigidos][]' placeholder='Dirigido' value='"+xescape(star.dirigido)+"'  <?= $disabled?>/>"+
					    "</div>"+
					"</td>"+
					
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_precio_unitario_"+i+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_precio_unitario1_"+i+"' onfocusout='Subtotal1("+i+",1)' class='form-control' name='Proyecto[planes_presupuestales_precios_unitarios1][]' placeholder='Precio unitario' value='S/."+star.precio_unitario.toFixed(2)+"' <?= $disabled?>>"+
						"<input type='hidden' id='proyecto-plan_presupuestal_precio_unitario_"+i+"'  class='form-control numerico' name='Proyecto[planes_presupuestales_precios_unitarios][]' value='"+star.precio_unitario+"' />"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_cantidad_"+i+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_cantidad_"+i+"' onfocusout='Subtotal2("+i+",2)' class='form-control' name='Proyecto[planes_presupuestales_cantidades][]' placeholder='Cantidad' value='"+star.cantidad+"' <?= $disabled?> >"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_subtotal_"+i+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_subtotal1_"+i+"' class='form-control ' name='Proyecto[planes_presupuestales_subtotales1][]' placeholder='Subtotal' value='S/."+star.subtotal.toFixed(2)+"' disabled>"+
						"<input type='hidden' id='proyecto-plan_presupuestal_subtotal_"+i+"' class='form-control totales' name='Proyecto[planes_presupuestales_subtotales][]' placeholder='Subtotal' value='"+star.subtotal+"'  >"+
					    "</div>"+
					"</td>"+
					<?php if($disabled==''){?>
					"<td style='padding: 2px'>"+
					    "<span class='remCF glyphicon glyphicon-minus-sign'>"+
						"<input class='id' type='hidden' name='Proyecto[planes_presupuestal_ids][]' value='"+star.id+"' />"+
						
					    "</span>"+
					"</td>"+
					<?php } ?>
				    "</tr>";			   
		    });
		    tebody=tebody+"<tr id='plan_presupuestal_"+i+"'><input type='hidden' id='contador' value='"+i+"' ></tr>"
		}
		//$("#diskamountUnit").val('$' + total.toFixed(2));
		$('.total').html("S/."+total.toFixed(2));
		$('#presupuesto_cuerpo').html(tebody);
		$('#presupuesto').show();
		$('#btn_presupuesto').show();
		
	    }
	});
    }
</script>
