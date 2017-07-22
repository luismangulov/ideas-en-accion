<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Resultados;
use yii\widgets\Pjax;
use yii\web\JsExpression;

/* @var $this \yii\web\View */
/* @var $user \common\models\LoginForm */
/* @var $title string */

?>
<style>
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

<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_project_big.png" alt="">MI PROYECTO
</div>
<div class="box_content contenido_seccion_crear_equipo">
    <div class="row">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" style="background: white;">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false" style="color: #333 !important">Datos generales</a></li>
                <!--<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true" style="color: #333 !important">Objetivos y actividades</a></li>-->
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-titulo required" >
                                <label class="control-label" for="proyecto-titulo" title="Máximo 200 palabras">Título</label>
                                <input type="text" id="proyecto-titulo" class="form-control" name="Proyecto[titulo]" maxlength="200" title="Máximo 200 palabras">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <!--
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-asunto required">
                                <label class="control-label" for="proyecto-asunto" >Asunto público</label>
                                <input class="form-control" value="<?php //= $equipo->asunto->descripcion_cabecera?>" disabled>
                            </div>
                        </div>
                        -->
                        <div class="clearfix"></div>
                        <!--
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-resumen required" style="margin-top: 15px">
                                <label class="control-label" for="proyecto-resumen" >Sumilla / Justificación</label>
                                <textarea rows="3" id="proyecto-resumen" class="form-control" name="Proyecto[resumen]" minlength="100" maxlength="2500" ></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-beneficiario required" style="margin-top: 15px">
                                <label class="control-label" for="proyecto-beneficiario">Beneficiario</label>
                                <textarea rows="3" id="proyecto-beneficiario" class="form-control" name="Proyecto[beneficiario]" maxlength="2500"></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-archivo required" >
                                <label class="control-label" for="proyecto-archivo">Publica tu proyecto</label>
                                <input class="form-control" type="file" id="proyecto-archivo"  name="Proyecto[archivo]" onchange="Documento(this)"/>
                                <div class="input-group">
                                    <input type="text" readonly="" class="form-control" >
                                      <span class="input-group-btn input-group-sm">
                                        <button type="button" class="btn btn-fab btn-fab-mini">
                                          <i class="material-icons">archivo</i>
                                        </button>
                                      </span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        -->
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <!--
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group label-floating field-proyecto-objetivo_general required" style="margin-top: 15px">
                                <label class="control-label" for="proyecto-objetivo_general" title="Máximo 200 palabras">Objetivo general</label>
                                <textarea style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="proyecto-objetivo_general" class="form-control" name="Proyecto[objetivo_general]"  maxlength="200"  title="Máximo 200 palabras"></textarea>
                            </div>
                        </div>
                        -->
                        <!--
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4><b>Objetivos</b> <span class="glyphicon glyphicon-plus-sign" onclick="agregarObjetivoActividad()" ></span></h4>
                        </div>
                        
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div id="mostrar_oe_actividades">
                            </div>
                        </div>
                    -->
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div>
        
        <div style="border-top:2px dotted #f6de34 !important;">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <button type="submit" id="btnproyecto" class="btn btn-raised btn-default">Guardar</button>
        </div>
        </div>
    </div>
</div>
<!-- Objetivo Especifico general-->
<div class="modal fade" id="objetivo_especifico_general" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 2000 !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/vote_popup_close.png" alt=""></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" id="oe_modal">
                
            </div>
            <div class="modal-footer">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-default"  onclick='MostrarOeActividades()'>Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Objetivo Especifico general-->
        <div class="modal fade" id="objetivo_especifico_general_copia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="z-index: 2000 !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/vote_popup_close.png" alt=""></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="oe_modal_copia">
                        
                    </div>
                    <div class="modal-footer" id="oe_modal_button">
                        
                    </div>
                </div>
            </div>
        </div>
<?php ActiveForm::end(); ?>


