<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Ubigeo;
use yii\web\JsExpression;
use yii\widgets\Pjax;

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

<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_team_big.jpg" alt=""> Configuración
</div>  
<div class="registro">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form_login']]); ?>
    <div class="content_form">
        <div class="right_photo">
            <div class="txt_upload" style="bottom: 0px;">
                <div class=" form-group " style="padding-bottom: 0px;">
                    <input  type="file" id="registrar-foto" class="form-control  file" name="Registrar[foto]" onchange="Imagen(this)"/>
                    <?= Html::img('../foto_personal/' . $registrar->avatar . '', ['id' => 'img_destino', 'class' => 'text-center', 'style' => "height: 150px;width: 120px;align:center;cursor: pointer"]) ?>
                    <span>Actualizar foto </span>
                </div>
            </div>
        </div>
        <div class="left">
            <div class="form-group label-floating field-registrar-nombres required" style="margin-top: 15px">
                <label for="registrar-nombres" class="control-label">Nombres*</label>
                <input disabled style="padding-bottom: 0px;padding-top: 0px;height: 30px" type="text" onpaste="return false;" onCopy="return false" id="registrar-nombres" class="form-control texto" name="Registrar[nombres]" value="<?= $registrar->nombres ?>" required/>
            </div>
            <div class="last_name">
                <div class="form-group label-floating field-registrar-apellido_paterno required " style="margin-top: 15px">
                    <label class="control-label" for="registrar-apellido_paterno">Apellidos*</label>
                    <input disabled style="padding-bottom: 0px;padding-top: 0px;height: 30px;" type="text" onpaste="return false;" onCopy="return false" id="registrar-apellido_paterno" class="form-control texto" name="Registrar[apellido_paterno]" value="<?= $registrar->apellido_paterno ?>" required/>
                </div>

                <div class="clear"></div>
                <div class="form-group label-floating field-registrar-sexo required left" style="margin-top: 15px">
                    <label class="control-label" for="registrar-sexo">Sexo*</label>
                    <select disabled style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-sexo" class="form-control" name="Registrar[sexo]" required/>
                    <option value=""></option>
                    <option value="F" <?= ($registrar->sexo == "F") ? 'selected' : ''; ?> >Femenino</option>
                    <option value="M" <?= ($registrar->sexo == "M") ? 'selected' : ''; ?> >Masculino</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group label-floating field-registrar-celular " style="margin-top: 15px">
                    <label class="control-label" for="registrar-celular">Celular</label>
                    <input style="padding-bottom: 0px;padding-top: 0px;height: 30px;"  type="text" onpaste="return false;" onCopy="return false" id="registrar-celular" class="form-control numerico" name="Registrar[celular]" maxlength="9" value="<?= htmlentities($registrar->celular) ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group label-floating field-registrar-fecha_nac required has-error" style="margin-top: 15px">
                    <label class="control-label" for="registrar-fecha_nac">Fecha nacimiento*</label>

                    <input style="padding-bottom: 0px;padding-top: 0px;height: 30px;" disabled type="text" id="registrar-fecha_nac" class="form-control"  name="Registrar[fecha_nac]" maxlength="10" placeholder="Fecha nacimiento*" value="<?= $registrar->fecha_nac ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group field-registrar-departamento required" style="margin-top: 15px">
                    <label class="control-label" for="registrar-departamento">Región*</label>
                    <select disabled style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-departamento" class="form-control" name="Registrar[departamento]" onchange='departamento($(this).val())'>
                        <option value=""></option>
                        <option value="<?= $ubigeo->department_id ?>" selected><?= $ubigeo->department ?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group field-registrar-provincia required" style="margin-top: 15px">
                    <label class="control-label" for="registrar-provincia">Provincia*</label>
                    <select disabled style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-provincia" class="form-control" name="Registrar[provincia]" onchange='provincia($(this).val())'>
                        <option value=""></option>
                        <option value="<?= $ubigeo->province_id ?>" selected ><?= $ubigeo->province ?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group field-registrar-distrito required " style="margin-top: 15px">
                    <label class="control-label" for="registrar-distrito">Distrito*</label>
                    <select disabled style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-distrito" class="form-control" name="Registrar[distrito]" onchange='distrito($(this).val())'>
                        <option value=""></option>
                        <option value="<?= $ubigeo->district_id ?>" selected ><?= $ubigeo->district ?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group  field-registrar-institucion required"  style="margin-top: 15px">
                    <label class="control-label" for="registrar-institucion">Institución*</label>
                    <select disabled style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-institucion" class="form-control" name="Registrar[institucion]">
                        <option value=""></option>
                        <option value="<?= $institucion->id ?>" selected ><?= $institucion->denominacion ?></option>

                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group  field-registrar-grado required" style="margin-top: 15px">
                    <label class="control-label" for="registrar-grado">Grado de estudios*</label>
                    <?php if ($_SESSION["rol"] == "estudiante") { ?>

                        <select  style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-grado" class="form-control" name="Registrar[grado]">
                            <option value=""></option>
                            <option value="1" <?= ($registrar->grado == "1") ? 'selected' : ''; ?>>Primero</option>
                            <option value="2" <?= ($registrar->grado == "2") ? 'selected' : ''; ?>>Segundo</option>
                            <option value="3" <?= ($registrar->grado == "3") ? 'selected' : ''; ?>>Tercero</option>
                            <option value="4" <?= ($registrar->grado == "4") ? 'selected' : ''; ?>>Cuarto</option>
                            <option value="5" <?= ($registrar->grado == "5") ? 'selected' : ''; ?>>Quinto</option>
                        </select>
                    <?php } else { ?>	
                        <select  style="padding-bottom: 0px;padding-top: 0px;height: 30px;" id="registrar-grado" class="form-control" name="Registrar[grado]">
                            <option value=""></option>

                            <option value="6" <?= ($registrar->grado == "6") ? 'selected' : ''; ?>>Docente</option>
                        </select>
                    <?php } ?>	
                </div>
            </div>
        </div>
        <div class="form-group btn_registro_submit text-center">
            <button type="submit" id="registrar"  class="btn  btn-default" >
                Guardar
            </button>
        </div>
        <div class="form-group btn_registro_submit text-center">
            <div class="col-md-12">
                <?php /* Si deseas modificar tu correo, grado u otros datos envía un mensaje al correo electrónico <a href="mailto:ideasenaccion@minedu.gob.pe" target="_top">ideasenaccion@minedu.gob.pe</a> 

                 */ ?>
            </div> 
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>

    <?php ActiveForm::end(); ?>
