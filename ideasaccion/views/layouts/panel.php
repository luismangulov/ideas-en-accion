<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppEstandarAsset;
use app\models\Foro;
use app\models\Usuario;
use app\models\Integrante;
use app\models\Equipo;
use app\models\Proyecto;
use app\models\Etapa;
use app\models\Estudiante;
use app\models\VotacionPublica;
use app\models\Invitacion;

AppEstandarAsset::register($this);
if (!\Yii::$app->user->isGuest) {
    $msg = "No te olvides de hacer tu video de la primera actividad y aportar en los proyectos de tus compañeros.";
    $etapa2 = Etapa::find()->where('etapa=2 and estado=1')->one();
    $etapa3 = Etapa::find()->where('etapa=3 and estado=1')->one();
    $usuario = Usuario::find()->where('id=:id', [':id' => \Yii::$app->user->id])->one();
    $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();
    $votacionpublica = VotacionPublica::find()->all();
//$invitacion=Invitacion::find()->where('equipo_id=:equipo_id and estado=1',[':equipo_id'=>$equipo->id])->one();
    $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
    $foro_sinleer_string = "";
    $foro_sinleer = 0;
    $proyecto = null;
    if ($integrante) {
        $equipo = Equipo::find()->where('id=:id and estado=1', [':id' => $integrante->equipo_id])->one();
        if ($equipo) {

            $proyecto = Proyecto::find()->where('equipo_id=:equipo_id', [':equipo_id' => $equipo->id])->one();
            if ($etapa2) {
                $connectionx = Yii::$app->db;
                $commandx = $connectionx->createCommand("select count(a.id) as cantidad_sinleer from foro_comentario a inner join foro c on a.foro_id=c.id inner join proyecto b on c.proyecto_id=b.id where b.id=" . $proyecto->id . " AND  leido='0' group by a.foro_id");
                $rowx = $commandx->queryAll();

                if (!empty($rowx)) {
                    $foro_sinleer = $rowx[0]["cantidad_sinleer"];
                }
                if ($foro_sinleer > 0) {
                    
                    $foro_sinleer_string = " <span style='color:red'>(" . $foro_sinleer . " mensajes sin leer)</span> ";
                }
            }
        }

        if ($equipo && ($equipo->etapa == 0 or $equipo->etapa == NULL)) {
            $msg = "Gracias por tu esfuerzo, te invitamos a participar de los foros y seguir poniendo tus ideas en acción.";
        } elseif ($equipo && $equipo->etapa == 1) {
            $msg = "No te olvides de hacer tu video de la primera actividad y aportar en los proyectos de tus compañeros.";
        }
    } else {
        $msg = " ¡Qué esperas!  Recuerda que tienes hasta el 14 de agosto para inscribirte con tu equipo y poner sus… IDEAS EN ACCIÓN";
    }
    $foros = Foro::find()->orderBy('id DESC')->all();
    $images = ['gato_crema', 'perro_gris', 'colibri', 'mono'];
    $key = array_rand($images);
    $class = "";
    if ($key == 0) {
        $class = "";
    }
    if ($key == 1) {
        $class = "";
    }
    if ($key == 2) {
        $class = "";
    }
    if ($key == 3) {
        $class = "personaje_foros";
    }
    if ($key == 4) {
        $class = "personaje_entregas";
    }
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>

    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>">
            <meta name="viewport" content="width=device-width, initial-scale=0">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/util.js" type="text/javascript"></script>

            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/2.2.0/jquery.min.js" type="text/javascript"></script>
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/angularjs/1.5.5/angular.min.js"></script>

            <!-- Dropdown.js -->
            <link href="<?= \Yii::$app->request->BaseUrl ?>/css/master/jquery.dropdown.css" rel="stylesheet">

            <link href="<?= \Yii::$app->request->BaseUrl ?>/css/datetime/bootstrap-material-datetimepicker.css" rel="stylesheet">

            <!-- Page style -->
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">

            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.2.1/jquery.webui-popover.min.js"></script>
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/457.css" type="text/css">

            <!-- Page style -->
            <link href="<?= \Yii::$app->request->BaseUrl ?>/img/favicon.ico" rel="Shortcut Icon">

            <!-- Material Design fonts -->
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/css.css" type="text/css">
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/material-icons.css" type="text/css">


            <title><?= Html::encode($this->title) ?></title>
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/bootstrap.min.css" media="screen" charset="utf-8">

            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/bootstrap-notify.js"></script>
            <link href="<?= \Yii::$app->request->BaseUrl ?>/css/style.css" rel="stylesheet">
            <style>
                .alert.alert-danger
                {
                    background: #f44336;
                    color:rgba(255,255,255, 0.84);
                }
            </style>

            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-102582124-1', 'auto');
                ga('send', 'pageview');

            </script>               
            <?php $this->head() ?>
        </head>
        <body class="mi_equipo">
            <?php $this->beginBody() ?>
            <div class="personaje_derecha_fixed <?= $class ?>">
                <table cellpadding="0" cellspacing="0" border="0" align="right" class="text">
                    <tbody>
                        <tr>
                            <td>
                                <?= $msg ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <img src="<?= \Yii::$app->request->BaseUrl ?>/img/munecos/<?= $images[$key] ?>.png" class="" alt="">
            </div>
            <header>
                <div class="franja_amarilla"></div>
                <div class="content">
                    <a href="http://www.minedu.gob.pe/ideasenaccion/" class="logo">
                        <img src="<?= \Yii::$app->request->BaseUrl ?>/img/logo.jpg" alt="" />
                    </a>
                </div>
            </header>
            <div class="body content">
                <div class="form">
                    <div class="form_login">
                        <div class="content_form">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="grid_box_line_blue">
                                        <div class="box_head link_close">
                                            <b><?= Html::a('Cerrar sesión <b>X</b>', ['login/logout']); ?></b>
                                        </div>
                                        <div class="box_content">
                                            <div class="mis_datos">
                                                <div class="table_div">
                                                    <div class="row_div">
                                                        <div class="cell_div cell_image" style=" vertical-align: top;">
                                                            <div class="image_grupo" style="background-image: url(../foto_personal/<?= $usuario->avatar ?>);"></div>
                                                        </div>
                                                        <div class="cell_div cell_info">
                                                            <div class="cell_info_content">
                                                                <b class="uppercase"><?= Html::a("" . $usuario->estudiante->nombres . " " . $usuario->estudiante->apellido_paterno . " " . $usuario->estudiante->apellido_materno . "", ['usuario/configuracion']); ?> </b>
                                                            </div>
                                                            <div class="line_separator"></div>
                                                            <div class="cell_info_content">
                                                                <b>I.E: <?= $estudiante->institucion->denominacion ?></b>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table_div">
                                                    <div class="row_div">
                                                        <div class="cell_div cell_info">
                                                            <div class="line_separator"></div>
                                                            <div class="cell_info_content">
                                                                <b class="uppercase">Rol: <?= $_SESSION["rol"] ?></b>
                                                            </div>
                                                            <div class="line_separator"></div>
                                                            <div class="cell_info_content"><?php
                                                                $datex = new DateTime($_SESSION["ultimologin"]);
                                                                ?>
                                                                <b class="uppercase">Último acceso: <?= $datex->format('d/m/Y H:i:s') ?></b>
                                                            </div>

                                                            <div class="line_separator"></div>

                                                            <div class="cell_info_content">
                                                                <a href="<?= Yii::$app->params["urlOlvidecontrasena"] ?>" target="_blank"><b>Cambiar contraseña</b></a>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid_box_line_blue">
                                        <ul class="menu_lateral">
                                            <li>
                                                <?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_idea"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Ideas en acción <span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>', ['panel/ideas-accion'], []); ?>
                                            </li>
                                            <li>
                                                <?= Html::a('<div class="table_div">
                                                        <div class="row_div">
                                                                <div class="cell_div div_ia_icon">
                                                                        <span class="ia_icon ia_icon_team"></span>
                                                                </div>
                                                                <div class="cell_div">
                                                                        Mi equipo <span class="hide">></span>
                                                                </div>
                                                        </div>
                                                </div>', ['panel/index'], ['id' => 'lnk_miequipo']); ?>
                                            </li>
                                            <!--Mi proyecto-->
                                            <?php if ($integrante && $equipo && !$proyecto && $equipo->etapa == 0 && $integrante->rol == 1 && !$etapa2 && !$etapa3) { ?>
                                                <li>
                                                    <?= Html::a('<div class="table_div">
                                            <div class="row_div">
                                                <div class="cell_div div_ia_icon">
                                                    <span class="ia_icon ia_icon_project"></span>
                                                </div>
                                                <div class="cell_div">
                                                    Mi proyecto <span class="hide">></span>
                                                </div>
                                            </div>
                                        </div>', ['proyecto/index'], ['id' => 'lnk_proyecto']); ?>
                                                </li>
                                            <?php } elseif (($integrante && $equipo && $proyecto && $equipo->etapa == 0 && ($integrante->rol == 1 || $integrante->rol == 2) && !$etapa2 && !$etapa3)) { ?>
                                                <li>
                                                    <?= Html::a('<div class="table_div">
                                            <div class="row_div">
                                                <div class="cell_div div_ia_icon">
                                                    <span class="ia_icon ia_icon_project"></span>
                                                </div>
                                                <div class="cell_div">
                                                    Mi proyecto <span class="hide">></span>
                                                </div>
                                            </div>
                                        </div>', ['proyecto/actualizar'], ['id' => 'lnk_proyecto']); ?>
                                                </li>

                                            <?php } elseif (($integrante && $equipo && $proyecto && $equipo->etapa == 1 && ($integrante->rol == 1 || $integrante->rol == 2) && $etapa2)) { ?>
                                                <li>
                                                    <?= Html::a('<div class="table_div">
                                            <div class="row_div">
                                                <div class="cell_div div_ia_icon">
                                                    <span class="ia_icon ia_icon_project"></span>
                                                </div>
                                                <div class="cell_div">
                                                    Mi proyecto <span class="hide">></span>
                                                </div>
                                            </div>
                                        </div>', ['proyecto/actualizar'], ['id' => 'lnk_proyecto']); ?>
                                                </li>                                                
                                            <?php } ?>

                                            <!--Fin mi proyecto-->
                                            <!--Foro-->
                                            <?php if ($integrante && $equipo && $estudiante->grado != 6) { ?>
                                                <li>
                                                    <a href="#" class="sub_menu">
                                                        <div class="table_div">
                                                            <div class="row_div">
                                                                <div class="cell_div div_ia_icon">
                                                                    <span class="ia_icon ia_icon_foro"></span>
                                                                </div>
                                                                <div class="cell_div">
                                                                    Foros <span class="hide">></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <ul>
                                                        <?php foreach ($foros as $foro): ?>
                                                            <?php if ($foro->id == 2 || ($integrante && $foro->asunto_id == $equipo->asunto_id)) { ?>
                                                                <?php if ($foro->id == 2) { ?>
                                                                    <li><?= Html::a("Foro de participación estudiantil", ['foro/view', 'id' => $foro->id], []); ?></li>
                                                                <?php } elseif ($foro->asunto_id) { ?>
                                                                    <li><?= Html::a("Foro de asunto público", ['foro/view', 'id' => $foro->id], []); ?></li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <!--Fin Foro-->
                                            <?php if ($integrante && $equipo && $proyecto && ($integrante->rol == 1 || $integrante->rol == 2)) { ?>
                                                <?php if ($integrante && $equipo && $proyecto && ($equipo->etapa == 1 || $equipo->etapa == 2 || $equipo->etapa == 3)) { ?>
                                                    <li><?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_delivery"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Mi primera entrega' . $foro_sinleer_string . '<span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>', ['entrega/primera'], []); ?>
                                                    </li>
                                                <?php } ?>
                                                <?php if ($integrante && $equipo && $proyecto && ($equipo->etapa == 2 || $equipo->etapa == 3)) { ?>
                                                    <li><?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_delivery"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Mi segunda entrega <span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>', ['entrega/segunda'], []); ?>
                                                    </li>
                                                <?php } ?>

                                                <?php if ($integrante && $equipo && $proyecto && ($etapa2 || $etapa3) /* && ($equipo->etapa == 1 || $equipo->etapa == 2 ) */ && $estudiante->grado != 6) { ?>
                                                    <li><?= Html::a('<div class="table_div">
                                                  <div class="row_div">
                                                  <div class="cell_div div_ia_icon">
                                                  <span class="ia_icon ia_icon_delivery"></span>
                                                  </div>
                                                  <div class="cell_div">
                                                  Aporta a otros proyectos <span class="hide">></span>
                                                  </div>
                                                  </div>
                                                  </div>', ['proyecto/buscar'], ['id' => 'lnk_aporte']); ?>
                                                    </li>
                                                <?php } ?>

                                                <?php
                                               
                                                if (!$votacionpublica && $integrante && $equipo && $proyecto && $etapa3 && ($equipo->etapa == 2 || $equipo->etapa == 3) && $estudiante->grado != 6) {
                                                    
                                                    ?>
                                                    <li><?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_delivery"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Votación interna <span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>', ['proyecto/votacion'], ['style' => 'background:#f6de34;color:#1f2a69 !important']); ?>
                                                    </li>
                                                <?php } ?>

                                            <?php } ?>
                                        </ul>
                                    </div>

                                    <a href="#" data-toggle="modal" data-target="#myModalVideo" class="btn btn-default btn-lateral" style="line-height:20px !important">
                                        <span class="icon_play"> Video tutorial para hacer <br>proyectos</span>
                                    </a>

                                    <a href="http://www.minedu.gob.pe/ideasenaccion/pdf/orientaciones-slh.pdf" target="_blank" class="btn btn-default btn-lateral">
                                        <span class="icon_download"> GUÍA DE PROYECTO</span>
                                    </a>
                                    <a href="<?= \Yii::$app->request->BaseUrl ?>/esquema_rapido_del_proyecto.pdf" target="_blank" class="btn btn-default btn-lateral">
                                        <span class="icon_download"> Formato 2da entrega</span>
                                    </a>
                                    <!--
                                    <a href="#" class="btn btn-default btn-lateral">
                                        <span class="icon_download"> GUÍA PARA EL ESTUDIANTE</span>
                                    </a>-->
                                </div>

                                <div class="col-md-9">
                                    <div class="grid_box_line_blue">
                                        <?= $content ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Open source code -->
            <?php $this->endBody() ?>
            <script>
                $(".menu_lateral li a.sub_menu").on("click", function (e) {
                    e.preventDefault();
                    var _a = $(this);
                    var _li = _a.parent();

                    _a.toggleClass("active");
                    $("ul", _li).stop(true).slideToggle();
                });


                window.page = window.location.hash || "#about";
                $(document).ready(function () {
                    if (window.page != "#about") {
                        $(".menu").find("li[data-target=" + window.page + "]").trigger("click");
                    }
                });
                $(window).on("resize", function () {
                    $("html, body").height($(window).height());
                    $(".main, .menu").height($(window).height() - $(".header-panel").outerHeight());
                    $(".pages").height($(window).height());
                }).trigger("resize");
                $(".menu li").click(function () {
                    // Menu
                    if (!$(this).data("target"))
                        return;
                    if ($(this).is(".active"))
                        return;
                    $(".menu li").not($(this)).removeClass("active");
                    $(".page").not(page).removeClass("active").hide();
                    window.page = $(this).data("target");
                    var page = $(window.page);
                    window.location.hash = window.page;
                    $(this).addClass("active");
                    page.show();
                    var totop = setInterval(function () {
                        $(".pages").animate({scrollTop: 0}, 0);
                    }, 1);
                    setTimeout(function () {
                        page.addClass("active");
                        setTimeout(function () {
                            clearInterval(totop);
                        }, 1000);
                    }, 100);
                });
                function cleanSource(html) {
                    var lines = html.split(/\n/);
                    lines.shift();
                    lines.splice(-1, 1);
                    var indentSize = lines[0].length - lines[0].trim().length,
                            re = new RegExp(" {" + indentSize + "}");
                    lines = lines.map(function (line) {
                        if (line.match(re)) {
                            line = line.substring(indentSize);
                        }
                        return line;
                    });
                    lines = lines.join("\n");
                    return lines;
                }
                $("#opensource").click(function () {
                    $.get(window.location.href, function (data) {
                        var html = $(data).find(window.page).html();
                        html = cleanSource(html);
                        $("#source-modal pre").text(html);
                        $("#source-modal").modal();
                    });
                });
            </script>

            <!-- Twitter Bootstrap -->
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/3.3.6/bootstrap.min.js"></script>
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/bootbox.min.js"></script>
            <!-- Material Design for Bootstrap -->
            <script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/js/material.js"></script>
            <script src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/js/ripples.min.js"></script>
            <script>
                $.material.init();
            </script>


            <!-- Dropdown.js -->
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/master/jquery.dropdown.js"></script>
            <script>
                $("#dropdown-menu select").dropdown();
            </script>

        </body>
    </html>
    <?php $this->endPage() ?>
<?php } else { ?>
    <script>
        window.location.replace('../web/site/index')
    </script>
<?php } ?>

<div class="modal fade" id="myModalVideo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body ">
                <div class="embed-responsive embed-responsive-16by9">
                    <!--<iframe width="492" height="277" src="https://www.youtube.com/embed/qjS7HMqyfcg" frameborder="0" allowfullscreen></iframe>-->
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/oKzLuHSvCYU" frameborder="0" allowfullscreen></iframe>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $('#myModalVideo').on('hide.bs.modal', function (e) {
        var $if = $(e.delegateTarget).find('iframe');
        var src = $if.attr("src");
        $if.attr("src", '/empty.html');
        $if.attr("src", src);
    });
</script>
