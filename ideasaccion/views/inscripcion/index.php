<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Resultados;
use app\models\Asunto_categoria;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use app\models\Asunto;

$this->title = "Ideas en acción";

$equipoid = 0;
if ($equipo->id) {
    $equipoid = $equipo->id;
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        (function($) {
            $('#filtrar_nombres').bind("input keyup change cut paste", function() {
                if (jQuery.trim($(this).val()) != "") {
                    $('#filtrar_grado').val("");
                }
                var rex = new RegExp(jQuery.trim($(this).val()), 'i');
                $('.buscar tr').hide();
                $('.buscar tr').find('td:eq( 1 )').filter(function() {
                    // alert($(this).text() +" - "+ rex.test($(this).text()));
                    return rex.test($(this).text());
                }).parent().show();
            });

            $('#filtrar_grado').bind("input keyup change cut paste", function() {
                if (jQuery.trim($(this).val()) != "") {
                    $('#filtrar_nombres').val("");
                }
                var rex = new RegExp(jQuery.trim($(this).val()), 'i');
//$( "td:eq( 2 )" )
                $('.buscar tr').hide();
                $('.buscar tr').find('td:eq( 2 )').filter(function() {
                    // alert(rex.test($(this).text()) + $(this).text());
                    return rex.test($(this).text());

                }).parent().show();
            });

            $('#filtrar_nombres_docente').bind("input keyup change cut paste", function() {
                var rex = new RegExp(jQuery.trim($(this).val()), 'i');
                $('.buscar_docente tr').hide();
                $('.buscar_docente tr').find('td:eq( 1 )').filter(function() {
                    return rex.test($(this).text());
                }).parent().show();
            });
        }(jQuery));
    });
</script>

