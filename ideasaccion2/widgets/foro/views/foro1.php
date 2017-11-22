<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Foro */

$this->title = htmlentities($model->titulo, ENT_QUOTES);
$usuario = $model->usuario;
//$posts = $model->getPosts($model->id);
$posts = $model->getForo1Entrega($model->id, $seccion);
?>

<link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/font-awesome/font-awesome.min.css">
<link href="<?= \Yii::$app->request->BaseUrl ?>/ratings/dist/themes/fontawesome-stars.css" rel="stylesheet">
<script nonce="<?= getnonceideas() ?>" src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.12.0/jquery.min.js"></script>
<script nonce="<?= getnonceideas() ?>" src="<?= \Yii::$app->request->BaseUrl ?>/ratings/dist/jquery.barrating.min.js"></script>

<link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">

<script nonce="<?= getnonceideas() ?>" src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.2.1/jquery.webui-popover.min.js"></script>
<style>
    .pagination>li:first-child>a, .pagination>li:first-child>span
    {
        position:relative;
        float:left;
        padding:6px 12px;
        margin-left:-1px;
        line-height:1.42857143;
        text-decoration:none;
        border:1px solid black;
        color: white;
        background-color: #1f2a69;
    }
    .pagination>.disabled>a, .pagination>.disabled>a:focus, .pagination>.disabled>a:hover, .pagination>.disabled>span, .pagination>.disabled>span:focus, .pagination>.disabled>span:hover
    {
        position:relative;
        float:left;
        padding:6px 12px;
        margin-left:-1px;
        line-height:1.42857143;
        text-decoration:none;
        border:1px solid black;
        color: white;
        background-color: #1f2a69;
    }
    .pagination>li>a, .pagination>li>span
    {
        position:relative;
        float:left;
        padding:6px 12px;
        margin-left:-1px;
        line-height:1.42857143;
        text-decoration:none;
        border:1px solid black;
        color: white;
        background-color: #1f2a69;
    }
    .pagination>li>a:focus,
    .pagination>li>a:hover,
    .pagination>li>span:focus,
    .pagination>li>span:hover
    {
        color:white;
        background-color: #1f2a69;
        border:1px solid black;
    }
    .pagination>.active>a,
    .pagination>.active>a:focus,
    .pagination>.active>a:hover,
    .pagination>.active>span,
    .pagination>.active>span:focus,
    .pagination>.active>span:hover
    {
        border:1px solid black;
        background-color: #F0EFF1;
        color:#1f2a69;
    }
</style>

<?php
$form = ActiveForm::begin([
            'action' => ['proyecto', 'id' => $model->id],
            'method' => 'get',
        ]);
?>
<div class="md-col-6">
    <div class="form-group label-floating field-voto-region">
        <label>Sección</label>
        <select style="border: 2px solid #1f2a69;padding: 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="proyecto-seccion" name="Proyecto[seccion]" class="form-control" >
            <option value>Selecciona una sección para comentar el proyecto</option>
            <option value="1" <?= ($seccion == 1) ? 'selected' : '' ?>>Nombre del proyecto</option>
            <option value="2" <?= ($seccion == 2) ? 'selected' : '' ?>>Resumen del proyecto</option>
            <option value="3" <?= ($seccion == 3) ? 'selected' : '' ?>>Objetivo General</option>
            <option value="4" <?= ($seccion == 4) ? 'selected' : '' ?>>Objetivos y actividades</option>
            <option value="5" <?= ($seccion == 5) ? 'selected' : '' ?>>Cronograma y presupuesto</option>
        </select>
    </div>
</div>
<?php ActiveForm::end(); ?>
<!-- Post Form End -->
<div id="comentar" >

</div>
<div id="comentarios" >

</div>

<?php /* = $this->render('/foro/_posts1entrega', [
  'posts'=>$posts['posts'],
  'pageSize'=>$posts['pages']->pageSize, //??
  'pages' => $posts['pages'], //??
  'postCount' => $model->post_count //???
  ]);
  ?>

  <?= $this->render('/foro-comentario/_form1entrega',[
  'model'=>$newComentario,
  ]); */
