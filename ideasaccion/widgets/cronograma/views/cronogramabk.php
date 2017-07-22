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
	<table class="table table-striped table-hover" id="tab_cronograma">
	    <thead>
		<th>Objetivo especifico</th>
		<th>Actividad</th>
		<th>Responsable</th>
		<th colspan="2" align="center">Fecha inicio</th>
		<?= ($disabled=='')?'<th></th>':'' ?>
	    </thead>
	    <tbody>
		<?php if($cronogramas){?>
		    <?php $cron=0; ?>
		    <?php foreach($cronogramas as $cronograma){?>
			<tr id='cronograma_<?= $cron ?>'>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-cronograma_objetivo_<?= $cron ?> required" style="margin-top: 0px">
				    <select id="proyecto-cronograma_objetivo_<?= $cron ?>" class="form-control" name="Proyecto[cronogramas_objetivos][]" onchange="actividad2($(this).val(),<?= $cron ?>)" <?= $disabled ?>>
					<option value>seleccionar</option>
					<?php foreach($objetivos as $objetivo){  ?>
					    <option value='<?= $objetivo->id ?>' <?= ($objetivo->id==$cronograma->objetivo_especifico_id)?'selected':'' ?>><?= $objetivo->descripcion ?></option>
					<?php }  ?>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-cronograma_actividad_<?= $cron ?> required" style="margin-top: 0px">
				    <select id="proyecto-cronograma_actividad_<?= $cron ?>" class="form-control" name="Proyecto[cronogramas_actividades][]" <?= $disabled ?>>
					<option value>seleccionar</option>
					<?php foreach($actividades as $actividad){  ?>
					    <option value='<?= $actividad->id ?>' <?= ($actividad->id==$cronograma->actividad_id)?'selected':'' ?> ><?= $actividad->descripcion ?> </option>
					<?php } ?>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-cronograma_responsable_<?= $cron ?> required" style="margin-top: 0px">
				    
				    <select id="proyecto-cronograma_responsable_<?= $cron ?>" class="form-control" name="Proyecto[cronogramas_responsables][]" <?= $disabled ?>>
					<option value>seleccionar</option>
					<?php foreach($responsables as $responsable){ ?>
					    <?php if($responsable->estudiante_id==$cronograma->responsable_id){ ?>
						<option value="<?= $responsable->estudiante_id ?>" selected > <?= $responsable->estudiante->nombres." ".$responsable->estudiante->apellido_paterno." ".$responsable->estudiante->apellido_materno ?></option>
					    <?php } else { ?>
						<option value="<?= $responsable->estudiante_id ?>" > <?= $responsable->estudiante->nombres." ".$responsable->estudiante->apellido_paterno." ".$responsable->estudiante->apellido_materno ?></option>
					    <?php } ?>
					<?php } ?>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-cronograma_fecha_inicio_<?= $cron ?> required" style="margin-top: 0px">
				    <input type='date' id="proyecto-cronograma_fecha_inicio_<?= $cron ?>" class="form-control" name="Proyecto[cronogramas_fechas_inicios][]" placeholder="Fecha inicio" value="<?= date("Y-m-d",strtotime($cronograma->fecha_inicio));  ?>" <?= $disabled ?>/>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-cronograma_fecha_fin_<?= $cron ?> required" style="margin-top: 0px">
				    <input type='date' id="proyecto-cronograma_fecha_fin_<?= $cron ?>" class="form-control" name="Proyecto[cronogramas_fechas_fines][]" placeholder="Fecha fin" value="<?= date("Y-m-d",strtotime($cronograma->fecha_fin));  ?>" <?= $disabled ?>/>
				</div>
			    </td>
			    <?php if($disabled==''){?>
			    <td style="padding: 2px">
				<span class="remCF glyphicon glyphicon-minus-sign">
				    <input type="hidden" name="Proyecto[cronogramas_ids][]" value="<?= $cronograma->id ?>"/>
				</span>
			    </td>
			    <?php } ?>
			</tr>
			<?php $cron++; ?>
		    <?php } ?>
		<?php } else {?>
			<tr id='cronograma_0'>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-cronograma_objetivo_0 ?> required" style="margin-top: 0px">
				    <select id="proyecto-cronograma_objetivo_0" class="form-control" name="Proyecto[cronogramas_objetivos][]" onchange="actividad2($(this).val(),0)" <?= $disabled ?>>
					<option value>seleccionar</option>
					<?php foreach($objetivos as $objetivo){  ?>
					    <option value='<?= $objetivo->id ?>' ><?= $objetivo->descripcion ?></option>
					<?php }  ?>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-cronograma_actividad_0 required" style="margin-top: 0px">
				    <select id="proyecto-cronograma_actividad_0" class="form-control" name="Proyecto[cronogramas_actividades][]" <?= $disabled ?>>
					<option value>seleccionar</option>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-cronograma_responsable_0 required" style="margin-top: 0px">
				    <select id="proyecto-cronograma_responsable_0" class="form-control" name="Proyecto[cronogramas_responsables][]" <?= $disabled ?>>
					<option value>seleccionar</option>
					<?php foreach($responsables as $responsable){ ?>
					    <option value="<?= $responsable->estudiante_id ?>"><?= $responsable->estudiante->nombres." ".$responsable->estudiante->apellido_paterno." ".$responsable->estudiante->apellido_materno ?></option>
					<?php } ?>
				    </select>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-cronograma_fecha_inicio_0 required" style="margin-top: 0px">
				    <input type='date' id="proyecto-cronograma_fecha_inicio_0" class="form-control" name="Proyecto[cronogramas_fechas_inicios][]" placeholder="Fecha inicio" <?= $disabled ?>/>
				</div>
			    </td>
			    <td style="padding: 2px">
				<div class="form-group field-proyecto-cronograma_fecha_fin_0 required" style="margin-top: 0px">
				    <input type='date' id="proyecto-cronograma_fecha_fin_0" class="form-control" name="Proyecto[cronogramas_fechas_fines][]" placeholder="Fecha fin" <?= $disabled ?>/>
				</div>
			    </td>
			    <?php if($disabled==''){?>
			    <td style="padding: 2px">
				<!--<span class="remCF glyphicon glyphicon-minus-sign"></span>-->
			    </td>
			    <?php } ?>
			</tr>
		<?php $cron=1; ?>
		<?php } ?>
			<tr id='cronograma_<?= $cron?>'></tr>
	    </tbody>
	</table>
	<?php if($disabled==''){?>
	<div  class="btn btn-default pull-right" onclick="InsertarCronograma()">Agregar</div>
	<?php } ?>
    </div>
