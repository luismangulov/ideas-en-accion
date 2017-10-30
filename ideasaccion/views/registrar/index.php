<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Ubigeo;
use yii\web\JsExpression;
use yii\widgets\Pjax;

$institucion = $_SESSION["institucion"];
$ubigeo = $_SESSION["ubigeo"];



$this->title = "Ideas en acción";
?>
<style>
    .img-responsive {
        max-width: 100%;
        height: auto;
        display: block;
    }
</style>

<link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/themes/base/jquery-ui.css">
<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.8.2/jquery-1.8.2.js"></script>

<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.8.24/jquery-ui.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/js/bootstrap-notify.js"></script>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form_login']]); ?>
<div class="title_form">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/title/registro.png" alt="" />
</div>
<div class="content_form">
    <div class="right_photo">
        <div class="txt_upload" style="bottom: 0px;">
            <div class=" form-group " style="padding-bottom: 0px;">
                <input  type="file" id="registrar-foto" class="form-control  file" name="Registrar[foto]" onchange="Imagen(this)"/>
                <img id="img_destino" class="text-center" src="<?= \Yii::$app->request->BaseUrl ?>/foto_personal/no_disponible.jpg"  style="height: 150px;width: 120px;align:center;cursor: pointer">                
                <span>Adjuntar foto </span>
            </div>
        </div> 
    </div>

    <div class="left"><h4 style="color: #1f2a69"><b>Datos personales</b></h4>

        <!--<div class="last_name">

            <div class="clear"></div>
            <div class="form-group label-floating field-registrar-sexo required left" style="margin-top: 15px">
                <label class="control-label" for="registrar-sexo">Sexo*</label>
                <select style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-sexo" class="form-control" name="Registrar[sexo]" required/>
                <option value=""></option>
                <option value="F">Femenino</option>
                <option value="M">Masculino</option>
                </select>
            </div>

        </div>-->

        <div class="row">

            <div class="col-md-6">
                <div class="form-group label-floating field-registrar-celular required" style="margin-top: 15px">
                    <label class="control-label" for="registrar-celular">Celular</label>
                    <input  style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="text" onpaste="return false;" onCopy="return false" id="registrar-celular" class="form-control numerico" name="Registrar[celular]" maxlength="9" >
                </div>
            </div>

            <!--
    <div class="col-md-6">
        <div class="form-group label-floating field-registrar-fecha_nac required" style="margin-top: 15px">
             <label class="control-label" for="registrar-fecha_nac">Fecha nacimiento*</label>   
            <input required  style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="text" id="registrar-fecha_nac" class="form-control"  name="Registrar[fecha_nac]" maxlength="10" >
        </div>
    </div>-->
        </div>        
    </div>
    <div class="clear"></div>


    <div class="clearfix"></div>
    <div class="line_separator"></div>
    <h4 style="color: #1f2a69"><b>Datos de tu institución educativa</b></h4>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group label-floating field-registrar-departamento required" style="margin-top: 15px">
                <label class="control-label" for="registrar-departamento">Región*</label>
                <select disabled style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-departamento" class="form-control" name="Registrar[departamento]" onchange='departamento($(this).val())' required>
                    <option value="<?= $ubigeo->department_id ?>" selected><?= $ubigeo->department ?></option>

                    <?php /* foreach (Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento) { ?>
                      <option value="<?= $departamento->department_id ?>"><?= $departamento->department ?></option>
                      <?php } */ ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group label-floating field-registrar-provincia required" style="margin-top: 15px">
                <label class="control-label" for="registrar-provincia">Provincia*</label>
                <select disabled  style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-provincia" class="form-control" name="Registrar[provincia]" onchange='provincia($(this).val())' required>
                    <option value="<?= $ubigeo->province_id ?>" selected ><?= $ubigeo->province ?></option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group label-floating field-registrar-distrito required " style="margin-top: 15px">
                <label class="control-label" for="registrar-distrito">Distrito*</label>
                <select disabled  style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-distrito" class="form-control" name="Registrar[distrito]" onchange='distrito($(this).val())' required>
                    <option value="<?= $ubigeo->district_id ?>" selected ><?= $ubigeo->district ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group label-floating field-registrar-institucion required" style="margin-top: 15px">
                <label class="control-label" for="registrar-institucion">Institución*</label>
                <select disabled  style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-institucion" class="form-control" name="Registrar[institucion]" required>
                    <option value="<?= $institucion->id ?>" selected ><?= $institucion->denominacion ?></option>
                </select>
            </div>
        </div>

        <?php if ($_SESSION["rol"] == "docente"): ?>
            <div class="col-md-6">
                <div class="form-group label-floating field-registrar-grado required" style="margin-top: 15px">
                    <label class="control-label" for="registrar-grado">Perfil*</label>
                    <select style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-grado" class="form-control" name="Registrar[grado]" required>
                        <option value="6">Docente</option>
                    </select>
                </div>
            </div>
        <?php endif; ?>	
        <?php if ($_SESSION["rol"] == "estudiante"): ?>
            <div class="col-md-6">
                <div class="form-group label-floating field-registrar-grado required" style="margin-top: 15px">
                    <label class="control-label" for="registrar-grado">Grado de estudios*</label>
                    <select style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-grado" class="form-control" name="Registrar[grado]" required>
                        <option value=""></option>
                        <option value="1">Primero</option>
                        <option value="2">Segundo</option>
                        <option value="3">Tercero</option>
                        <option value="4">Cuarto</option>
                        <option value="5">Quinto</option>
                    </select>
                </div>
            </div>	
        <?php endif; ?>	
    </div>
    <div class="form-group btn_registro_submit">
        <button type="button" id="registrar"  class="btn  btn-default" >
            Regístrate
        </button>
    </div>
    <div class="form-group btn_registro_submit">
        <button type="button" id="cerrar-sesion"  class="btn  btn-default" >
            Cerrar Sesión
        </button>
    </div>    
