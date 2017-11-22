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


<?php if (Yii::$app->session->hasFlash('mensajeerror')): ?>

    <script nonce="<?= getnonceideas() ?>" >
        $.notify({
            // options
            message: '<?= Yii::$app->session->getFlash('mensajeerror') ?>'
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

<?php if (Yii::$app->session->hasFlash('usuarioincorrecto')): ?>
    <script nonce="<?= getnonceideas() ?>" >
        $.notify({
            // options
            message: 'La dirección de correo o la contraseña son incorrectos.'
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

<?php if (Yii::$app->session->hasFlash('errorCaptcha')): ?>
    <script nonce="<?= getnonceideas() ?>" >
        $.notify({
            // options
            message: 'Código Captcha Incorrecto.'
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


<?php $form = ActiveForm::begin(['options' => ['class' => 'form_login', ]]); ?>
<div class="title_form">
    INGRESA A TU CUENTA
</div>
<div class="content_form">
    <div class="content_form">
        <div class="form-group label-floating field-loginform-username required" style="margin: 0px">
            <label class="control-label" for="loginform-username" >Correo electrónico</label>
            <input type="email" id="loginform-usernamex"  autocomplete="off" class="form-control" name="loginform-usernamex">
            <input type="hidden" id="loginform-username" autocomplete="off" class="form-control" name="LoginForm[username]">
        </div>
        <div class="form-group label-floating field-loginform-password required" style="margin: 0px">
            <label class="control-label text-left" for="loginform-password" style="text-align:left !important">Contraseña</label>
            <input type="password" id="loginform-passwordx" autocomplete="off" class="form-control" name="loginform-passwordx">
            <input type="hidden" id="loginform-password" autocomplete="off" class="form-control" name="LoginForm[password]">
        </div>
        <div class="form-group label-floating field-loginform-username required" style="margin: 0px">
            <label class="control-label" for="loginform-captcha" >Código Captcha</label>
            <input type="text" id="loginform-captcha" class="form-control numerico" maxlength="4" name="LoginForm[captcha]">
        </div>   
        <div class="form-group label-floating field-loginform-username required" style="margin: 0px">

            <img width="100%" src="<?= \Yii::$app->request->BaseUrl ?>/captcha.php" alt="">
        </div>              
        <div class="form-group" style="margin: 0px">
            <button id="ingresar" type="submit" class="btn btn-default">Ingresar</button>
        </div>
        <?php if ($tipo == 2 && $resultados) { ?>


            <div class="form-group no_apuntado text-center" style="margin: 0px">

                <u><?= Html::a('Regístrate en PerúEduca', Yii::$app->params["urlRegistro"], ['class' => '']); ?></u>
            </div>
            <div class="form-group olvide_contrasena text-center" style="margin: 0px">

                <u><?= Html::a('¿Olvidó su contraseña?', Yii::$app->params["urlOlvidecontrasena"], ['class' => '']); ?></u>

            </div>
        <?php } ?>
    </div>
</div>
<?php ActiveForm::end(); ?>



<script nonce="<?= getnonceideas() ?>"  type="text/javascript">
    $("#ingresar").click(function (event) {
        var error = '';
        if ($('#loginform-usernamex').val() == '')
        {
            error = error + 'Debes ingresar tu usuario <br>';
            $('.field-loginform-username').addClass('has-error');
        }
        else
        {
            $('.field-loginform-username').addClass('has-success');
            $('.field-loginform-username').removeClass('has-error');
        }



        if ($('#loginform-usernamex').val() != '' && !validateEmail($('#loginform-usernamex').val()))
        {
            error = error + 'Debes ingresar una dirección de correo válida <br>';
            $('.field-loginform-username').addClass('has-error');
        }


        if ($('#loginform-passwordx').val() == '')
        {
            error = error + 'Debes ingresar tu contraseña <br>';
            $('.field-loginform-password').addClass('has-error');
        }
        else
        {
            $('.field-loginform-password').addClass('has-success');
            $('.field-loginform-password').removeClass('has-error');
        }

        if ($('#loginform-captcha').val() == '')
        {
            error = error + 'Debes ingresar el código captcha <br>';
            $('.field-loginform-captcha').addClass('has-error');
        }
        else
        {
            $('.field-loginform-captcha').addClass('has-success');
            $('.field-loginform-captcha').removeClass('has-error');
        }

        if ($('#loginform-captcha').val().length != 4)
        {
            error = error + 'El código captcha de 4 dígitos <br>';
            $('.field-loginform-captcha').addClass('has-error');
        }
        else
        {
            $('.field-loginform-captcha').addClass('has-success');
            $('.field-loginform-captcha').removeClass('has-error');
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
        metodo();
        return true;
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

    $('.numerico').keypress(function (e) {
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla == 8)
            return true; // 3
        var reg = /^[0-9\s]+$/;
        te = String.fromCharCode(tecla); // 5
        return reg.test(te); // 6

    });
</script>


<script nonce="<?= getnonceideas() ?>"  type="text/javascript">
    var Base64 =
            {
                // private property
                _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
                // public method for encoding
                encode: function (input)
                {
                    var output = "";
                    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
                    var i = 0;

                    input = Base64._utf8_encode(input);

                    while (i < input.length) {

                        chr1 = input.charCodeAt(i++);
                        chr2 = input.charCodeAt(i++);
                        chr3 = input.charCodeAt(i++);

                        enc1 = chr1 >> 2;
                        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                        enc4 = chr3 & 63;

                        if (isNaN(chr2)) {
                            enc3 = enc4 = 64;
                        } else if (isNaN(chr3)) {
                            enc4 = 64;
                        }

                        output = output +
                                this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
                                this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

                    }

                    return output;
                },
                // public method for decoding
                decode: function (input)
                {
                    var output = "";
                    var chr1, chr2, chr3;
                    var enc1, enc2, enc3, enc4;
                    var i = 0;

                    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

                    while (i < input.length) {

                        enc1 = this._keyStr.indexOf(input.charAt(i++));
                        enc2 = this._keyStr.indexOf(input.charAt(i++));
                        enc3 = this._keyStr.indexOf(input.charAt(i++));
                        enc4 = this._keyStr.indexOf(input.charAt(i++));

                        chr1 = (enc1 << 2) | (enc2 >> 4);
                        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                        chr3 = ((enc3 & 3) << 6) | enc4;

                        output = output + String.fromCharCode(chr1);

                        if (enc3 != 64) {
                            output = output + String.fromCharCode(chr2);
                        }
                        if (enc4 != 64) {
                            output = output + String.fromCharCode(chr3);
                        }

                    }

                    output = Base64._utf8_decode(output);

                    return output;

                },
                // private method for UTF-8 encoding
                _utf8_encode: function (string)
                {
                    string = string.replace(/\r\n/g, "\n");
                    var utftext = "";

                    for (var n = 0; n < string.length; n++) {

                        var c = string.charCodeAt(n);

                        if (c < 128) {
                            utftext += String.fromCharCode(c);
                        }
                        else if ((c > 127) && (c < 2048)) {
                            utftext += String.fromCharCode((c >> 6) | 192);
                            utftext += String.fromCharCode((c & 63) | 128);
                        }
                        else {
                            utftext += String.fromCharCode((c >> 12) | 224);
                            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                            utftext += String.fromCharCode((c & 63) | 128);
                        }

                    }

                    return utftext;
                },
                // private method for UTF-8 decoding
                _utf8_decode: function (utftext)
                {
                    var string = "";
                    var i = 0;
                    var c = c1 = c2 = 0;

                    while (i < utftext.length) {

                        c = utftext.charCodeAt(i);

                        if (c < 128) {
                            string += String.fromCharCode(c);
                            i++;
                        }
                        else if ((c > 191) && (c < 224)) {
                            c2 = utftext.charCodeAt(i + 1);
                            string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                            i += 2;
                        }
                        else {
                            c2 = utftext.charCodeAt(i + 1);
                            c3 = utftext.charCodeAt(i + 2);
                            string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                            i += 3;
                        }

                    }

                    return string;

                }
            }


    function makeid() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 2; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }


    function metodo() {
//alert(Base64.encode("1234"));
        var cadena = $("#loginform-usernamex").val();
        var temp = "";

        for (i = 0; i < cadena.length; i++) {
            temp += cadena.charAt(i) + makeid();
        }
        //alert(temp.length);
        $("#loginform-usernamex").attr("disabled","disabled");
        $("#loginform-username").val(Base64.encode(temp));
        
        
        var cadena2 = $("#loginform-passwordx").val();
        var temp2 = "";

        for (i = 0; i < cadena2.length; i++) {
            temp2 += cadena2.charAt(i) + makeid();
        }
        //alert(temp.length);
        $("#loginform-passwordx").attr("disabled","disabled");
        $("#loginform-password").val(Base64.encode(temp2));        
        //alert($("#loginform-username").val());

        return true;
    }

</script>