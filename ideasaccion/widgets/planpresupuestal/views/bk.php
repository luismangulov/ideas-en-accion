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
    $opciones_objetivos=$opciones_objetivos.'<option value='.$objetivo->id.'>'.$objetivo->descripcion.'</option>';
}
?>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
	<table class="table table-striped table-hover" id="tab_plan_presupuestal">
	    <thead>
		<th>Objetivo especifico</th>
		<th>Actividad</th>
		<th>Recursos</th>
		<th>øComo conseguirlo?</th>
		<th colspan="3" class="text-center">Presupuesto</th>
		<?= ($disabled=='')?'<th></th>':'' ?>
	    </thead>
	    <tbody>
		
		<?php if($planespresupuestales){?>
		    <?php $plan=0; ?>
		    <?php foreach($planespresupuestales as $planpresupuestal){?>
			<tr id='plan_presupuestal_<?= $plan ?>'>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_objetivo_<?= $plan ?> required" style="margin-top: 0px">
				    <select id="proyecto-plan_presupuestal_objetivo_<?= $plan ?>" class="form-control" name="Proyecto[planes_presupuestales_objetivos][]" onchange="actividad($(this).val(),<?= $plan ?>)" <?= $disabled ?>>
					<option value>seleccionar</option>
					<?php foreach($objetivos as $objetivo){  ?>
					    <option value='<?= $objetivo->id ?>' <?= ($objetivo->id==$planpresupuestal->objetivo_especifico_id)?'selected':'' ?>><?= $objetivo->descripcion ?></option>
					<?php }  ?>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_actividad_<?= $plan ?> required" style="margin-top: 0px">
				    <select id="proyecto-plan_presupuestal_actividad_<?= $plan ?>" class="form-control" name="Proyecto[planes_presupuestales_actividades][]" <?= $disabled ?>>
					<option value>seleccionar</option>
					<?php foreach($actividades as $actividad){  ?>
					    <option value='<?= $actividad->id ?>' <?= ($actividad->id==$planpresupuestal->actividad_id)?'selected':'' ?> ><?= $actividad->descripcion ?> </option>
					<?php } ?>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_recurso_<?= $plan ?> required" style="margin-top: 0px">
				    <select id="proyecto-plan_presupuestal_recurso_<?= $plan ?>" class="form-control" name="Proyecto[planes_presupuestales_recursos][]" <?= $disabled ?>>
					<option value>seleccionar</option>
					<option value=1 <?= ($planpresupuestal->recurso == 1) ? 'selected' : ''; ?> >Material</option>
					<option value=2 <?= ($planpresupuestal->recurso == 2) ? 'selected' : ''; ?>>Humano</option>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_como_conseguirlo_<?= $plan ?> required" style="margin-top: 0px">
				    <select onchange="ComoConseguirlo($(this).val(),<?= $plan ?>)" id="proyecto-plan_presupuestal_como_conseguirlo_<?= $plan ?>" class="form-control" name="Proyecto[planes_presupuestales_comos_conseguirlos][]" <?= $disabled ?>>
					<option value>seleccionar</option>
					<option value=1 <?= ($planpresupuestal->como_conseguirlo == 1) ? 'selected' : ''; ?>>Pedir</option>
					<option value=2 <?= ($planpresupuestal->como_conseguirlo == 2) ? 'selected' : ''; ?>>Crear</option>
					<option value=3 <?= ($planpresupuestal->como_conseguirlo == 3) ? 'selected' : ''; ?>>Comprar</option>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_precio_unitario_<?= $plan ?> required" style="margin-top: 0px">
				    <input id="proyecto-plan_presupuestal_precio_unitario_<?= $plan ?>" onfocusout="Subtotal1(<?= $plan ?>,1)" class="form-control numerico" name="Proyecto[planes_presupuestales_precios_unitarios][]" placeholder="Precio unitario" value="<?= ($planpresupuestal->precio_unitario==0)?'':$planpresupuestal->precio_unitario ?>" <?= ($planpresupuestal->como_conseguirlo == 1 || $planpresupuestal->como_conseguirlo == 2) ? 'disabled' : ''; ?>  <?= $disabled ?>/>
				    <?php  if($planpresupuestal->como_conseguirlo == 1 || $planpresupuestal->como_conseguirlo == 2) {?>
					<input type="hidden"  class="form-control numerico" name="Proyecto[planes_presupuestales_precios_unitarios][]" placeholder="Precio unitario" value="0"   />
				    <?php } ?>																																																																					    
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_cantidad_<?= $plan ?> required" style="margin-top: 0px">
				    <input id="proyecto-plan_presupuestal_cantidad_<?= $plan ?>" onfocusout="Subtotal2(<?= $plan ?>,2)" class="form-control numerico" name="Proyecto[planes_presupuestales_cantidades][]" placeholder="Cantidad" value="<?= $planpresupuestal->cantidad ?>" <?= $disabled ?>/>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_subtotal_<?= $plan ?> required" style="margin-top: 0px">
				    <input id="proyecto-plan_presupuestal_subtotal1_<?= $plan ?>" class="form-control numerico" name="Proyecto[planes_presupuestales_subtotales1][]" placeholder="Subtotal" value="<?= $planpresupuestal->subtotal ?>" disabled />
				    <input type="hidden" id="proyecto-plan_presupuestal_subtotal_<?= $plan ?>" class="form-control numerico" name="Proyecto[planes_presupuestales_subtotales][]" placeholder="Subtotal" value="<?= $planpresupuestal->subtotal ?>" />
				</div>
			    </td>
			    <?php if($disabled==''){?>
			    <td style="padding: 2px">
				<span class="remCF glyphicon glyphicon-minus-sign">
				    <input class="id" type="hidden" name="Proyecto[planes_presupuestal_ids][]" value="<?= $planpresupuestal->id ?>" />
				</span>
			    </td>
			    <?php } ?>
			</tr>
			<?php $plan++; ?>
		    <?php } ?>
		<?php } else {?>
			<tr id='plan_presupuestal_0'>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_objetivo_0 required" style="margin-top: 0px">
				    <select id="proyecto-plan_presupuestal_objetivo_0" class="form-control" name="Proyecto[planes_presupuestales_objetivos][]" onchange="actividad($(this).val(),0)" <?= $disabled ?>>
					<option value>seleccionar</option>
					<?= $opciones_objetivos ?>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_actividad_0 required" style="margin-top: 0px">
				    <select id="proyecto-plan_presupuestal_actividad_0" class="form-control" name="Proyecto[planes_presupuestales_actividades][]" <?= $disabled ?>>
					<option value>seleccionar</option>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_recurso_0 required" style="margin-top: 0px">
				    <select id="proyecto-plan_presupuestal_recurso_0" class="form-control" name="Proyecto[planes_presupuestales_recursos][]" <?= $disabled ?>>
					<option value>seleccionar</option>
					<option value=1>Material</option>
					<option value=2>Humano</option>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_como_conseguirlo_0 required" style="margin-top: 0px">
				    <select onchange="ComoConseguirlo($(this).val(),0)" id="proyecto-plan_presupuestal_como_conseguirlo_0" class="form-control" name="Proyecto[planes_presupuestales_comos_conseguirlos][]" <?= $disabled ?>>
					<option value>seleccionar</option>
					<option value=1>Pedir</option>
					<option value=2>Crear</option>
					<option value=3>Comprar</option>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_precio_unitario_0 required" style="margin-top: 0px">
				    <input id="proyecto-plan_presupuestal_precio_unitario_0" onfocusout="Subtotal1(0,1)" class="form-control numerico" name="Proyecto[planes_presupuestales_precios_unitarios][]" placeholder="Precio unitario" <?= $disabled ?>/>
				    <input type="hidden" id="proyecto-plan_presupuestal_precio_unitario1_0"  class="form-control numerico" name="Proyecto[planes_presupuestales_precios_unitarios][]" />
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_cantidad_0 required" style="margin-top: 0px">
				    <input id="proyecto-plan_presupuestal_cantidad_0" onfocusout="Subtotal2(0,2)" class="form-control numerico" name="Proyecto[planes_presupuestales_cantidades][]" placeholder="Cantidad" <?= $disabled ?>/>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-plan_presupuestal_subtotal_0 required" style="margin-top: 0px">
				    <input id="proyecto-plan_presupuestal_subtotal1_0" class="form-control numerico" name="Proyecto[planes_presupuestales_subtotales1][]" placeholder="Subtotal" disabled/>
				    <input type="hidden" id="proyecto-plan_presupuestal_subtotal_0" class="form-control numerico" name="Proyecto[planes_presupuestales_subtotales][]" placeholder="Subtotal"  />
				</div>
			    </td>
			    <?php if($disabled==''){?>
			    <td style="padding: 2px">
				<!--<span class="remCF glyphicon glyphicon-minus-sign"></span>-->
			    </td>
			    <?php } ?>
			</tr>
		<?php $plan=1; ?>
		<?php } ?>
		<tr id='plan_presupuestal_<?= $plan ?>'></tr>
	    </tbody>
	</table>
	<?php if($disabled==''){?>
	<div  class="btn btn-default pull-right" onclick="InsertarPlanPresupuestal()">Agregar</div>
	<?php } ?>
	<!--<div class="btn btn-default pull-left" onclick="InsertarPlanPresupuestal()">Agregar</div>-->
    </div>
    <div class="clearfix"></div>