<div class="clearfix"></div>
<?php
    $eliminarcronograma=Yii::$app->getUrlManager()->createUrl('actividad/eliminarcronograma');
?>
<script>
    var cron=<?= $cron ?>;
    var opciones_objetivos="<?= $opciones_objetivos ?>";
    function actividad2(value,contador) {
	$.get( '<?= Yii::$app->urlManager->createUrl('plan-presupuestal/actividades?id=') ?>'+value, function( data ) {
	    $( '#proyecto-cronograma_actividad_'+contador ).html( data );
	});
    }
    
    $("#tab_cronograma").on('click',' .remCF',function(){
        var r = confirm("¿Estás seguro?");
	id=$(this).children().val();
	//console.log(id);
        if (r == true) {
            
	    if (id) {
		$.ajax({
		    url: '<?= $eliminarcronograma ?>',
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
    
    function InsertarCronograma() {
	var error='';
	var cronogramas=$('input[name=\'Proyecto[cronogramas_fechas_inicios][]\']').length;
        for (var i=0; i<cronogramas; i++) {
	    
	    if($('#proyecto-cronograma_objetivo_'+i).val()=='')
            {
                error=error+'ingrese el #'+i+' objetivo <br>';
                $('.field-proyecto-cronograma_objetivo_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-cronograma_objetivo_'+i).addClass('has-success');
                $('.field-proyecto-cronograma_objetivo_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-cronograma_actividad_'+i).val()=='')
            {
                error=error+'ingrese el #'+i+' actividad <br>';
                $('.field-proyecto-cronograma_actividad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-cronograma_actividad_'+i).addClass('has-success');
                $('.field-proyecto-cronograma_actividad_'+i).removeClass('has-error');
            }
	    
            if($('#proyecto-cronograma_responsable_'+i).val()=='')
            {
                error=error+'ingrese el responsable '+i+' <br>';
                $('.field-proyecto-cronograma_responsable_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-cronograma_responsable_'+i).addClass('has-success');
                $('.field-proyecto-cronograma_responsable_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-cronograma_fecha_inicio_'+i).val()=='')
            {
                error=error+'ingrese la fecha inicio de '+i+' <br>';
                $('.field-proyecto-cronograma_fecha_inicio_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-cronograma_fecha_inicio_'+i).addClass('has-success');
                $('.field-proyecto-cronograma_fecha_inicio_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-cronograma_fecha_fin_'+i).val()=='')
            {
                error=error+'ingrese la fecha fin de '+i+' <br>';
                $('.field-proyecto-cronograma_fecha_fin_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-cronograma_fecha_fin_'+i).addClass('has-success');
                $('.field-proyecto-cronograma_fecha_fin_'+i).removeClass('has-error');
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
	   
	    $('#cronograma_'+cron).html(
		    "<td style='padding: 2px'>"+
			"<div class='form-group field-proyecto-cronograma_objetivo_"+cron+" required' style='margin-top: 0px'> "+
			    "<select id='proyecto-cronograma_objetivo_"+cron+"' class='form-control' name='Proyecto[cronogramas_objetivos][]' onchange='actividad2($(this).val(),"+cron+")'>"+
				"<option value=''>seleccionar</option>"+
				opciones_objetivos+
			    "</select>"+
		       "</div>"+
		    "</td>"+
		    "<td style='padding: 2px'>"+
			"<div class='form-group field-proyecto-cronograma_actividad_"+cron+" required' style='margin-top: 0px'>"+
			    "<select id='proyecto-cronograma_actividad_"+cron+"' class='form-control' name='Proyecto[cronogramas_actividades][]'>"+
				"<option value=''>seleccionar</option>"+
			    "</select>"+
		       "</div>"+
		    "</td>"+
		    "<td style='padding: 2px'>"+
			"<div class='form-group field-proyecto-cronograma_responsable_"+cron+" required' style='margin-top: 0px'>"+
			    "<select id='proyecto-cronograma_responsable_"+cron+"' class='form-control' name='Proyecto[cronogramas_responsables][]' >"+
				"<option value>seleccionar</option>"+
				<?php foreach($responsables as $responsable){ ?>
				    "<option value='<?= $responsable->estudiante_id ?>'><?= $responsable->estudiante->nombres." ".$responsable->estudiante->apellido_paterno." ".$responsable->estudiante->apellido_materno ?></option>"+
				<?php } ?>
			    "</select>"+
			"</div>"+
		    "</td>"+
		   "<td style='padding: 2px'>"+
			"<div class='form-group field-proyecto-cronograma_fecha_inicio_"+cron+" required' style='margin-top: 0px'>"+
			    "<input type='date' id='proyecto-cronograma_fecha_inicio_"+cron+"' class='form-control' name='Proyecto[cronogramas_fechas_inicios][]' placeholder='Fecha inicio' />"+
			"</div>"+
		    "</td>"+
		    "<td style='padding: 2px'>"+
			"<div class='form-group field-proyecto-cronograma_fecha_fin_"+cron+" required' style='margin-top: 0px'>"+
			    "<input type='date' id='proyecto-cronograma_fecha_fin_"+cron+"' class='form-control' name='Proyecto[cronogramas_fechas_fines][]' placeholder='Fecha fin' />"+
			"</div>"+
		    "</td>"+
		    "<td style='padding: 2px'>"+
			"<span class='remCF glyphicon glyphicon-minus-sign'></span>"+
		    "</td>");
	    $('#tab_cronograma').append('<tr id="cronograma_'+(cron+1)+'"></tr>');
	    cron++;
	}
	
	return true;
	
    }
</script>