</div>
<div class="clearfix"></div>
<?php ActiveForm::end(); ?>

<?php
$validardni = Yii::$app->getUrlManager()->createUrl('registrar/validardni');
$validaremail = Yii::$app->getUrlManager()->createUrl('registrar/validaremail');
$provincias = Yii::$app->getUrlManager()->createUrl('ubigeo/provincias');
$distritos = Yii::$app->getUrlManager()->createUrl('ubigeo/distritos');
$instituciones = Yii::$app->getUrlManager()->createUrl('ubigeo/instituciones');
?>



<?php if (Yii::$app->session->hasFlash('error_file')): ?>

    <script>
        $.notify({
            // options
            message: 'El formato del archivo es inválido.'
        }, {
            // settings
            type: 'danger',
            z_index: 1000000,
            placement: {
                from: 'bottom',
                align: 'right'
            },
        });

    </script>

<?php endif; ?>


<?php if (Yii::$app->session->hasFlash('error_file_size')): ?>
    <script>
        $.notify({
            // options
            message: 'La imagen seleccionada debe ser menor a 1MB.'
        }, {
            // settings
            type: 'danger',
            z_index: 1000000,
            placement: {
                from: 'bottom',
                align: 'right'
            },
        });

    </script>
<?php endif; ?>


<?php if (Yii::$app->session->hasFlash('emailexistente')): ?>
    <script>
        $.notify({
            // options
            message: 'La dirección de correo ya ha sido registrada.'
        }, {
            // settings
            type: 'danger',
            z_index: 1000000,
            placement: {
                from: 'bottom',
                align: 'right'
            },
        });

    </script>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('dniexistente')): ?>
    <script>
        $.notify({
            // options
            message: 'El DNI ingresado ya ha sido registrado.'
        }, {
            // settings
            type: 'danger',
            z_index: 1000000,
            placement: {
                from: 'bottom',
                align: 'right'
            },
        });

    </script>
<?php endif; ?>


<script>
    $.datepicker.regional['es'] = {
        changeMonth: true,
        changeYear: true,
        /*gotoCurrent: false,*/
        closeText: 'Cerrar',
        prevText: 'Previo',
        nextText: 'Próximo',
        onChangeMonthYear: function(year, month, day) {
            //alert('hola');
            //$(this).datepicker('setDate', new Date(year, month - 1, day.selectedDay));
        }, onSelect: function(date) {

            // alert(date.getFullYear());;
            $(this).keyup();
        },
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        monthStatus: 'Ver otro mes',
        yearRange: '1950:2006',
        defaultDate: '01/01/1950',
        yearStatus: 'Ver otro año',
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        dateFormat: 'dd/mm/yy', firstDay: 0,
        initStatus: 'Selecciona la fecha', isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['es']);

    var $datepicker2 = $('#registrar-fecha_nac');
    $datepicker2.datepicker();
    //$datepicker.datepicker('defaultDate', new Date(1950, 1, 1, 0, 0, 0, 0));
    /*$(".ui-datepicker-year").val("1951");
     $(".ui-datepicker-year").val("1950");*/