?>
<div class="clearfix"></div>
<div class="form-group label-floating">
    <label class="control-label " for="foro_comentario-contenido" style="padding-left: 10px"> Ingrese comentario</label>
    <textarea style="border: 2px solid #1f2a69;padding: 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="foro_comentario-contenido" name="ForoComentario[contenido]" class="textarea form-control" style="width: 100%; height: 80px; font-size: 14px; line-height: 18px; padding: 10px; " ></textarea>
</div>
<div class="col-md-4 text-center">
    <button type="submit" id="btncomentar" class="btn btn-raised btn-default">Comentar</button>
</div>



<div class="popup" id="faltan_datos">
    <div class="popup_content">
        <a href="#" class="close_popup"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/vote_popup_close.png" alt=""></a>
        <form action="#" method="get">
            <div class="form-group label-floating">
                <label class="control-label " for="foro_comentario-contenido_hijo" style="padding-left: 10px"> Ingrese comentario</label>
                <textarea style="border: 2px solid #1f2a69;padding: 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1" id="foro_comentario-contenido_hijo" name="ForoComentario[contenido]" class="textarea form-control" style="width: 100%; height: 80px; font-size: 14px; line-height: 18px; padding: 10px; " ></textarea>
                <input type="hidden" id="foro_comentario-hijo">
            </div>
            <div class="col-md-6 text-center">
                <button type="button" id="btncomentarhijo" class="btn btn-raised btn-default">Comentar</button>
            </div>          
        </form>
    </div>
</div>


<?php
$comentarios = Yii::$app->getUrlManager()->createUrl('foro-comentario/comentario');
$insertarcomentarios = Yii::$app->getUrlManager()->createUrl('foro-comentario/insertar-comentario');
$insertarcomentarioshijos = Yii::$app->getUrlManager()->createUrl('foro-comentario/insertar-comentario-hijo');
?>