<script>
    var i=1;
    var a=1;
    var e=1;
    $("#tab_logic_1").on('click','.remCF',function(){
        $(this).parent().parent().remove();
    });
    
    $("#tab_logic_2").on('click','.remCF',function(){
        $(this).parent().parent().remove();
    });
    
    $("#tab_logic_3").on('click','.remCF',function(){
        $(this).parent().parent().remove();
    });
    $("#add_row_1").click(function(){
        
        
        var objetivo=$('input[name=\'Proyecto[actividades_1][]\']').length;
        if (objetivo==5 && $('#proyecto-actividad_objetivo1_'+(i-1)).val()!='')
        {
            $.notify({
                message: 'No se puede agregar mas de 5' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).removeClass('has-error');
            return false;
        }
        
        
        if($('#proyecto-actividad_objetivo1_'+(i-1)).val()=='')
        {
            var error='ingrese la '+i+' actividad <br>';
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).addClass('has-error');
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
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo1_'+(i-1)).removeClass('has-error');
            
            $('#addr_1_'+i).html("<td>"+ (i+1) +"</td><td style='padding: 2px'><div class='form-group field-proyecto-actividad_objetivo1_"+i+" required' style='margin-top: 0px'><input placeholder='Actividad #"+(i+1)+"' id='proyecto-actividad_objetivo1_"+i+"' name='Proyecto[actividades_1][]' type='text' class='form-control'  /></div></td><td><span class='remCF glyphicon glyphicon-minus-sign'></span></td>");
            $('#tab_logic_1').append('<tr id="addr_1_'+(i+1)+'"></tr>');
            i++;
        }
        
        
        return true;
    });
    
    
    $("#add_row_2").click(function(){
        
        
        var objetivo=$('input[name=\'Proyecto[actividades_2][]\']').length;
        if (objetivo==5 && $('#proyecto-actividad_objetivo2_'+(a-1)).val()!='')
        {
            $.notify({
                message: 'No se puede agregar mas de 5' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            $('.field-proyecto-actividad_objetivo2_'+(a-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo2_'+(a-1)).removeClass('has-error');
            return false;
        }
        
        
        if($('#proyecto-actividad_objetivo2_'+(a-1)).val()=='')
        {
            var error='ingrese la '+a+' actividad <br>';
            $('.field-proyecto-actividad_objetivo2_'+(a-1)).addClass('has-error');
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
            $('.field-proyecto-actividad_objetivo2_'+(a-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo2_'+(a-1)).removeClass('has-error');
            
            $('#addr_2_'+a).html("<td>"+ (a+1) +"</td><td style='padding: 2px'><div class='form-group field-proyecto-actividad_objetivo2_"+a+" required' style='margin-top: 0px'><input placeholder='Actividad #"+(a+1)+"' id='proyecto-actividad_objetivo2_"+a+"' name='Proyecto[actividades_2][]' type='text' class='form-control'  /></div></td><td><span class='remCF glyphicon glyphicon-minus-sign'></span></td>");
            $('#tab_logic_2').append('<tr id="addr_2_'+(a+1)+'"></tr>');
            a++;
        }
        
        
        return true;
    });
    
    
    $("#add_row_3").click(function(){
        
        
        var objetivo=$('input[name=\'Proyecto[actividades_3][]\']').length;
        if (objetivo==5 && $('#proyecto-actividad_objetivo3_'+(e-1)).val()!='')
        {
            $.notify({
                message: 'No se puede agregar mas de 5' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            $('.field-proyecto-actividad_objetivo3_'+(e-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo3_'+(e-1)).removeClass('has-error');
            return false;
        }
        
        
        if($('#proyecto-actividad_objetivo3_'+(e-1)).val()=='')
        {
            var error='ingrese la '+e+' actividad <br>';
            $('.field-proyecto-actividad_objetivo3_'+(e-1)).addClass('has-error');
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
            $('.field-proyecto-actividad_objetivo3_'+(e-1)).addClass('has-success');
            $('.field-proyecto-actividad_objetivo3_'+(e-1)).removeClass('has-error');
            
            $('#addr_3_'+e).html("<td>"+ (e+1) +"</td><td style='padding: 2px'><div class='form-group field-proyecto-actividad_objetivo3_"+e+" required' style='margin-top: 0px'><input placeholder='Actividad #"+(e+1)+"' id='proyecto-actividad_objetivo3_"+e+"' name='Proyecto[actividades_3][]' type='text' class='form-control'  /></div></td><td><span class='remCF glyphicon glyphicon-minus-sign'></span></td>");
            $('#tab_logic_3').append('<tr id="addr_3_'+(e+1)+'"></tr>');
            e++;
        }
        
        
        return true;
    });
    /*
    $("#delete_row").click(function(){
        if(i>1){
            $("#addr"+(i-1)).html('');
            i--;
        }
    });*/
    
    
    $("#btn_objetivo_general").click(function(event){
        if ($('#proyecto-objetivo_general').val()=='') {
            $.notify({
                message: 'Ingrese el Objetivo General' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            $('.field-proyecto-objetivo_general').addClass('has-error');
            return false;
        }
        $('.field-proyecto-objetivo_general').css( 'color', 'black' );
        $("#txt_objetivo_general").html($('#proyecto-objetivo_general').val());
        
        return true;
    });
    
    $("#btn_objetivo_especifico_1").click(function(event){
        var error='';
        if ($('#proyecto-objetivo_especifico_1').val()=='') {
            error=error+' Ingrese el Objetivo N°1 <br>';
            $('.field-proyecto-objetivo_especifico_1').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_1').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_1').removeClass('has-error');
        }
        
        var objetivo1=$('input[name=\'Proyecto[actividades_1][]\']').length;
        for (var i=0; i<objetivo1; i++) {
            if($('#proyecto-actividad_objetivo1_'+i).val()=='')
            {
                error=error+'ingrese si quiera '+i+' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo1_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo1_'+i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo1_'+i).removeClass('has-error');
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
            $("#txt_objetivo_especifico_1").html($('#proyecto-objetivo_especifico_1').val());
            $('.field-proyecto-objetivo_especifico_1').css( 'color', 'black' );
            return true;
        }
        
    });
    
    $("#btn_objetivo_especifico_2").click(function(event){
        var error='';
        
        var objetivo2=$('input[name=\'Proyecto[actividades_2][]\']').length;
        for (var i=0; i<objetivo2; i++) {
            if($('#proyecto-actividad_objetivo2_'+i).val()=='')
            {
                error=error+'ingrese si quiera '+i+' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo2_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo2_'+i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo2_'+i).removeClass('has-error');
            }
        }
        
        if ($('#proyecto-objetivo_especifico_2').val()=='') {
            error=error+'Ingrese el Objetivo N° 2 <br>';
            $('.field-proyecto-objetivo_especifico_2').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_2').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_2').removeClass('has-error');
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
            $("#txt_objetivo_especifico_2").html($('#proyecto-objetivo_especifico_2').val());
            $('.field-proyecto-objetivo_especifico_2').css( 'color', 'black' );
            return true;
        }
    });
    
    $("#btn_objetivo_especifico_3").click(function(event){
        var error='';
        
        if ($('#proyecto-objetivo_especifico_3').val()=='') {
            error=error+'Ingrese el Objetivo N°3 <br>';
            $('.field-proyecto-objetivo_especifico_3').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-objetivo_especifico_3').addClass('has-success');
            $('.field-proyecto-objetivo_especifico_3').removeClass('has-error');
        }
            
        var objetivo3=$('input[name=\'Proyecto[actividades_3][]\']').length;
        for (var i=0; i<objetivo3; i++) {
            if($('#proyecto-actividad_objetivo3_'+i).val()=='')
            {
                error=error+'ingrese si quiera '+i+' objetivo especifico <br>';
                $('.field-proyecto-actividad_objetivo3_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-actividad_objetivo3_'+i).addClass('has-success');
                $('.field-proyecto-actividad_objetivo3_'+i).removeClass('has-error');
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
            $("#txt_objetivo_especifico_3").html($('#proyecto-objetivo_especifico_3').val());
            $('.field-proyecto-objetivo_especifico_3').css( 'color', 'black' );
            return true;
        }
    });
    
    $("#btnproyecto").click(function(event){
        var error='';
        var objetivo_especifico_1=$('input[name=\'Proyecto[objetivo_especifico_1]\']').length;
        var objetivo_especifico_2=$('input[name=\'Proyecto[objetivo_especifico_2]\']').length;
        var objetivo_especifico_3=$('input[name=\'Proyecto[objetivo_especifico_3]\']').length;
        var total=objetivo_especifico_1+objetivo_especifico_2+objetivo_especifico_3;
        /*
        if (total<2) {
            error=error+'ingrese 2 objetivos especificos como mínimo <br>';
        }
        */
        
        if($('#proyecto-titulo').val()=='')
        {
            error=error+'ingrese titulo del proyecto <br>';
            $('.field-proyecto-titulo').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-titulo').addClass('has-success');
            $('.field-proyecto-titulo').removeClass('has-error');
        }
        /*
        if($('#proyecto-resumen').val()=='')
        {
            error=error+'ingrese resumen del proyecto <br>';
            $('.field-proyecto-resumen').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-resumen').addClass('has-success');
            $('.field-proyecto-resumen').removeClass('has-error');
        }
        
        if($('#proyecto-beneficiario').val()=='')
        {
            error=error+'ingrese beneficiarios del proyecto <br>';
            $('.field-proyecto-beneficiario').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-beneficiario').addClass('has-success');
            $('.field-proyecto-beneficiario').removeClass('has-error');
        }
        */
        
        
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
    
    $('.numerico').keypress(function (e) {
		
	tecla = (document.all) ? e.keyCode : e.which; // 2
	if (tecla==8) return true; // 3
        var reg = /^[0-9\s]+$/;
        te = String.fromCharCode(tecla); // 5
	return reg.test(te); // 6
		
    });		
	
    var oe=1;
    var actividad=1;
    function agregarObjetivoActividad() {        
        
        
        var body="";
        var objetivo_especifico_1=$('input[name=\'Proyecto[objetivo_especifico_1]\']').length;
        var objetivo_especifico_2=$('input[name=\'Proyecto[objetivo_especifico_2]\']').length;
        var objetivo_especifico_3=$('input[name=\'Proyecto[objetivo_especifico_3]\']').length;
        var total=objetivo_especifico_1+objetivo_especifico_2+objetivo_especifico_3;
        if (total>=3) {
            $.notify({
                message: 'Solo se puede agregar 3 objetivos especificos'
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
        $('#objetivo_especifico_general').modal({backdrop: 'static', keyboard: false});
        actividad=1;
        
        body=   "<div id='objetivo'>"+
                    "<div class='col-xs-12 col-sm-12 col-md-12' style='margin-top:15px;'>"+
                        "<div class='form-group label-floating field-proyecto-temp_objetivo_especifico required' style='margin-top: 15px'>"+
                            "<label class='control-label' for='proyecto-temp_objetivo_especifico' >Objetivo </label>"+
                            "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_objetivo_especifico' class='form-control'>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
                "<div class='clearfix'></div>"+
                "<div class='col-xs-12 col-sm-12 col-md-12'><div style='padding-top:5px;border-top:2px dotted #f6de34'> Actividades <span class='glyphicon glyphicon-plus-sign' onclick='agregarActividad()' ></span></div></div>"+
               
                "<div id='actividades'></div>"+
                "<div class='clearfix'></div>";
        $("#oe_modal").html(body);
        //oe++;
        return true;
    }
    
    function agregarActividad() {
        
        var error='';
        //var temp_actividad=$("proyecto-temp_actividad_"+(actividad-1)).val();
        var temp_actividades=$('input[name=\'Proyecto[temp_actividades][]\']').length;
        for (var i=1; i<=temp_actividades; i++) {
            if(jQuery.trim($('#proyecto-temp_actividad_'+i).val())=='')
            {
                error=error+'Ingrese Actividad #'+i+' <br>';
                $('.field-proyecto-temp_actividad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-temp_actividad_'+i).addClass('has-success');
                $('.field-proyecto-temp_actividad_'+i).removeClass('has-error');
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
        
        var body="";
        body=   "<div class='col-xs-12 col-sm-11 col-md-11 pull-right' style='margin-top:15px;'>"+
                    "<div class='form-group label-floating field-proyecto-temp_actividad_"+actividad+" required' style='margin-top: 15px'>"+
                        "<label class='control-label' for='proyecto-temp_actividad_actividad_"+actividad+"' >Descripción de actividad #"+actividad+"</label>"+
                        "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_actividad_"+actividad+"' name='Proyecto[temp_actividades][]' class='form-control'>"+
                    "</div>"+
                "</div>";
        $("#actividades").append(body);
        actividad++;
        return true;
    }
    
    function MostrarOeActividades() {
        //console.log(oe);
        var oe_es_1=$('input[name=\'Proyecto[objetivo_especifico_1]\']').length;
        var oe_es_2=$('input[name=\'Proyecto[objetivo_especifico_2]\']').length;
        var oe_es_3=$('input[name=\'Proyecto[objetivo_especifico_3]\']').length; 
        var body="";
        var error='';
        var temp_objetivo_especifico=$("#proyecto-temp_objetivo_especifico").val();
        var temp_actividades=$('input[name=\'Proyecto[temp_actividades][]\']').length;
        var bodyactividades="";
        
        if (oe_es_1>0) {
            oe=2;
        }
        
        if (oe_es_2>0) {
            oe=3;
        }
        
        if(jQuery.trim(temp_objetivo_especifico)=='')
        {
            error=error+'Ingrese descripción en Objetivo <br>';
            $('.field-proyecto-temp_objetivo_especifico').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-temp_objetivo_especifico').addClass('has-success');
            $('.field-proyecto-temp_objetivo_especifico').removeClass('has-error');
        }
        
        if (temp_actividades==0) {
            error=error+'Ingrese 1 actividad como mínimo <br>';
        }
        
        for (var i=1; i<=temp_actividades; i++) {
            if(jQuery.trim($('#proyecto-temp_actividad_'+i).val())=='')
            {
                error=error+'Ingrese Actividad #'+i+' <br>';
                $('.field-proyecto-temp_actividad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-temp_actividad_'+i).addClass('has-success');
                $('.field-proyecto-temp_actividad_'+i).removeClass('has-error');
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
        
        
        $("#actividades input").each(function( index ) {
            bodyactividades=bodyactividades+"<li id='act'> Actividad: "+$( this ).val()+" <input type='hidden' value='"+$( this ).val()+"' name='Proyecto[actividades_"+oe+"][]'></li>";
        });
        
        
        
        var body=   "<div id='oe_"+oe+"' class='col-xs-12 col-sm-12 col-md-12'>"+
                            "<ul><li id='oespe'><b>Objetivo  Específico N°"+oe+": "+temp_objetivo_especifico+"</b> <span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar("+oe+")'></span></li>"+
                            "<input type='hidden' value='"+temp_objetivo_especifico+"' name='Proyecto[objetivo_especifico_"+oe+"]'>"+
                            "<ul>"+bodyactividades+"</ul><ul>"+
                    "</div>";
        $('#objetivo_especifico_general').modal('toggle');
        $("#mostrar_oe_actividades").append(body);
        oe++;
        actividad=1;
        return true;
        
    }
    
    
    function Editar(identificador) {
        $('#objetivo_especifico_general_copia').modal({backdrop: 'static', keyboard: false});
        //var objetivo_especifico="";
        var objetivo_especifico=$("input[name='Proyecto[objetivo_especifico_"+identificador+"]']").val();
        var bodyactividades="";
        var a=1;
        $("input[name='Proyecto[actividades_"+identificador+"][]']").each(function( index ) {
            bodyactividades=bodyactividades+"<div class='col-xs-12 col-sm-11 col-md-11 pull-right' style='margin-top:15px;'>"+
                                                "<div class='form-group label-floating field-proyecto-temp_actividad_"+a+" required' style='margin-top: 15px'>"+
                                                    "<label class='control-label' for='proyecto-temp_actividad_actividad_"+a+"'>Descripción de actividad #"+a+"</label>"+
                                                    "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_actividad_"+a+"' name='Proyecto[temp_actividades_copia][]' class='form-control' value='"+$(this).val()+"'>"+
                                                "</div>"+
                                            "</div>";
            a++;
        });
        
        
        body=   "<div id='objetivo_copia'>"+
                    "<div class='col-xs-12 col-sm-12 col-md-12'>"+
                        "<div class='form-group label-floating field-proyecto-temp_objetivo_especifico required' style='margin-top: 15px'>"+
                            "<label class='control-label' for='proyecto-temp_objetivo_especifico' >Objetivo </label>"+
                            "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_objetivo_especifico_"+identificador+"' class='form-control' value='"+objetivo_especifico+"'>"+
                        "</div>"+
                    "</div>"+
                "</div>"+
                "<div class='clearfix'></div>"+
                "<div class='col-xs-12 col-sm-12 col-md-12'>Actividades <span class='glyphicon glyphicon-plus-sign ' onclick='agregarActividadCopia()' ></span></div>"+
               
                "<div id='actividades_copia'>"+
                bodyactividades+
                "</div>"+
                "<div class='clearfix'></div>";
        $("#oe_modal_copia").html(body);
        $("#oe_modal_button").html('<div class="col-md-4"></div>'+
                                   '<div class="col-md-4"><button type="button" class="btn btn-default"  onclick="MostrarOeActividadesCopia('+identificador+')">Aceptar</button></div>');
        
        actividad=a;
        return true;
    }
    
    function MostrarOeActividadesCopia(identificador) {
        
        
        oe=identificador;
        
        
        var body="";
        var error='';
        var temp_objetivo_especifico=$("#proyecto-temp_objetivo_especifico_"+identificador+"").val();
        var temp_actividades=$('input[name=\'Proyecto[temp_actividades_copia][]\']').length;
        var bodyactividades="";
        if(jQuery.trim(temp_objetivo_especifico)=='')
        {
            error=error+'Ingrese descripción en Objetivo <br>';
            $('.field-proyecto-temp_objetivo_especifico').addClass('has-error');
        }
        else
        {
            $('.field-proyecto-temp_objetivo_especifico').addClass('has-success');
            $('.field-proyecto-temp_objetivo_especifico').removeClass('has-error');
        }
        
        if (temp_actividades==0) {
            error=error+'Ingrese 1 actividad como mínimo <br>';
        }
        
        for (var i=1; i<=temp_actividades; i++) {
            if(jQuery.trim($('#proyecto-temp_actividad_'+i).val())=='')
            {
                error=error+'Ingrese Actividad #'+i+' <br>';
                $('.field-proyecto-temp_actividad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-temp_actividad_'+i).addClass('has-success');
                $('.field-proyecto-temp_actividad_'+i).removeClass('has-error');
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
        
        
        $("#actividades_copia input").each(function( index ) {
            bodyactividades=bodyactividades+"<li id='act'>Actividad: "+$( this ).val()+" <input type='hidden' value='"+$( this ).val()+"' name='Proyecto[actividades_"+oe+"][]'></li>";
        });
        
        
        
        var body=   "<div id='oe_"+oe+"' class='col-xs-12 col-sm-12 col-md-12'>"+
                            "<ul><li id='oespe'><b>Objetivo  Específico N°"+oe+": "+temp_objetivo_especifico+"</b> <span class='glyphicon glyphicon-pencil' style='cursor: pointer' title='Haga clic para editar'  onclick='Editar("+oe+")'></span></li>"+
                            "<input type='hidden' value='"+temp_objetivo_especifico+"' name='Proyecto[objetivo_especifico_"+oe+"]'>"+
                            "<ul>"+bodyactividades+"</ul></ul>"+
                    "</div>";
        $('#objetivo_especifico_general_copia').modal('toggle');
        $("#oe_"+identificador+"").replaceWith(body);
        oe++;
        actividadcon=1;
        return true;
        
    }
    
    
    function agregarActividadCopia() {
        
        var error='';
        //var temp_actividad=$("proyecto-temp_actividad_"+(actividad-1)).val();
        var temp_actividades=$('input[name=\'Proyecto[temp_actividades_copia][]\']').length;
        for (var i=1; i<=temp_actividades; i++) {
            if(jQuery.trim($('#proyecto-temp_actividad_'+i).val())=='')
            {
                error=error+'Ingrese Actividad #'+i+' <br>';
                $('.field-proyecto-temp_actividad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-temp_actividad_'+i).addClass('has-success');
                $('.field-proyecto-temp_actividad_'+i).removeClass('has-error');
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
        
        var body="";
        body=   "<div class='col-xs-12 col-sm-11 col-md-11 pull-right' style='margin-top:15px;'>"+
                    "<div class='form-group label-floating field-proyecto-temp_actividad_"+actividad+" required' style='margin-top: 15px'>"+
                        "<label class='control-label' for='proyecto-temp_actividad_actividad_"+actividad+"' >Descripción de actividad #"+actividad+"</label>"+
                        "<input style='padding-bottom: 0px;padding-top: 0px;height: 30px;' type='text' id='proyecto-temp_actividad_"+actividad+"' name='Proyecto[temp_actividades_copia][]' class='form-control'>"+
                    "</div>"+
                "</div>";
        $("#actividades_copia").append(body);
        actividad++;
        return true;
    }
    
    function Documento(elemento) {
        var ext = $(elemento).val().split('.').pop().toLowerCase();
        var error='';
        if($.inArray(ext, ['docx','doc']) == -1) {
            error=error+'Solo se permite subir archivos con extensiones .docx,.doc';
        }
        if (error=='' && elemento.files[0].size/1024/1024>=5) {
            error=error+'Solo se permite archivos hasta 5 MB';
        }
        
        if (error!='') {
            $.notify({
                message: error
            },{
                // settings
                type: 'danger',
                z_index: 1000000,
                placement: {
                        from: 'bottom',
                        align: 'right'
                },
            });
            //fileupload = $('#equipo-foto_img');  
            //fileupload.replaceWith($fileupload.clone(true));
            $(elemento).replaceWith($(elemento).val('').clone(true));
            //$('#equipo-foto_img').val('');
            return false;
        }
        else
        {
            //mostrarImagen(this);
            return true;
        }
    }
</script>





