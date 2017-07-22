<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use yii\widgets\Pjax;
use yii\web\JsExpression;

/* @var $this \yii\web\View */
/* @var $user \common\models\LoginForm */
/* @var $title string */


?>

<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.11.1/jquery.min.js"></script>



<?php $form = ActiveForm::begin(); ?>
<h2>Registrar Plan presupuestal</h2>
<hr class="colorgraph">
<div class="row">
    

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-3 col-md-3">
	    <?= $actividad->descripcion ?>
	</div>
	<div class="col-xs-12 col-sm-9 col-md-3">
	    <div class="form-group field-actividad-resultado_esperado required">
		<input type="text" id="actividad-resultado_esperado" class="form-control" name="Actividad[resultado_esperado]" placeholder="Resultado" value="<?= $actividad->resultado_esperado ?>" <?= $disabled ?> >
	    </div>
	</div>
	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12">
	    <table class="table table-bordered table-hover" id="tab_logic">
		<thead>
		    <th>Recursos</th>
		    <th>¿Cómo conseguirlo?</th>
		    <th colspan="3" align="center !important">Presupuesto</th>
		    <?php if($disabled==''){?>
		    <th></th>
		    <?php } ?>
		</thead>
		<tbody>
		    
		    <?php if($planespresupuestales){?>
			<?php $a=0; ?>
			<?php foreach($planespresupuestales as $planpresupuestal){?>
			    <tr id='addr_<?= $actividad->actividad_id;?>_<?= $a ?>'>
				<td>
				    <div class="form-group field-actividad-recurso_<?= $a ?> required">
					<select id="actividad-recurso_<?= $a ?>" class="form-control" name="Actividad[recursos][]" <?= $disabled ?>>
					    <option value>seleccionar</option>
					    <option value=1 <?= ($planpresupuestal->recurso == 1) ? 'selected' : ''; ?> >Material</option>
					    <option value=2 <?= ($planpresupuestal->recurso == 2) ? 'selected' : ''; ?>>Humano</option>
					</select>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-como_conseguirlo_<?= $a ?> required">
					<select id="actividad-como_conseguirlo_<?= $a ?>" class="form-control" name="Actividad[comos_conseguirlos][]" <?= $disabled ?>>
					    <option value>seleccionar</option>
					    <option value=1 <?= ($planpresupuestal->como_conseguirlo == 1) ? 'selected' : ''; ?>>Pedir</option>
					    <option value=2 <?= ($planpresupuestal->como_conseguirlo == 2) ? 'selected' : ''; ?>>Crear</option>
					    <option value=3 <?= ($planpresupuestal->como_conseguirlo == 3) ? 'selected' : ''; ?>>Comprar</option>
					</select>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-precio_unitario_<?= $a ?> required">
					<input id="actividad-precio_unitario_<?= $a ?>" onfocusout="Subtotal1(<?= $a ?>,1)" class="form-control numerico" name="Actividad[precios_unitarios][]" placeholder="Precio unitario" value="<?= $planpresupuestal->precio_unitario ?>" <?= $disabled ?>/>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-cantidad_<?= $a ?> required">
					<input id="actividad-cantidad_<?= $a ?>" onfocusout="Subtotal2(<?= $a ?>,2)" class="form-control numerico" name="Actividad[cantidades][]" placeholder="Cantidad" value="<?= $planpresupuestal->cantidad ?>" <?= $disabled ?>/>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-subtotal_<?= $a ?> required">
					<input id="actividad-subtotal_<?= $a ?>" class="form-control numerico" name="Actividad[subtotales][]" placeholder="Subtotal" value="<?= $planpresupuestal->subtotal ?>" <?= $disabled ?>/>
				    </div>
				</td>
				<?php if($disabled==''){?>
				<td>
				    <span class="remCF glyphicon glyphicon-minus-sign">
					<input class="id" type="hidden" name="Actividad[planes_presupuestal_ids][]" value="<?= $planpresupuestal->id ?>" <?= $disabled ?>/>
				    </span>
				</td>
				<?php } ?>
			    </tr>
			    <?php $a++; ?>
			<?php } ?>
		    <?php } else {?>
			    <tr id='addr_<?= $actividad->actividad_id;?>_0'>
				<td>
				    <div class="form-group field-actividad-recurso_0 required">
					<select id="actividad-recurso_0" class="form-control" name="Actividad[recursos][]" <?= $disabled ?>>
					    <option value>seleccionar</option>
					    <option value=1>Material</option>
					    <option value=2>Humano</option>
					</select>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-como_conseguirlo_0 required">
					<select id="actividad-como_conseguirlo_0" class="form-control" name="Actividad[comos_conseguirlos][]" <?= $disabled ?>>
					    <option value>seleccionar</option>
					    <option value=1>Pedir</option>
					    <option value=2>Crear</option>
					    <option value=3>Comprar</option>
					</select>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-precio_unitario_0 required">
					<input id="actividad-precio_unitario_0" onfocusout="Subtotal1(0,1)" class="form-control" name="Actividad[precios_unitarios][]" placeholder="Precio unitario" <?= $disabled ?>/>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-cantidad_0 required">
					<input id="actividad-cantidad_0" onfocusout="Subtotal2(0,2)" class="form-control" name="Actividad[cantidades][]" placeholder="Cantidad" <?= $disabled ?>/>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-subtotal_0 required">
					<input id="actividad-subtotal_0" class="form-control" name="Actividad[subtotales][]" placeholder="Subtotal" <?= $disabled ?>/>
				    </div>
				</td>
				<?php if($disabled==''){?>
				<td>
				    <span class="remCF glyphicon glyphicon-minus-sign"></span>
				</td>
				<?php } ?>
			    </tr>
		    <?php $a=1; ?>
		    <?php } ?>
		    <tr id='addr_<?= $actividad->actividad_id ?>_<?= $a ?>'></tr>
		</tbody>
	    </table>
	    <?php if($disabled==''){?>
	    <div id="add_row_1" class="btn btn-default pull-left" onclick="InsertarPlanPresupuestal(<?= $actividad->actividad_id?>,1)">Agregar</div>
	    <?php } ?>
	</div>
	<div class="clearfix"></div>
	<p>&nbsp</p>
	<p>&nbsp</p>
	<p>&nbsp</p>
	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12">
	    <table class="table table-bordered table-hover" id="tab_logic_cronograma">
		<thead>
		    <th>Responsable</th>
		    <th colspan="2" align="center">Fecha inicio</th>
		    <?php if($disabled==''){?>
		    <th></th>
		    <?php } ?>
		</thead>
		<tbody>
		    <?php if($cronogramas){?>
			<?php $b=0; ?>
			<?php foreach($cronogramas as $cronograma){?>
			    <tr id='addr_<?= $b ?>'>
				<td>
				    <div class="form-group field-actividad-responsable_<?= $b ?> required">
					
					<select id="actividad-responsable_<?= $b ?>" class="form-control" name="Actividad[responsables][]" <?= $disabled ?>>
					    <option value>seleccionar</option>
					    <?php foreach($responsables as $responsable){ ?>
						<?php if($responsable->estudiante_id==$cronograma->responsable_id){ ?>
						    <option value="<?= $responsable->estudiante_id ?>" selected > <?= $responsable->estudiante->nombres_apellidos ?></option>
						<?php } else { ?>
						    <option value="<?= $responsable->estudiante_id ?>" > <?= $responsable->estudiante->nombres_apellidos ?></option>
						<?php } ?>
					    <?php } ?>
					</select>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-fecha_inicio_<?= $b ?> required">
					<input type='date' id="actividad-fecha_inicio_<?= $b ?>" class="form-control" name="Actividad[fechas_inicios][]" placeholder="Fecha inicio" value="<?= date("Y-m-d",strtotime($cronograma->fecha_inicio));  ?>" <?= $disabled ?>/>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-fecha_fin_<?= $b ?> required">
					<input type='date' id="actividad-fecha_fin_<?= $b ?>" class="form-control" name="Actividad[fechas_fines][]" placeholder="Fecha fin" value="<?= date("Y-m-d",strtotime($cronograma->fecha_fin));  ?>" <?= $disabled ?>/>
				    </div>
				</td>
				<?php if($disabled==''){?>
				<td>
				    <span class="remCF glyphicon glyphicon-minus-sign">
					<input type="hidden" name="Actividad[cronogramas_ids][]" value="<?= $cronograma->id ?>"/>
				    </span>
				</td>
				<?php } ?>
			    </tr>
			    <?php $b++; ?>
			<?php } ?>
		    <?php } else {?>
			    <tr id='addr_0'>
				<td>
				    <div class="form-group field-actividad-responsable_0 required">
					<select id="actividad-responsable_0" class="form-control" name="Actividad[responsables][]" <?= $disabled ?>>
					    <option value>seleccionar</option>
					    <?php foreach($responsables as $responsable){ ?>
						<option value="<?= $responsable->estudiante_id ?>"><?= $responsable->estudiante->nombres_apellidos ?></option>
					    <?php } ?>
					</select>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-fecha_inicio_0 required">
					<input type='date' id="actividad-fecha_inicio_0" class="form-control" name="Actividad[fechas_inicios][]" placeholder="Fecha inicio" <?= $disabled ?>/>
				    </div>
				</td>
				<td>
				    <div class="form-group field-actividad-fecha_fin_0 required">
					<input type='date' id="actividad-fecha_fin_0" class="form-control" name="Actividad[fechas_fines][]" placeholder="Fecha fin" <?= $disabled ?>/>
				    </div>
				</td>
				<?php if($disabled==''){?>
				<td>
				    <span class="remCF glyphicon glyphicon-minus-sign"></span>
				</td>
				<?php } ?>
			    </tr>
		    <?php $b=1; ?>
		    <?php } ?>
			    <tr id='addr_<?= $b?>'></tr>
		</tbody>
	    </table>
	    <?php if($disabled==''){?>
	    <div id="add_row_1" class="btn btn-default pull-left" onclick="InsertarCronograma()">Agregar</div>
	    <?php } ?>
	</div>
    <div class="clearfix"></div>   
    <div class="modal-footer">
	<?php if($disabled==''){?>
	<button type="submit" id="btnplanpresupuestal" class="btn btn-primary">Guardar</button>
	<?php } ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
    $this->registerJs(
    "$('document').ready(function(){})");