</div>
<?php
$validardni = Yii::$app->getUrlManager()->createUrl('registrar/validardni');
$validaremail = Yii::$app->getUrlManager()->createUrl('registrar/validaremail');
$provincias = Yii::$app->getUrlManager()->createUrl('ubigeo/provincias');
$distritos = Yii::$app->getUrlManager()->createUrl('ubigeo/distritos');
$instituciones = Yii::$app->getUrlManager()->createUrl('ubigeo/instituciones');
?>

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
        closeText: 'Cerrar',
        prevText: 'Previo',
        nextText: 'Próximo',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        monthStatus: 'Ver otro mes',
        yearRange: '1950:2006',
        yearStatus: 'Ver otro año',
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        dateFormat: 'dd/mm/yy', firstDay: 0,
        initStatus: 'Selecciona la fecha', isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['es']);

    // $('#registrar-fecha_nac').datepicker();


    var imgtmp = '../foto_personal/' + '<?= $registrar->avatar ?>';

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
            $('#img_destino').attr('src', imgtmp);
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
            reader.onload = function (e) {
                $('#img_destino').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    //$('#registrar-fecha_nac').bootstrapMaterialDatePicker({ weekStart : 0, time: false ,format : 'DD/MM/YYYY',lang : 'es' });
    $('#registrar-password').focusout(function () {
        if ($(this).val() != '')
        {
            if ($(this).val().length < 8)
            {
                $.notify({
                    // options
                    message: 'La contraseña debe contener mínimo 8 caracteres'
                }, {
                    // settings
                    type: 'danger',
                    z_index: 1000000,
                    placement: {
                        from: 'bottom',
                        align: 'right'
                    },
                });
                $('.field-registrar-password').addClass('has-error');
            }
            else
            {
                $('.field-registrar-password').addClass('has-success');
                $('.field-registrar-password').removeClass('has-error');
            }
        }
    });
    /*
     $('#registrar-password').strengthMeter('progressBar', {
     
     container: $('#example-progress-bar-container'),
     
     });*/

    $('#registrar-dni').focusout(function () {
        if ($(this).val() != '')
        {
            if ($(this).val().length < 8)
            {
                $.notify({
                    // options
                    message: 'El DNI debe contener 8 caracteres'
                }, {
                    // settings
                    type: 'danger',
                    z_index: 1000000,
                    placement: {
                        from: 'bottom',
                        align: 'right'
                    },
                });
                $('.field-registrar-dni').addClass('has-error');
                $('#registrar-dni').val('');
                return false;
            }

            $.ajax({
                url: '<?= $validardni ?>',
                type: 'POST',
                async: true,
                data: {dni: $(this).val()},
                success: function (data) {
                    if (data == 1)
                    {
                        $('.field-registrar-dni').addClass('has-error');
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
                        $('#registrar-dni').val('');
                    }
                }
            });

        }
        return true;
    });


    $('#registrar-email').focusout(function () {
        if ($(this).val() != '')
        {

            $.ajax({
                url: '<?= $validaremail ?>',
                type: 'POST',
                async: true,
                data: {email: $(this).val()},
                success: function (data) {
                    if (data == 1)
                    {
                        $('.field-registrar-email').addClass('has-error');
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
                        $('#registrar-email').val('');
                    }
                }
            });

        }
        return true;
    });


    $('#registrar-repassword').focusout(function () {
        if ($('#registrar-repassword').val() != $('#registrar-password').val())
        {
            $('.field-registrar-repassword').addClass('has-error');
            $.notify({
                // options
                message: 'La contraseña no es idéntica'
            }, {
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
            $('.field-registrar-repassword').addClass('has-success');
            $('.field-registrar-repassword').removeClass('has-error');
            return true;
        }
    });





    $('#registrar').click(function () {
        
        var error = '';
        var p1 = $('input[name=\'Registrar[p1][]\']:checked').length;
        var p2 = $('input[type=radio]:checked').length;
        var p3 = $('input[name=\'Registrar[p3][]\']:checked').length;
        var p4 = $('input[name=\'Registrar[p4][]\']:checked').length;
        var p5 = $('input[name=\'Registrar[p5][]\']:checked').length;
        var p6 = $('input[name=\'Registrar[p6][]\']:checked').length;
        var ext = $('#registrar-foto').val().split('.').pop().toLowerCase();
        var conerror = 0;

        if ($('#registrar-nombres').val() == '') {
            error = error + 'Debes ingresar tú nombre completo <br>';
            $('.field-registrar-nombres').addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            $('.field-registrar-nombres').addClass('has-success');
            $('.field-registrar-nombres').removeClass('has-error');
        }

        if ($('#registrar-apellido_paterno').val() == '') {
            error = error + 'Debes ingresar tú apellido paterno <br>';
            $('.field-registrar-apellido_paterno').addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            $('.field-registrar-apellido_paterno').addClass('has-success');
            $('.field-registrar-apellido_paterno').removeClass('has-error');
        }

        if ($('#registrar-apellido_materno').val() == '') {
            error = error + 'Debes ingresar tú apellido materno <br>';
            $('.field-registrar-apellido_materno').addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            $('.field-registrar-apellido_materno').addClass('has-success');
            $('.field-registrar-apellido_materno').removeClass('has-error');
        }

        if ($('#registrar-sexo').val() == '') {
            error = error + 'Debes ingresar tú sexo <br>';
            $('.field-registrar-sexo').addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            $('.field-registrar-sexo').addClass('has-success');
            $('.field-registrar-sexo').removeClass('has-error');
        }

        if ($('#registrar-dni').val() == '') {
            error = error + 'Debes ingresar tú DNI <br>';
            $('.field-registrar-dni').addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            $('.field-registrar-dni').addClass('has-success');
            $('.field-registrar-dni').removeClass('has-error');
        }

        if ($('#registrar-fecha_nac').val() == '') {
            error = error + 'Debes ingresar tú fecha de nacimiento <br>';
            $('.field-registrar-fecha_nac').addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            $('.field-registrar-fecha_nac').addClass('has-success');
            $('.field-registrar-fecha_nac').removeClass('has-error');
        }

    


        if ($('#registrar-departamento').val() == '') {
            error = error + 'Debes ingresar tú región <br>';
            $('.field-registrar-departamento').addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            $('.field-registrar-departamento').addClass('has-success');
            $('.field-registrar-departamento').removeClass('has-error');
        }

        if ($('#registrar-provincia').val() == '') {
            error = error + 'Debes ingresar tú provincia <br>';
            $('.field-registrar-provincia').addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            $('.field-registrar-provincia').addClass('has-success');
            $('.field-registrar-provincia').removeClass('has-error');
        }

        if ($('#registrar-distrito').val() == '') {
            error = error + 'Debes ingresar tú distrito <br>';
            $('.field-registrar-distrito').addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            $('.field-registrar-distrito').addClass('has-success');
            $('.field-registrar-distrito').removeClass('has-error');
        }

        if ($('#registrar-institucion').val() == '') {
            error = error + 'Debes ingresar tú institución <br>';
            $('.field-registrar-institucion').addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            $('.field-registrar-institucion').addClass('has-success');
            $('.field-registrar-institucion').removeClass('has-error');
        }

        if ($('#registrar-grado').val() == '') {
            error = error + 'Debes ingresar tú grado <br>';
            $('.field-registrar-grado').addClass('has-error');
            conerror = conerror + 1;
        }
        else
        {
            $('.field-registrar-grado').addClass('has-success');
            $('.field-registrar-grado').removeClass('has-error');
        }


/*
        if ($('#registrar-password').val() != '' && $('#registrar-password').val().length < 8)
        {
            error = error + 'Tu contraseña debe contener un mínimo 8 caracteres <br>';
            $('.field-registrar-password').addClass('has-error');
        }

        if ($('#registrar-password').val() != '' && $('#registrar-repassword').val() && $('#registrar-password').val() != $('#registrar-repassword').val()) {
            error = error + 'Las contraseñas no son idénticas <br>';
            $('.field-registrar-password').addClass('has-error');
            $('.field-registrar-repassword').addClass('has-error');
        }

        var dni = $.ajax({
            url: '<?= $validardni ?>',
            type: 'POST',
            async: false,
            data: {dni: $('#registrar-dni').val()},
            success: function (data) {

            }
        });
        if (dni.responseText == '1') {
            error = error + 'El DNI ingresado ya ha sido registrado. <br>';
        }

        var email = $.ajax({
            url: '<?= $validaremail ?>',
            type: 'POST',
            async: false,
            data: {email: $('#registrar-email').val()},
            success: function (data) {

            }
        });
        if (email.responseText == '1') {
            error = error + 'La dirección de correo ya ha sido registrada. <br>';
        }
*/
        if (conerror >= 5) {
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
            return true;
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
        $.get("<?= $instituciones ?>?distrito=" + value, function (data) {
            $("#registrar-institucion").html(data);
        });
    }

    function provincia(value) {
        $.get("<?= $distritos ?>?provincia=" + value, function (data) {
            $("#registrar-distrito").html(data);
        });
        $("#registrar-distrito").find("option").remove().end().append("<option value></option>").val("");
        $("#registrar-institucion").find("option").remove().end().append("<option value></option>").val("");
    }

    function departamento(value) {
        $.get("<?= $provincias ?>?departamento=" + value, function (data) {
            $("#registrar-provincia").html(data);
        });
        $("#registrar-provincia").find("option").remove().end().append("<option value></option>").val("");
        $("#registrar-distrito").find("option").remove().end().append("<option value></option>").val("");
        $("#registrar-institucion").find("option").remove().end().append("<option value></option>").val("");
    }


    $('.numerico').keypress(function (tecla) {
        var reg = /^[0-9\s]+$/;
        if (!reg.test(String.fromCharCode(tecla.which))) {
            return false;
        }
        return true;
    });
    $('.texto').keypress(function (tecla) {
        var reg = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ'_\s]+$/;
        if (!reg.test(String.fromCharCode(tecla.which))) {
            return false;
        }
        return true;
    });
</script>

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


<?php if (Yii::$app->session->hasFlash('mensajesuccess')): ?>
    <script>
        $.notify({
            // options
            message: '<?= Yii::$app->session->getFlash("mensajesuccess") ?>'
        }, {
            // settings
            type: 'success',
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

<script type="text/javascript">

    $(document).ready(function () {

    });

</script>