<script>
    $('.disabled').barrating({
        theme: 'fontawesome-stars',
        hoverState: false,
        readonly: true
    });

    $(document).ready(function($) {



        $("#proyecto-seccion").change(function() {
            $('#comentar').empty();
            $('#comentarios').empty();
            $.ajax({
                url: '<?= $comentarios ?>',
                type: 'POST',
                data: {id: "<?= $model->id ?>", seccion: $("#proyecto-seccion").val()},
                dataType: "html",
                success: function(data) {

                    $('#comentarios').append(data);
                    $('.disabled').barrating({
                        theme: 'fontawesome-stars',
                        hoverState: false,
                        readonly: true
                    });
                    $('.popover1').webuiPopover();
                }
            });
        });

        $('#btncomentar').click(function(event) {

            
            var error = "";

            if (jQuery.trim($("#foro_comentario-contenido").val()) == '') {
                error = error + "No ha comentado <br>";

            }


            if (jQuery.trim($("#proyecto-seccion").val()) == '') {
                error = error + "Seleccione un sección <br>";

            }

            if (error != "") {
                $.notify({
                    // options
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
                return false;
            }
            else
            {
                $.ajax({
                    url: '<?= $insertarcomentarios ?>',
                    type: 'POST',
                    data: {id: "<?= $model->id ?>", seccion: $("#proyecto-seccion").val(), contenido: $("#foro_comentario-contenido").val()},
                    success: function(data) {
                        //$("#foro_comentario-contenido").val("");


                        $.ajax({
                            url: '<?= $comentarios ?>',
                            type: 'POST',
                            data: {id: "<?= $model->id ?>", seccion: $("#proyecto-seccion").val()},
                            dataType: "html",
                            success: function(data) {

                                $('#comentar').empty();
                                $('#comentarios').empty();
                                $('#foro_comentario-contenido').val("");
                                $('#comentarios').append(data);
                                $('.disabled').barrating({
                                    theme: 'fontawesome-stars',
                                    hoverState: false,
                                    readonly: true
                                });
                                $('.popover1').webuiPopover();
                            }
                        });


                        /*
                         var texto="";
                         texto='<div class="row post-item">'+
                         '<div class="col-sm-12 col-md-12">'+
                         '<div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1">'+
                         ''+$("#foro_comentario-contenido").val()+''+
                         '<div class="post-meta">'+
                         '<div class="col-sm-12 col-md-12"></div>'+
                         '<div class="col-sm-12 col-md-12">'+
                         '<div class="br-wrapper br-theme-fontawesome-stars pull-right">'+
                         '<select class="disabled" disabled>'+
                         '<option value></option>'+
                         '<option value="1" >1</option>'+
                         '<option value="2" >2</option>'+
                         '<option value="3" >3</option>'+
                         '<option value="4" >4</option>'+
                         '<option value="5" >5</option>'+
                         '</select>'+
                         '</div>'+
                         '</div>'+
                         '<div class="clearfix"></div>'+
                         '<div class="col-sm-12 col-md-12">'+
                         '<div class="pull-right">'+
                         'Comentario de '+data+
                         '</div>'+
                         '</div>'+
                         '</div>'+
                         '<div class="clearfix"></div>'+
                         '</div>'+
                         '</div>'+
                         '</div>';
                         
                         $('#comentar').append(texto);
                         $('.disabled').barrating({
                         theme: 'fontawesome-stars',
                         hoverState: false,
                         readonly: true
                         });
                         $("#foro_comentario-contenido").val("");*/
                    }
                });

                return true;
            }


        });



        $('#btncomentarhijo').click(function(event) {
            var error = "";
            /*if (jQuery.trim($("#foro_comentario-contenido_hijo").val())=='') {
             error=error+"No ha comentado <br>"                
             }
             console.log("cesar");
             if (error!="") {
             /*$.notify({
             // options
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
             return false;
             }
             else
             {*/
            $.ajax({
                url: '<?= $insertarcomentarioshijos ?>',
                type: 'POST',
                data: {id: "<?= $model->id ?>", seccion: $("#proyecto-seccion").val(), padre: $("#foro_comentario-hijo").val(), contenido: $("#foro_comentario-contenido_hijo").val()},
                success: function(data) {
                    //$("#foro_comentario-contenido").val("");


                    $.ajax({
                        url: '<?= $comentarios ?>',
                        type: 'POST',
                        data: {id: "<?= $model->id ?>", seccion: $("#proyecto-seccion").val()},
                        dataType: "html",
                        success: function(data) {

                            $('#comentar').empty();
                            $('#comentarios').empty();
                            $('#foro_comentario-contenido').val("");
                            $('#comentarios').append(data);

                            $('.popover1').webuiPopover();



                            $('.disabled').barrating({
                                theme: 'fontawesome-stars',
                                hoverState: false,
                                readonly: true
                            });
                            $("#foro_comentario-contenido_hijo").val("");
                            $('#faltan_datos').hide();

                        }
                    });



                    /*
                     var texto = "";
                     texto = '<div class="row post-item">' +
                     '<div class="col-sm-12 col-md-12">' +
                     '<div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1">' +
                     '' + $("#foro_comentario-contenido_hijo").val() + '' +
                     '<div class="post-meta">' +
                     '<div class="col-sm-12 col-md-12"></div>' +
                     '<div class="col-sm-12 col-md-12">' +
                     '<div class="br-wrapper br-theme-fontawesome-stars pull-right">' +
                     '<select class="disabled" disabled>' +
                     '<option value></option>' +
                     '<option value="1" >1</option>' +
                     '<option value="2" >2</option>' +
                     '<option value="3" >3</option>' +
                     '<option value="4" >4</option>' +
                     '<option value="5" >5</option>' +
                     '</select>' +
                     '</div>' +
                     '</div>' +
                     '<div class="clearfix"></div>' +
                     '<div class="col-sm-12 col-md-12">' +
                     '<div class="pull-right">' +
                     'Comentario de ' + data +
                     '</div>' +
                     '</div>' +
                     '</div>' +
                     '<div class="clearfix"></div>' +
                     '</div>' +
                     '</div>' +
                     '</div>';
                     
                     $('#hijo_' + $("#foro_comentario-hijo").val()).append(texto);*/



                }
            });
            return true;
            //}
        });


    });

    function Responder(value) {
        $('#faltan_datos').show();
        $("#foro_comentario-hijo").val(value);
    }

    $(".popup .close_popup").on('click', function(e) {
        e.preventDefault();
        var _popup = $(this).parents('.popup');
        _popup.hide();
    });
    function Nube(usuario) {
        $(this).webuiPopover({title: 'Title', content: 'Content'});
    }
</script>