?>
<?php
    $eliminaractividad= Yii::$app->getUrlManager()->createUrl('actividad/eliminarplanpresupuestal');
    $eliminarcronograma=Yii::$app->getUrlManager()->createUrl('actividad/eliminarcronograma');
    $validaractividad=Yii::$app->getUrlManager()->createUrl('actividad/validaractividad');
?>
<script>
    

    var b=<?= $b ?>;
    var a=<?= $a ?>;
    
    $("#tab_logic").on('click',' .remCF',function(){
	
	
        var r = confirm("¿Estás seguro?");
        if (r == true) {
            id=$(this).children().val();
	    if (id) {
		$.ajax({
		    url: '<?= $eliminaractividad ?>',
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
    
    
    $("#tab_logic_cronograma").on('click',' .remCF',function(){
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
    
    function InsertarPlanPresupuestal(id) {
	var error='';
	var detalle=$('input[name=\'Actividad[precios_unitarios][]\']').length;
        for (var i=0; i<detalle; i++) {
            if($('#actividad-recurso_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' recurso <br>';
                $('.field-actividad-recurso_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-recurso_'+i).addClass('has-success');
                $('.field-actividad-recurso_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-como_conseguirlo_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' como conseguirlo <br>';
                $('.field-actividad-como_conseguirlo_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-como_conseguirlo_'+i).addClass('has-success');
                $('.field-actividad-como_conseguirlo_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-precio_unitario_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' precio unitario <br>';
                $('.field-actividad-precio_unitario_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-precio_unitario_'+i).addClass('has-success');
                $('.field-actividad-precio_unitario_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-cantidad_'+i).val()=='')
            {
                error=error+'ingrese la '+i+' cantidad <br>';
                $('.field-actividad-cantidad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-cantidad_'+i).addClass('has-success');
                $('.field-actividad-cantidad_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-subtotal_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' subtotal <br>';
                $('.field-actividad-subtotal_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-subtotal_'+i).addClass('has-success');
                $('.field-actividad-subtotal_'+i).removeClass('has-error');
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
	    
	    $('#addr_'+id+'_'+a).html(
			    "<td>"+
				"<div class='form-group field-actividad-recurso_"+a+" required'>"+
				    "<select id='actividad-recurso_"+a+"' class='form-control' name='Actividad[recursos][]'>"+
					"<option value=''>seleccionar</option>"+
					"<option value='1'>Material</option>"+
					"<option value='2'>Humano</option>"+
				    "</select>"+
			       "</div>"+
			    "</td>"+
			    "<td>"+
				"<div class='form-group field-actividad-como_conseguirlo_"+a+" required'>"+
				    "<select id='actividad-como_conseguirlo_"+a+"' class='form-control' name='Actividad[comos_conseguirlos][]'>"+
					"<option value=''>seleccionar</option>"+
					"<option value='1'>Pedir</option>"+
					"<option value='2'>Crear</option>"+
					"<option value='3'>Comprar</option>"+
				    "</select>"+
				"</div>"+
			    "</td>"+
			    "<td>"+
				"<div class='form-group field-actividad-precio_unitario_"+a+" required'>"+
				    "<input id='actividad-precio_unitario_"+a+"' onfocusout='Subtotal1("+a+",1)' class='form-control' name='Actividad[precios_unitarios][]' placeholder='Precio unitario'>"+
				"</div>"+
			    "</td>"+
			    "<td>"+
				"<div class='form-group field-actividad-cantidad_"+a+" required'>"+
				    "<input id='actividad-cantidad_"+a+"' onfocusout='Subtotal2("+a+",2)' class='form-control' name='Actividad[cantidades][]' placeholder='Cantidad'>"+
				"</div>"+
			    "</td>"+
			    "<td>"+
				"<div class='form-group field-actividad-subtotal_"+a+" required'>"+
				    "<input id='actividad-subtotal_"+a+"' class='form-control' name='Actividad[subtotales][]' placeholder='Subtotal'>"+
				"</div>"+
			    "</td>"+
			    "<td>"+
				"<span class='remCF glyphicon glyphicon-minus-sign'></span>"+
			    "</td>");
	    $('#tab_logic').append('<tr id="addr_'+id+'_'+(a+1)+'"></tr>');
	    a++;
	}
	return true;
    }
    
    $("#btnplanpresupuestal").click(function(event){
        var error='';
        
	var validaractividad=new $.ajax({
	    url: '<?= $validaractividad ?>',
	    type: 'GET',
	    async: false,
	    data: {id:<?= $actividad->actividad_id?>},
	    success: function(data){
	    }
	});
	
	if (validaractividad.responseText=="0")
	{
	    $.notify({
                message: 'La actividad ha sido eliminada' 
            },{
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
	    
	    return false;
	    
	}
	
        if($('#actividad-resultado_esperado').val()=='')
        {
            error=error+'ingrese el resultado esperado <br>';
            $('.field-actividad-resultado_esperado').addClass('has-error');
        }
        else
        {
            $('.field-actividad-resultado_esperado').addClass('has-success');
            $('.field-actividad-resultado_esperado').removeClass('has-error');
        }
        
	var detalle=$('input[name=\'Actividad[precios_unitarios][]\']').length;
        for (var i=0; i<detalle; i++) {
            if($('#actividad-recurso_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' recurso <br>';
                $('.field-actividad-recurso_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-recurso_'+i).addClass('has-success');
                $('.field-actividad-recurso_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-como_conseguirlo_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' como conseguirlo <br>';
                $('.field-actividad-como_conseguirlo_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-como_conseguirlo_'+i).addClass('has-success');
                $('.field-actividad-como_conseguirlo_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-precio_unitario_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' precio unitario <br>';
                $('.field-actividad-precio_unitario_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-precio_unitario_'+i).addClass('has-success');
                $('.field-actividad-precio_unitario_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-cantidad_'+i).val()=='')
            {
                error=error+'ingrese la '+i+' cantidad <br>';
                $('.field-actividad-cantidad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-cantidad_'+i).addClass('has-success');
                $('.field-actividad-cantidad_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-subtotal_'+i).val()=='')
            {
                error=error+'ingrese el '+i+' subtotal <br>';
                $('.field-actividad-subtotal_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-subtotal_'+i).addClass('has-success');
                $('.field-actividad-subtotal_'+i).removeClass('has-error');
            }
        }
        
        var detalle=$('input[name=\'Actividad[fechas_inicios][]\']').length;
        for (var i=0; i<detalle; i++) {
            if($('#actividad-responsable_'+i).val()=='')
            {
                error=error+'ingrese el responsable '+i+' <br>';
                $('.field-actividad-responsable_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-responsable_'+i).addClass('has-success');
                $('.field-actividad-responsable_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-fecha_inicio_'+i).val()=='')
            {
                error=error+'ingrese la fecha inicio de '+i+' <br>';
                $('.field-actividad-fecha_inicio_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-fecha_inicio_'+i).addClass('has-success');
                $('.field-actividad-fecha_inicio_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-fecha_fin_'+i).val()=='')
            {
                error=error+'ingrese la fecha fin de '+i+' <br>';
                $('.field-actividad-fecha_fin_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-fecha_fin_'+i).addClass('has-success');
                $('.field-actividad-fecha_fin_'+i).removeClass('has-error');
            }
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
        return true;
    });
    
    
    
    
    function InsertarCronograma() {
	var error='';
	var detalle=$('input[name=\'Actividad[fechas_inicios][]\']').length;
        for (var i=0; i<detalle; i++) {
            if($('#actividad-responsable_'+i).val()=='')
            {
                error=error+'ingrese el responsable '+i+' <br>';
                $('.field-actividad-responsable_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-responsable_'+i).addClass('has-success');
                $('.field-actividad-responsable_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-fecha_inicio_'+i).val()=='')
            {
                error=error+'ingrese la fecha inicio de '+i+' <br>';
                $('.field-actividad-fecha_inicio_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-fecha_inicio_'+i).addClass('has-success');
                $('.field-actividad-fecha_inicio_'+i).removeClass('has-error');
            }
	    
	    if($('#actividad-fecha_fin_'+i).val()=='')
            {
                error=error+'ingrese la fecha fin de '+i+' <br>';
                $('.field-actividad-fecha_fin_'+i).addClass('has-error');
            }
            else
            {
                $('.field-actividad-fecha_fin_'+i).addClass('has-success');
                $('.field-actividad-fecha_fin_'+i).removeClass('has-error');
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
	   
	    $('#addr_'+b).html(
			    "<td>"+
				"<div class='form-group field-actividad-responsable_"+b+" required'>"+
				    "<select id='actividad-responsable_"+b+"' class='form-control' name='Actividad[responsables][]' >"+
					"<option value>seleccionar</option>"+
					<?php foreach($responsables as $responsable){ ?>
					    "<option value='<?= $responsable->estudiante_id ?>'><?= $responsable->estudiante->nombres_apellidos ?></option>"+
					<?php } ?>
				    "</select>"+
				"</div>"+
			    "</td>"+
			   "<td>"+
				"<div class='form-group field-actividad-fecha_inicio_"+b+" required'>"+
				    "<input type='date' id='actividad-fecha_inicio_"+b+"' class='form-control' name='Actividad[fechas_inicios][]' placeholder='Fecha inicio' />"+
				"</div>"+
			    "</td>"+
			    "<td>"+
				"<div class='form-group field-actividad-fecha_fin_"+b+" required'>"+
				    "<input type='date' id='actividad-fecha_fin_"+b+"' class='form-control' name='Actividad[fechas_fines][]' placeholder='Fecha fin' />"+
				"</div>"+
			    "</td>"+
			    "<td>"+
				"<span class='remCF glyphicon glyphicon-minus-sign'></span>"+
			    "</td>");
	    $('#tab_logic_cronograma').append('<tr id="addr_'+(b+1)+'"></tr>');
	    b++;
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
	var reg = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ'_\s]+$/;
	if(!reg.test(String.fromCharCode(tecla.which))){
	    return false;
	}
	return true;
    });
    var x=1;
    var y=1;
    function Subtotal1(id,tipo) {
	if (tipo==1) {
	    x=$('#actividad-precio_unitario_'+id).val();
	}
	if ($('#actividad-cantidad_'+id).val()!='') {
	    y=$('#actividad-cantidad_'+id).val();
	}
	
	var subtotal=x*y;
	$('#actividad-subtotal_'+id).val(subtotal);
    }
    
    function Subtotal2(id,tipo) {
	
	if (tipo==2) {
	    y=$('#actividad-cantidad_'+id).val();
	}
	
	if ($('#actividad-precio_unitario_'+id).val()!='') {
	    x=$('#actividad-precio_unitario_'+id).val();
	}
	var subtotal=x*y;
	$('#actividad-subtotal_'+id).val(subtotal);
    }
    
    
</script>

