<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\web\JsExpression;
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../bootstrap-strength-meter-master/docs/js/jquery-2.1.1.min.js"></script>
<script src="../bootstrap-strength-meter-master/docs/js/bootstrap-3.2.0.min.js"></script>
<script src="../bootstrap-strength-meter-master/docs/js/prettify.js"></script>
<script src="../bootstrap-strength-meter-master/dist/js/bootstrap-strength-meter.js"></script>

<script src="../bootstrap-strength-meter-master/password-score/password-score.js"></script>
<script src="../bootstrap-strength-meter-master/password-score/password-score-options.js"></script>
<br>
<div class="form_login" >
    <div class="title_form">Reestablece tu contraseña
    </div>
    <div class="content_form" >
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="form-group label-floating field-loginform-password ">
                        <label class="control-label" for="loginform-password">Nueva contraseña</label>
                        <input ng-model="loginform.password" type="password" onpaste="return false;" onCopy="return false" id="loginform-password" class="form-control" name="LoginForm[password]">
                    </div> 
                </div>
                <div class="clearfix"></div>
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="form-group label-floating field-loginform-repassword ">
                        <label class="control-label" for="loginform-repassword">Repetir nueva contraseña</label>
                        <input ng-model="loginform.repassword" type="password" onpaste="return false;" onCopy="return false" id="loginform-repassword" class="form-control" name="LoginForm[repassword]"  ng-focus="validarRecontrasena()">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="form-group btn_registro_submit">
                       <button id="ingresar" type="submit" class="btn btn-default">Cambiar</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php 
$validaremail= Yii::$app->getUrlManager()->createUrl('registrar/validaremail');
?>
<script>

    $("#ingresar").click(function(event){
        var error='';
        if ($("#loginform-password").val()=='') {
            error=error+"Debes ingresar tu contraseña <br>";
            $(".field-loginform-password").addClass("has-error");
        }
        else
        {
            $(".field-loginform-password").addClass("has-success");
            $(".field-loginform-password").removeClass("has-error");
        }
        
        if ($("#loginform-repassword").val()=='') {
            error=error+"Debes repetir tu contraseña <br>";
            $(".field-loginform-repassword").addClass("has-error");
        }
        else
        {
            $(".field-loginform-repassword").addClass("has-success");
            $(".field-loginform-repassword").removeClass("has-error");
        }
        
        if($("#loginform-password").val()!='' && $("#loginform-password").val().length<8){
                error=error+"Tu contraseña debe contener mínimo 8 caracteres <br>";
                $(".field-loginform-password").addClass("has-error");
            }
            
        if ($("#loginform-password").val()!='' && $("#loginform-repassword").val() && $("#loginform-password").val()!=$("#loginform-repassword").val()) {
            error=error+"Las contraseñas no son idénticas <br>";
            $(".field-loginform-password").addClass("has-error");
            $(".field-loginform-repassword").addClass("has-error");
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
            $.notify({
                message: 'Se ha cambiado tu contraseña correctamente' 
            },{
                type: 'success',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            
        }
        return true;
    });
    
    /*
    function submitForm() {
        document.getElementById("w0").submit()
    }
    */
    
    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }
    
    
    
    
    $( '#loginform-repassword' ).focusout(function() {
        if($('#loginform-repassword').val()!=$('#loginform-password').val())
        {
            $('.field-loginform-repassword').addClass('has-error');
            $.notify({
                // options
                message: 'La contraseña no es idéntica' 
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
            $('.field-loginform-repassword').addClass('has-success');
            $('.field-loginform-repassword').removeClass('has-error');
            return true;
        }
    });
    
    $('#loginform-password').strengthMeter('progressBar', {
        
            container: $('#example-progress-bar-container'),
            
    });
</script>