//$datepicker.val('');







    $('#registrar-fecha_nac').change(function() {

        var fechita = $(this).val();
        //alert(fechita.indexOf("2017"));
        if (fechita.indexOf("2017") > -1) {
            $('#registrar-fecha_nac').val("");
        }
        /*if($(this).val()==''){
         $('#registrar-fecha_nac').parent().addClass('has-error');
         }else{
         
         $(this).keyup();
         // alert('hay contenido');
         }*/
    });


    function Imagen(elemento) {
        var ext = $(elemento).val().split('.').pop().toLowerCase();
        var error = '';

        if ($.inArray(ext, ['png', 'jpg']) == -1) {
            error = error + 'La imagen seleccionada debe estar en los formatos .JPG o .PNG';
        }
        if (error == '' && elemento.files[0].size / 1024 / 1024 >= 1) {
            error = error + 'La imagen seleccionada debe ser menor a 1MB';
        }

        if (error != '') {
            $.notify({
                message: error
            }, {
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
            //elemento.replaceWith(elemento.val('').clone(true));
            $('#registrar-foto').val('');
            //$('#img_destino').val('');
            $('#img_destino').attr('src', '<?= \Yii::$app->request->BaseUrl ?>/foto_personal/no_disponible.jpg');
            return false;
        }
        else
        {
            mostrarImagen(elemento);
            return true;
        }
    }

    function mostrarImagen(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img_destino').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    //$('#registrar-fecha_nac').bootstrapMaterialDatePicker({ weekStart : 0, time: false ,format : 'DD/MM/YYYY',lang : 'es' });

    /*
     $('#registrar-password').strengthMeter('progressBar', {
     
     container: $('#example-progress-bar-container'),
     
     });*/


    $('#cerrar-sesion').click(function() {
        self.location = '<?= \Yii::$app->request->BaseUrl ?>/login/logout';
    });

    $('#registrar').click(function() {
        var error = '';
        var p1 = $('input[name=\'Registrar[p1][]\']:checked').length;
        var p2 = $('input[type=radio]:checked').length;
        var p3 = $('input[name=\'Registrar[p3][]\']:checked').length;
        var p4 = $('input[name=\'Registrar[p4][]\']:checked').length;
        var p5 = $('input[name=\'Registrar[p5][]\']:checked').length;
        var p6 = $('input[name=\'Registrar[p6][]\']:checked').length;
        var ext = $('#registrar-foto').val().split('.').pop().toLowerCase();
        var conerror = 0;



        if ($('#registrar-sexo').val() == '') {
            error = error + 'Debes ingresar tú sexo <br>';

            $('#registrar-sexo').parent().addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            //  $('.field-registrar-sexo').addClass('has-success');
            //  $('.field-registrar-sexo').removeClass('has-error');
        }

        if ($('#registrar-fecha_nac').val() == '') {
            error = error + 'Debes ingresar tú fecha de nacimiento <br>';
            $('#registrar-fecha_nac').parent().addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            // $('.field-registrar-fecha_nac').addClass('has-success');
            //$('.field-registrar-fecha_nac').removeClass('has-error');
        }





        if ($('#registrar-departamento').val() == '') {
            error = error + 'Debes ingresar tú región <br>';
            $('#registrar-departamento').parent().addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            // $('.field-registrar-departamento').addClass('has-success');
            // $('.field-registrar-departamento').removeClass('has-error');
        }

        if ($('#registrar-provincia').val() == '') {
            error = error + 'Debes ingresar tú provincia <br>';
            $('#registrar-provincia').parent().addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            //   $('.field-registrar-provincia').addClass('has-success');
            //    $('.field-registrar-provincia').removeClass('has-error');
        }

        if ($('#registrar-distrito').val() == '') {
            error = error + 'Debes ingresar tú distrito <br>';
            $('#registrar-distrito').parent().addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            //   $('.field-registrar-distrito').addClass('has-success');
            //   $('.field-registrar-distrito').removeClass('has-error');
        }

        if ($('#registrar-institucion').val() == '') {
            error = error + 'Debes ingresar tú institución <br>';
            $('#registrar-institucion').parent().addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            // $('.field-registrar-institucion').addClass('has-success');
            // $('.field-registrar-institucion').removeClass('has-error');
        }

        if ($('#registrar-grado').val() == '') {
            error = error + 'Debes ingresar tú grado <br>';
            $('#registrar-grado').parent().addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            // $('.field-registrar-grado').addClass('has-success');
            //  $('.field-registrar-grado').removeClass('has-error');
        }





        if (conerror >= 1) {
            $.notify({
                message: 'Debes completar todos los campos marcados como obligatorios (*)'
            }, {
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }


        if (error != '')
        {
            $.notify({
                message: error
            }, {
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

            $(".form_login").submit();
        }

    });


    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }

    function distrito(value) {
        $.get("<?= $instituciones ?>?distrito=" + value, function(data) {
            $("#registrar-institucion").html(data);
        });
    }

    function provincia(value) {
        $.get("<?= $distritos ?>?provincia=" + value, function(data) {
            $("#registrar-distrito").html(data);
        });
        $("#registrar-distrito").find("option").remove().end().append("<option value></option>").val("");
        $("#registrar-institucion").find("option").remove().end().append("<option value></option>").val("");
    }

    function departamento(value) {
        $.get("<?= $provincias ?>?departamento=" + value, function(data) {
            $("#registrar-provincia").html(data);
        });
        $("#registrar-provincia").find("option").remove().end().append("<option value></option>").val("");
        $("#registrar-distrito").find("option").remove().end().append("<option value></option>").val("");
        $("#registrar-institucion").find("option").remove().end().append("<option value></option>").val("");
    }


    $('.numerico').keypress(function(e) {
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla == 8)
            return true; // 3
        var reg = /^[0-9\s]+$/;
        te = String.fromCharCode(tecla); // 5
        return reg.test(te); // 6

    });

    $('.texto').keypress(function(e) {
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla == 8)
            return true; // 3
        var reg = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ'_\s]+$/;
        te = String.fromCharCode(tecla); // 5
        return reg.test(te); // 6
    });


</script>