<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;

\Yii::$app->language = 'es-ES';



$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($pageSize * $_GET['page']) - $pageSize;
?>
<link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/font-awesome/font-awesome.min.css">

<link href="<?= \Yii::$app->request->BaseUrl ?>/ratings/dist/themes/fontawesome-stars.css" rel="stylesheet">
<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.12.0/jquery.min.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/ratings/dist/jquery.barrating.min.js"></script>
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
<section class="posts">
    <div class="post-title">
        <!--<h3><?= Yii::t('app', '{postCount} comentarios', ['postCount' => $postCount]) ?></h3>-->
    </div>
    <div id="post-list">

        <?php
//        echo $proyecto;
        $post_padre = [];
        $post_hijo = [];
        foreach ($posts as $pos)
        {

            if (empty($pos['foro_comentario_hijo_id']))
            {
                $post_padre[$pos['id']] = $pos;
            }
            else
            {
                $post_hijo[$pos['foro_comentario_hijo_id']][$pos['id']] = $pos;
            }
        }

        echo '<pre>';
//        print_r($post_padre);
//        print_r($post_hijo[9335]);
        echo '</pre>';


        foreach ($post_padre as $post)
        {

            $floor_number = $floor++;
             $id = intval($post['id']);
            ?>
            <div class="row post-item" id="dv_pri_<?= $id ?>">
                <div class="col-sm-12 col-md-12">
                    <?php
                    if ($post['user_id'] >= 2 and $post['user_id'] <= 8)
                    {
                        ?>
                        <div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #81F1FC">
                            <?= htmlentities(HtmlPurifier::process($post['contenido']), ENT_QUOTES) ?>
                            <div class="post-meta">
                                <div class="col-sm-12 col-md-12"></div>
                                <div class="clearfix"></div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="pull-right">
                                        <div class="col-sm-12 col-md-12">
                                            Comentario de <?= $post['nombres'] ?> <?= zdateRelative($post['creado_at']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1">
                            <?= htmlentities(HtmlPurifier::process($post['contenido']), ENT_QUOTES) ?>
                            <div class="post-meta">
                                <div class="col-sm-12 col-md-12"></div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="br-wrapper br-theme-fontawesome-stars pull-right">
                                        <select class="disabled" disabled> <!-- now hidden -->
                                            <option value></option>
                                            <option value="1" <?= ($post['valoracion'] == 1) ? 'selected' : '' ?> >1</option>
                                            <option value="2" <?= ($post['valoracion'] == 2) ? 'selected' : '' ?> >2</option>
                                            <option value="3" <?= ($post['valoracion'] == 3) ? 'selected' : '' ?> >3</option>
                                            <option value="4" <?= ($post['valoracion'] == 4) ? 'selected' : '' ?> >4</option>
                                            <option value="5" <?= ($post['valoracion'] == 5) ? 'selected' : '' ?> >5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="pull-left">
                                        <span style="cursor: pointer" onclick="Responder(<?= $post['id'] ?>)">Responder</span>
                                    </div>
                                    <div class="pull-right">
                                        Comentario de <?= $post['nombres'] . " " . $post['apellido_paterno'] ?> <?= zdateRelative($post['creado_at']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="clearfix"></div>

            <?php
           
            if (array_key_exists($id, $post_hijo))
            {
                ?>

                <?php
                foreach ($post_hijo[$id] as $p_hijo)
                {
                    ?>
                    <div class="row post-item">
                        <div class="col-sm-1 col-md-1"></div>
                        <div class="col-sm-11 col-md-11">
                            <?php
                            if ($p_hijo['user_id'] >= 2 and $p_hijo['user_id'] <= 8)
                            {
                                ?>
                                <div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #81F1FC">
                                    <?= htmlentities(HtmlPurifier::process($p_hijo['contenido']), ENT_QUOTES) ?>
                                    <div class="post-meta">
                                        <div class="col-sm-12 col-md-12"></div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="pull-right">
                                                <div class="col-sm-12 col-md-12">
                                                    Comentario de <?= $p_hijo['nombres'] ?> <?= zdateRelative($p_hijo['creado_at']) ?>
                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                <div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #F0EFF1">
                                    <?= htmlentities(HtmlPurifier::process($p_hijo['contenido']), ENT_QUOTES) ?>
                                    <div class="post-meta">
                                        <div class="col-sm-12 col-md-12"></div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="br-wrapper br-theme-fontawesome-stars pull-right">
                                                <select class="disabled" disabled> <!-- now hidden -->
                                                    <option value></option>
                                                    <option value="1" <?= ($p_hijo['valoracion'] == 1) ? 'selected' : '' ?> >1</option>
                                                    <option value="2" <?= ($p_hijo['valoracion'] == 2) ? 'selected' : '' ?> >2</option>
                                                    <option value="3" <?= ($p_hijo['valoracion'] == 3) ? 'selected' : '' ?> >3</option>
                                                    <option value="4" <?= ($p_hijo['valoracion'] == 4) ? 'selected' : '' ?> >4</option>
                                                    <option value="5" <?= ($p_hijo['valoracion'] == 5) ? 'selected' : '' ?> >5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="pull-right">
                                                Comentario de <?= $p_hijo['nombres'] . " " . $p_hijo['apellido_paterno'] ?> <?= zdateRelative($p_hijo['creado_at']) ?>
                                        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                <?php }
                ?>

                <?php
            }
            ?>
            <?php
        }
        ?>
        <div class="row post-item" align="center">
            <?=
            LinkPager::widget([
                'pagination' => $pages,
                'lastPageLabel' => true,
                'firstPageLabel' => true
            ]);
            ?>    
        </div>


    </div>
</section>

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
$comentarios = Yii::$app->getUrlManager()->createUrl('foro-comentario/comentario-monitor');
$insertarcomentarios = Yii::$app->getUrlManager()->createUrl('foro-comentario/insertar-comentario-monitor');
$insertarcomentarioshijos = Yii::$app->getUrlManager()->createUrl('foro-comentario/insertar-comentario-hijo-monitor');
$rating = Yii::$app->getUrlManager()->createUrl('panel/rating');

//    echo $insertarcomentarios;
?>
<script>

    function Responder(value) {
        $('#faltan_datos').show();
        $("#foro_comentario-hijo").val(value);
    }

    $(".popup .close_popup").on('click', function (e) {
        e.preventDefault();
        close_modal();
    });

    function close_modal() {
        var _popup = $(this).parents('.popup');
        _popup.hide();
    }

    $('#btncomentarhijo').click(function (event) {
      
        var error = "";
        $.ajax({
            url: '<?= $insertarcomentarioshijos ?>',
            type: 'POST',
            data: {id: <?= $proyecto ?>, padre: $("#foro_comentario-hijo").val(), contenido: $("#foro_comentario-contenido_hijo").val()},
            success: function (data) {
                close_modal();
                var texto = "";
                texto = '<div class="row post-item">' +
                        '<div class="col-sm-12 col-md-12">' +
                        '<div class="post-content" style="border: 2px solid #1f2a69;padding: 10px 5px 5px 10px;margin-top: 10px;margin-bottom: 3px;background: #4EB3C7">' +
                        '' + xescape($("#foro_comentario-contenido_hijo").val()) + '' +
                        '<div class="post-meta">' +
                        '<div class="col-sm-12 col-md-12"></div>' +
                        '<div class="col-sm-12 col-md-12">' +
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

                $('#hijo_' + $("#foro_comentario-hijo").val()).append(texto);
                $('.disabled').barrating({
                    theme: 'fontawesome-stars',
                    hoverState: false,
                    readonly: true
                });
                $("#foro_comentario-contenido_hijo").val("");
                $('#faltan_datos').hide();
            }
        });
        return true;
    });

    $('.disabled').barrating({
        theme: 'fontawesome-stars',
        hoverState: false,
        readonly: true
    });
</script>