<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">MI EQUIPO
</div>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form_equipo']]); ?>
<div class="box_content contenido_seccion_crear_equipo">

    <div class="row">
        <div class="col-md-9">
            <div class="form-group label-floating field-equipo-descripcion_equipo required" >
                <label class="control-label" for="equipo-descripcion_equipo">Nombre del equipo</label>
                <input value="<?= htmlentities($equipo->descripcion_equipo) ?>" type="text" maxlength="250" id="equipo-descripcion_equipo" class="form-control texto" name="Equipo[descripcion_equipo]">
            </div>
            <div class="form-group label-floating field-equipo-descripcion required">
                <label class="control-label" for="equipo-descripcion">Danos una breve descripción de tu equipo</label>
                <textarea  id="equipo-descripcion" class="form-control" name="Equipo[descripcion]" cols="30" rows="3" maxlength="500"   ><?= htmlentities($equipo->descripcion) ?></textarea>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for=""> </label>
                <div class="imagen_equipo" style="border: 0px;">

                    <input type="file" id="equipo-foto_img" class="form-control file" name="Equipo[foto_img]" onchange="Imagen(this)">
                    <?php if (!empty($equipo->foto)) { ?>
                        <?= Html::img('../foto_equipo/' . $equipo->foto . '', ['id' => 'img_destino', 'class' => 'text-center', 'alt' => 'Agrega una imagen para tu equipo', 'style' => "vertical-align: middle;line-height: 160px;line-width: 150px;height: 160px;width: 150px;align:center;cursor: pointer"]) ?>
                    <?php } else { //= Html::img('',['id'=>'img_destino','class'=>'text-center', 'alt'=>'Agrega una imagen para tu equipo','style'=>"height: 160px;width: 150px;align:center;cursor: pointer"])  ?>
                        <img id='img_destino' src=""  style="vertical-align: middle;line-height: 160px;line-width: 150px;height: 160px;width: 150px;align:center;cursor: pointer" alt="Agrega una imagen para tu equipo">

                    <?php } ?>
                    <span>Actualizar foto </span>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">

            <div class="form-group label-floating field-equipo-asunto_id required" >
                <label class="control-label" for="equipo-asunto_categoria_id">Selecciona una Categoría de Asunto Público</label>
                <select id="equipo-asunto_categoria_id" class="form-control" name="Equipo[asunto_categoria]" onchange="TextoAsunto($(this).val())">
                    <option value=""></option>
                    <?php
                    $resultados = Asunto_categoria::find()->where('1=:region_id', ['region_id' => "1"])->all();
                    foreach ($resultados as $resultado) {

                        if (empty($equipo->id)) {
                            $categoria_id = "";
                        } else {
                            $categoria_id = $equipo->asunto->categoria_id;
                        }
                        if ($categoria_id == $resultado->id) {
                            echo "<option value='$resultado->id' selected='selected'>" . $resultado->descripcion_categoria . "</option>";
                        } else {
                            echo "<option value='$resultado->id'>" . $resultado->descripcion_categoria . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>


            <div class="form-group label-floating field-equipo-asunto_id required" >
                <label class="control-label" for="equipo-asunto_id">Selecciona el Asunto Público sobre el que trabajará tu equipo</label>
                <select id="equipo-asunto_id" class="form-control" name="Equipo[asunto_id]" >
                    <option value=""></option>
                    <?php
                    if (empty($equipo->id)) {
                        $categoria_id = "";
                    } else {
                        $categoria_id = $equipo->asunto->categoria_id;
                    }
                    $resultados = Asunto::find()->where('categoria_id=:categoria_id', ['categoria_id' => $categoria_id])->all();
                    if (!empty($resultados))
                        foreach ($resultados as $resultado) {
                            if ($equipo->asunto->id == $resultado->id) {
                                echo "<option value='$resultado->id' selected='selected'>" .  htmlentities($resultado->descripcion_cabecera, ENT_QUOTES) . "</option>";
                            } else {
                                echo "<option value='$resultado->id'>" .  htmlentities($resultado->descripcion_cabecera, ENT_QUOTES) . "</option>";
                            }
                        }



                    /*
                      $resultados = Resultados::find()->where('region_id=:region_id', ['region_id' => $institucion->department_id])->all();
                      foreach ($resultados as $resultado) {
                      if ($equipo->asunto_id == $resultado->asunto_id) {
                      echo "<option value='$resultado->asunto_id' selected='selected'>" . $resultado->asunto->descripcion_cabecera . "</option>";
                      } else {
                      echo "<option value='$resultado->asunto_id'>" . $resultado->asunto->descripcion_cabecera . "</option>";
                      }
                      } */
                    ?>
                </select>
            </div>

        </div>
        <div class="col-md-12">
            <div id="text_asunto" class="text-justify" style="display: none;border-bottom: 2px solid #1f2a69;color: #555"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Invita a los miembros de tu equipo:</label>
            </div>
        </div>
    </div>
    <div class="row tabla_crear_equipo">
        <div class="col-md-12">
            <table id="estudiantes" class="table table-bordered" >
                <thead>
                    <tr class="filtros">
                        <td width="6%"> </td>
                        <td width="60%" class="filtros">
                            <input id="filtrar_nombres" type="text"  placeholder="Filtro 01" class="">
                        </td>
                        <td width="34%" class="filtros">
                            <input id="filtrar_grado" type="text" placeholder="Filtro 02" class="">
                        </td>
                    </tr>
                    <tr class="cabecera_tabla">
                        <td> </td>
                        <td>Apellidos y Nombres</td>
                        <td align="center">Grados</td>


                    </tr>
                </thead>

                <tbody class="buscar">
                    <?php
                    $i = 1;
                    foreach ($estudiantes as $estudiante) {
                        echo "<tr>
                                    <td><div class='checkbox'><label><input name='Equipo[invitaciones][]' type='checkbox' value='$estudiante->id' onclick='validar($estudiante->id,$equipoid,$(this))'><span class='checkbox-material'></span></label></div></td>
                                    
                                    <td style='vertical-align:middle'>$estudiante->nombres $estudiante->apellido_paterno $estudiante->apellido_materno</td>
                                    <td align='center' style='vertical-align:middle'> " . $estudiante->getGrado() . "</td>
                                        
                            </tr>";

                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Invita a tu docente:</label>
            </div>
        </div>
    </div>
    <div class="row tabla_crear_equipo">
        <div class="col-md-12">
            <table id="docentes" class="table table-bordered" >
                <thead>
                    <tr class="filtros">
                        <td width="6%"> </td>
                        <td width="60%" class="filtros">
                            <input id="filtrar_nombres_docente" type="text"  placeholder="Filtro 01" class="">
                        </td>
                    </tr>
                    <tr class="cabecera_tabla">
                        <td> </td>
                        <td>Apellidos y Nombres</td>
                    </tr>
                </thead>

                <tbody class="buscar_docente">
                    <?php
                    $i = 1;
                    foreach ($docentes as $docente) {
                        echo "<tr>
                                    <td><div class='checkbox'><label><input name='Equipo[invitaciones_docente][]' type='checkbox' value='$docente->id' onclick='validardocente($docente->id,$equipoid,$(this))'><span class='checkbox-material'></span></label></div></td>
                                    
                                    <td style='vertical-align:middle'>$docente->nombres $docente->apellido_paterno $docente->apellido_materno</td>
                                    
                            </tr>";

                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-4">
            <button type="submit" id="btnequipo" class="btn btn-default"><?= $equipo->isNewRecord ? Yii::t('app', 'Crea tu equipo') : Yii::t('app', 'Actualizar') ?></button>
        </div>
        <div class="col-md-4">

        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>





<?php
//$validarintegrante= Yii::$app->getUrlManager()->createUrl('equipo/validarintegrante');
$validarinvitacioneintegrante = Yii::$app->getUrlManager()->createUrl('equipo/validarinvitacioneintegrante');
$validarinvitacioneintegrantedocente = Yii::$app->getUrlManager()->createUrl('equipo/validarinvitacioneintegrantedocente');
$validarinvitacioneintegrante2 = Yii::$app->getUrlManager()->createUrl('equipo/validarinvitacioneintegrante2');
$validarinvitacioneintegrante5 = Yii::$app->getUrlManager()->createUrl('equipo/validarinvitacioneintegrante5');
$validarintegrante2 = Yii::$app->getUrlManager()->createUrl('equipo/validarintegrante2');
$existeequipo = Yii::$app->getUrlManager()->createUrl('equipo/existeequipo');
$textoasunto = Yii::$app->getUrlManager()->createUrl('equipo/textoasunto');
$this->registerJs(
        "$('document').ready(function(){
        
        
        
    })");
?>

<script>


    function mostrarImagen(input) {
        if (input.files && input.files[0]) {
            //$(this).parent().css("background", "url(/images/r-srchbg_white.png) no-repeat");

            var reader = new FileReader();
            reader.onload = function(e) {
                //$('#img_destino').css("background", e.target.result);
                $('#img_destino').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function Imagen(elemento) {
        var ext = $(elemento).val().split('.').pop().toLowerCase();
        var error = '';
        if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
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
            $('#equipo-foto_img').val("");
               var equipofoto = '<?=$equipo->foto?>';
               var imagen="";
               if(equipofoto == ""){
                   equipofoto="no_disponible.png";
                   imagen="";
               }else{
                   imagen="../foto_equipo/"+equipofoto;
               }
                   
            $('#img_destino').attr('src',imagen);
            //$('#img_destino').attr('src', '../foto_equipo/no_disponible.jpg');

            return false;
        }
        else
        {

            mostrarImagen(elemento);
            return true;
        }
    }

    var contador =<?= $invitacionContador ?>;

    var equipo =<?= $invitacionContador ?>;

    var contadordocente =<?= $invitacionContadorDocente ?>;

    var equipodocente =<?= $invitacionContadorDocente ?>;

    function mostrarErrorN(mensaje) {

        $.notify({
            message: mensaje
        }, {
            type: 'danger',
            z_index: 1000000,
            placement: {
                from: 'bottom',
                align: 'right'
            },
        });
    }


    $('#btnequipo').click(function(event) {
        $(this).attr("disabled", "disabled");
        var error = '';
        var bandera = true;
        if ($('#equipo-descripcion_equipo').val() == '')
        {
            error = error + 'Debes ingresar el nombre del equipo <br>';
            mostrarErrorN(error);
            $(this).removeAttr("disabled");
            return false;
        }

        if ($('#equipo-descripcion').val() == '')
        {
            error = error + 'Debes ingresar la descripción del proyecto <br>';
            mostrarErrorN(error);
            $(this).removeAttr("disabled");
            return false;
        }

        if ($('#equipo-asunto_id').val() == '')
        {
            error = error + 'Debes ingresar el Asunto público <br>';
            mostrarErrorN(error);
            $(this).removeAttr("disabled");
            return false;
        }



        var equipoid =<?= $equipoid ?>;

        if (equipoid == 0)
        {
            var existeequipo = $.ajax({
                url: '<?= $existeequipo ?>',
                type: 'GET',
                //data: {},
                success: function(data) {


                    if (data == 1) {

                        error = error + 'Ya tienes un equipo creado.';
                        mostrarErrorN(error);
                        $(this).removeAttr("disabled");
                        return false;
                        /* $.notify({
                         // options
                         message: 'Ya tienes un equipo creado.'
                         }, {
                         // settings
                         type: 'danger',
                         z_index: 1000000,
                         placement: {
                         from: 'bottom',
                         align: 'right'
                         }
                         });
                         setTimeout(function() {
                         window.location.reload(1);
                         }, 1);
                         $(this).removeAttr("disabled");*/

                    } else {


                        var estudiantes = $('input[name="Equipo[invitaciones][]"]:checked').map(function() {
                            return this.value;
                        }).get();

                        $.ajax({
                            url: '<?= $validarinvitacioneintegrante2 ?>',
                            type: 'GET',
                            data: {'Equipo[invitaciones][]': estudiantes, 'Equipo[id]':<?= $equipoid ?>, 'Equipo[tipo]': 1},
                            success: function(datam) {
                                if (datam.bandera == 1) {
                                    error = datam.error;
                                    mostrarErrorN(error);
                                    $(this).removeAttr("disabled");
                                    return false;
                                }
                                else {

                                    $(".form_equipo").submit();
                                }
                            }
                        });


                    }


                }});
        }
        else
        {
            var estudiantes = $('input[name="Equipo[invitaciones][]"]:checked').map(function() {
                return this.value;
            }).get();
            $.ajax({
                url: '<?= $validarinvitacioneintegrante2 ?>',
                type: 'GET',
                data: {'Equipo[invitaciones][]': estudiantes, 'Equipo[id]':<?= $equipoid ?>, 'Equipo[tipo]': 1},
                success: function(datam) {
                    if (datam.bandera == 1) {
                        error = datam.error;
                        mostrarErrorN(error);
                        $(this).removeAttr("disabled");
                        return false;
                    }
                    else {

                        $(".form_equipo").submit();
                    }
                }
            });

        }


        //$(".form_equipo").submit();
        //return true;
    });
    function validar(estudiante, equipo, elemento)
    {
        var invitaciones = ($('input[name=\'Equipo[invitaciones][]\']:checked').length) + contador;
        if (invitaciones > 6) {
            elemento.prop("checked", false);
            $.notify({
                // options
                message: 'Solo puedes invitar a 5 compañeros como máximo.'
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

        $.ajax({
            url: '<?= $validarinvitacioneintegrante ?>',
            type: 'GET',
            async: true,
            data: {estudiante: estudiante, equipo: equipo},
            success: function(data) {
                if (data == 1)
                {
                    $.notify({
                        // options
                        message: 'Tu compañero ya pertenece a otro equipo. '
                    }, {
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                    });
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1000);
                }
                else if (data == 2)
                {
                    $.notify({
                        // options
                        message: 'Ya le has enviado una invitación.'
                    }, {
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                    });
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1000);
                }
                else if (data == 3)
                {
                    $.notify({
                        // options
                        message: 'Solo puedes invitar a 5 compañeros como máximo.'
                    }, {
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                    });
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1000);
                }
                return false;
            }
        });
        return true;
    }



    function validardocente(docente, equipo, elemento)
    {
        var invitaciones = ($('input[name=\'Equipo[invitaciones_docente][]\']:checked').length) + contadordocente;
        if (invitaciones >= 2) {
            elemento.prop("checked", false);
            $.notify({
                // options
                message: 'Solo puedes invitar a 1 docente como máximo.'
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

        $.ajax({
            url: '<?= $validarinvitacioneintegrantedocente ?>',
            type: 'GET',
            async: true,
            data: {docente: docente, equipo: equipo},
            success: function(data) {
                if (data == 1)
                {
                    $.notify({
                        // options
                        message: 'Ya pertenece a un equipo.'
                    }, {
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                    });
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1000);
                }
                else if (data == 2)
                {
                    $.notify({
                        // options
                        message: 'Ya le has enviado una invitación '
                    }, {
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                    });
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1000);
                }
                else if (data == 3)
                {
                    $.notify({
                        // options
                        message: 'Solo puedes invitar a 1 docente como máximo.'
                    }, {
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                    });
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1000);
                }
                return false;
            }
        });
        return true;
    }

    function TextoAsunto(value) {
        $("#equipo-asunto_id").html('<option value=""></option>');
        if (value == '') {
            $("#text_asunto").hide();
        }
        $.ajax({
            url: '<?= $textoasunto ?>',
            type: 'GET',
            dataType: "json",
            async: true,
            data: {asunto_id: value},
            success: function(data) {
                //$("#equipo-asunto_id").html("");


                for (i = 0; i < data.length; i++) {
                    //alert(data[i].id);
                    $("#equipo-asunto_id").append("<option value='" + data[i].id + "'>" + xescape(data[i].descripcion_corta) + "</option>");
                }
                //alert(data.length);
                /*$("#text_asunto").html(data);
                 $("#text_asunto").show();*/
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
<?php if (Yii::$app->session->hasFlash('error_file')): ?>


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
<?php endif; ?>


<?php if (Yii::$app->session->hasFlash('error_file_size')): ?>

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
<?php endif; ?>
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
// Handler for .ready() called.

        $("#lnk_miequipo").attr("class", "active");
    });



</script>