<?php
    $eliminarplanpresupuestal= Yii::$app->getUrlManager()->createUrl('actividad/eliminarplanpresupuestal');
?>
<script>
    var plan=<?= $plan ?>;
    var opciones_objetivos="<?= $opciones_objetivos ?>";
    function actividad(value,contador) {
	$.get( '<?= Yii::$app->urlManager->createUrl('plan-presupuestal/actividades?id=') ?>'+value, function( data ) {
	    $( '#proyecto-plan_presupuestal_actividad_'+contador ).html( data );
	});
    }
    
    $("#tab_plan_presupuestal").on('click',' .remCF',function(){
	
	
        var r = confirm("Estas seguro?");
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
    
    
    function InsertarPlanPresupuestal() {
	var error='';
	var planespresupuestales=$('input[name=\'Proyecto[planes_presupuestales_precios_unitarios][]\']').length;
        for (var i=0; i<planespresupuestales; i++) {
	    if($('#proyecto-plan_presupuestal_objetivo_'+i).val()=='')
            {
                error=error+'ingrese el #'+i+' objetivo <br>';
                $('.field-proyecto-plan_presupuestal_objetivo_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_objetivo_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_objetivo_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-plan_presupuestal_actividad_'+i).val()=='')
            {
                error=error+'ingrese el #'+i+' actividad <br>';
                $('.field-proyecto-plan_presupuestal_actividad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_actividad_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_actividad_'+i).removeClass('has-error');
            }
	    
            if($('#proyecto-plan_presupuestal_recurso_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' recurso <br>';
                $('.field-proyecto-plan_presupuestal_recurso_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_recurso_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_recurso_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-plan_presupuestal_como_conseguirlo_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' como conseguirlo <br>';
                $('.field-proyecto-plan_presupuestal_como_conseguirlo_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_como_conseguirlo_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_como_conseguirlo_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-plan_presupuestal_como_conseguirlo_'+i).val()==3 && $('#proyecto-plan_presupuestal_precio_unitario_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' precio unitario <br>';
                $('.field-proyecto-plan_presupuestal_precio_unitario_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_precio_unitario_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_precio_unitario_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-plan_presupuestal_cantidad_'+i).val()=='')
            {
                error=error+'ingrese la '+i+' cantidad <br>';
                $('.field-proyecto-plan_presupuestal_cantidad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_cantidad_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_cantidad_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-plan_presupuestal_subtotal_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' subtotal <br>';
                $('.field-proyecto-plan_presupuestal_subtotal_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_subtotal_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_subtotal_'+i).removeClass('has-error');
            }
        }
	if (error!='') {
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
	    $('#plan_presupuestal_'+plan).html(
			    "<td style='padding: 2px'>"+
				"<div class='form-group field-proyecto-plan_presupuestal_objetivo_"+plan+" required' style='margin-top: 0px'>"+
				    "<select id='proyecto-plan_presupuestal_objetivo_"+plan+"' class='form-control' name='Proyecto[planes_presupuestales_objetivos][]' onchange='actividad($(this).val(),"+plan+")'>"+
					"<option value=''>seleccionar</option>"+
					opciones_objetivos+
				    "</select>"+
			       "</div>"+
			    "</td>"+
			    "<td style='padding: 2px'>"+
				"<div class='form-group field-proyecto-plan_presupuestal_actividad_"+plan+" required' style='margin-top: 0px'>"+
				    "<select id='proyecto-plan_presupuestal_actividad_"+plan+"' class='form-control' name='Proyecto[planes_presupuestales_actividades][]'>"+
					"<option value=''>seleccionar</option>"+
				    "</select>"+
			       "</div>"+
			    "</td>"+
			    "<td style='padding: 2px'>"+
				"<div class='form-group field-proyecto-plan_presupuestal_recurso_"+plan+" required' style='margin-top: 0px'>"+
				    "<select id='proyecto-plan_presupuestal_recurso_"+plan+"' class='form-control' name='Proyecto[planes_presupuestales_recursos][]'>"+
					"<option value=''>seleccionar</option>"+
					"<option value='1'>Material</option>"+
					"<option value='2'>Humano</option>"+
				    "</select>"+
			       "</div>"+
			    "</td>"+
			    "<td style='padding: 2px'>"+
				"<div class='form-group field-proyecto-plan_presupuestal_como_conseguirlo_"+plan+" required' style='margin-top: 0px'>"+
				    "<select onchange='ComoConseguirlo($(this).val(),"+plan+")' id='proyecto-plan_presupuestal_como_conseguirlo_"+plan+"' class='form-control' name='Proyecto[planes_presupuestales_comos_conseguirlos][]'>"+
					"<option value=''>seleccionar</option>"+
					"<option value='1'>Pedir</option>"+
					"<option value='2'>Crear</option>"+
					"<option value='3'>Comprar</option>"+
				    "</select>"+
				"</div>"+
			    "</td>"+
			    "<td style='padding: 2px'>"+
				"<div class='form-group field-proyecto-plan_presupuestal_precio_unitario_"+plan+" required' style='margin-top: 0px'>"+
				    "<input id='proyecto-plan_presupuestal_precio_unitario_"+plan+"' onfocusout='Subtotal1("+plan+",1)' class='form-control' name='Proyecto[planes_presupuestales_precios_unitarios][]' placeholder='Precio unitario'>"+
				    "<input type='hidden' id='proyecto-plan_presupuestal_precio_unitario1_"+plan+"'  class='form-control numerico' name='Proyecto[planes_presupuestales_precios_unitarios][]' />"+
				"</div>"+
			    "</td>"+
			    "<td style='padding: 2px'>"+
				"<div class='form-group field-proyecto-plan_presupuestal_cantidad_"+plan+" required' style='margin-top: 0px'>"+
				    "<input id='proyecto-plan_presupuestal_cantidad_"+plan+"' onfocusout='Subtotal2("+plan+",2)' class='form-control' name='Proyecto[planes_presupuestales_cantidades][]' placeholder='Cantidad'>"+
				"</div>"+
			    "</td>"+
			    "<td style='padding: 2px'>"+
				"<div class='form-group field-proyecto-plan_presupuestal_subtotal_"+plan+" required' style='margin-top: 0px'>"+
				    "<input id='proyecto-plan_presupuestal_subtotal1_"+plan+"' class='form-control' name='Proyecto[planes_presupuestales_subtotales1][]' placeholder='Subtotal' disabled>"+
				    "<input type='hidden' id='proyecto-plan_presupuestal_subtotal_"+plan+"' class='form-control' name='Proyecto[planes_presupuestales_subtotales][]' placeholder='Subtotal'>"+
				"</div>"+
			    "</td>"+
			    "<td style='padding: 2px'>"+
				"<span class='remCF glyphicon glyphicon-minus-sign'></span>"+
			    "</td>");
	    $('#tab_plan_presupuestal').append('<tr id="plan_presupuestal_'+(plan+1)+'"></tr>');
	    plan++;
	}
	return true;
    }
    
    
    
    $('.numerico').keypress(function (tecla) {
	var reg = /^[0-9\s]+$/;
	if(!reg.test(String.fromCharCode(tecla.which))){
	    return false;
	}
	return true;
    });		
    $('.texto').keypress(function(tecla) {
	var reg = /^[a-zA-Z·ÈÌÛ˙‡ËÏÚ˘¿»Ã“Ÿ¡…Õ”⁄Ò—¸‹'_\s]+$/;
	if(!reg.test(String.fromCharCode(tecla.which))){
	    return false;
	}
	return true;
    });
    var x=1;
    var y=1;
    function Subtotal1(id,tipo) {
	if (tipo==1) {
	    x=$('#proyecto-plan_presupuestal_precio_unitario_'+id).val();
	}
	if ($('#proyecto-plan_presupuestal_cantidad_'+id).val()!='') {
	    y=$('#proyecto-plan_presupuestal_cantidad_'+id).val();
	}
	
	var subtotal=x*y;
	$('#proyecto-plan_presupuestal_subtotal_'+id).val(subtotal);
	$('#proyecto-plan_presupuestal_subtotal1_'+id).val(subtotal);
	
    }
    
    function Subtotal2(id,tipo) {
	
	if (tipo==2) {
	    y=$('#proyecto-plan_presupuestal_cantidad_'+id).val();
	}
	
	if ($('#proyecto-plan_presupuestal_precio_unitario_'+id).val()!='') {
	    x=$('#proyecto-plan_presupuestal_precio_unitario_'+id).val();
	}
	var subtotal=x*y;
	$('#proyecto-plan_presupuestal_subtotal_'+id).val(subtotal);
	$('#proyecto-plan_presupuestal_subtotal1_'+id).val(subtotal);
    }
    
    function ComoConseguirlo(value,id) {
	if (value==1 || value==2)
	{
	    $('#proyecto-plan_presupuestal_precio_unitario_'+id).val("");
	    $('#proyecto-plan_presupuestal_precio_unitario_'+id).prop( "disabled", true );
	    $('#proyecto-plan_presupuestal_precio_unitario1_'+id).val("");
	}
	else
	{
	    $('#proyecto-plan_presupuestal_precio_unitario_'+id).prop( "disabled", false );
	}
    }
</script>