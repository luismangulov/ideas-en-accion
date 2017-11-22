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
use app\models\Invitacion;

AppEstandarAsset::register($this);
if (!\Yii::$app->user->isGuest) {
    $etapa2 = Etapa::find()->where('etapa=2 and estado=1')->one();
    $etapa3 = Etapa::find()->where('etapa=3 and estado=1')->one();
    $usuario = Usuario::find()->where('id=:id', [':id' => \Yii::$app->user->id])->one();
    $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();
//$invitacion=Invitacion::find()->where('equipo_id=:equipo_id and estado=1',[':equipo_id'=>$equipo->id])->one();
    $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
    if ($integrante) {
        $equipo = Equipo::find()->where('id=:id and estado=1', [':id' => $integrante->equipo_id])->one();
        if ($equipo) {

            $proyecto = Proyecto::find()->where('equipo_id=:equipo_id', [':equipo_id' => $equipo->id])->one();
        }
    }
    $foros = Foro::find()->orderBy('id DESC')->all();
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>

        <!--<script nonce="<?= getnonceideas() ?>"  src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>-->
            <script nonce="<?= getnonceideas() ?>"  src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/2.2.0/jquery.min.js" type="text/javascript"></script>
            <script nonce="<?= getnonceideas() ?>"  src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/angularjs/1.5.5/angular.min.js"></script>
            <!-- Material Design fonts -->
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/css.css" type="text/css">

            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/material-icons.css" type="text/css">

            <title><?= Html::encode($this->title) ?></title>
            <!-- Bootstrap -->
            <link href="<?= \Yii::$app->request->BaseUrl ?>/css/bootstrap/bootstrap.min.css" rel="stylesheet">


            <link href="<?= \Yii::$app->request->BaseUrl ?>/css/datetime/bootstrap-material-datetimepicker.css" rel="stylesheet">

            <!-- Bootstrap Material Design -->
            <link href="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/css/bootstrap-material-design.css" rel="stylesheet">
            <link href="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/css/ripples.min.css" rel="stylesheet">

            <!-- Dropdown.js -->
            <link href="<?= \Yii::$app->request->BaseUrl ?>/css/master/jquery.dropdown.css" rel="stylesheet">

            <!-- Page style -->
            <link href="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/index.css" rel="stylesheet">
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">

            <script nonce="<?= getnonceideas() ?>"  src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.2.1/jquery.webui-popover.min.js"></script>

            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/457.css" type="text/css">

            <link href="<?= \Yii::$app->request->BaseUrl ?>/css/style.css" rel="stylesheet">
            <?php $this->head() ?>
        </head>
        <body class="mi_equipo">
            <?php $this->beginBody() ?>
            <img src="../img/personaje_derecha_mi_equipo.png" class="personaje_derecha_fixed" alt="" />
            <header>
                <div class="franja_amarilla"></div>
                <div class="content">
                    <a href="#" class="logo">
                        <img src="../img/logo.jpg" alt="" />
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
                                            <?= Html::a('Cerrar sesión <b>X</b>', ['login/logout']); ?>
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
                                                </div>', ['panel/index'], []); ?>
                                            </li>
                                            <!--Mi proyecto-->
                                            <?php if ($integrante && $equipo && !$proyecto && $integrante->rol == 1) { ?>
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
                                        </div>', ['proyecto/index'], []); ?>
                                                </li>
                                            <?php } elseif ($integrante && $equipo && $proyecto && ($integrante->rol == 1 || $integrante->rol == 2)) { ?>
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
                                        </div>', ['proyecto/actualizar'], []); ?>
                                                </li>
                                            <?php } ?>
                                            <!--Fin mi proyecto-->
                                            <!--Foro-->
                                            <?php if ($integrante && $equipo && $estudiante->grado != 6) { ?>
                                                <li>
                                                    <a href="#">
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
                                                    <ul class="treeview-menu">
                                                        <?php foreach ($foros as $foro): ?>
                                                            <?php if ($foro->id == 2 || ($integrante && $foro->asunto_id == $equipo->asunto_id)) { ?>
                                                                <?php if ($foro->id == 2) { ?>
                                                                    <li><?= Html::a("Foro de participación estudiantil", ['foro/view', 'id' => $foro->id], []); ?></li>
                                                                <?php } else { ?>
                                                                    <li><?= Html::a("Foro de asunto público", ['foro/view', 'id' => $foro->id], []); ?></li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <!--Fin Foro-->
                                            <?php if ($integrante && $equipo && $proyecto && ($integrante->rol == 1 || $integrante->rol == 2) && $estudiante->grado != 6) { ?>
                                                <?php if ($integrante && $equipo && $proyecto && ($equipo->etapa == 1 || $equipo->etapa == 2 || $equipo->etapa == 3)) { ?>
                                                    <li><?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_delivery"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Mi primera entrega <span class="hide">></span>
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

                                                <?php if ($integrante && $equipo && $etapa2 && ($equipo->etapa == 1 || $equipo->etapa == 2) && $estudiante->grado != 6) { ?>
                                                    <li><?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_delivery"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Búsqueda de proyectos <span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>', ['proyecto/buscar'], []); ?>
                                                    </li>
                                                <?php } ?>

                                            <?php } ?>
                                        </ul>
                                    </div>

                                    <a href="#" class="btn btn-default btn-lateral">
                                        <span class="icon_download"> bases del concurso</span>
                                    </a>

                                    <a href="#" class="btn btn-default btn-lateral">
                                        <span class="icon_download"> GUÍA PARA EL DOCENTE</span>
                                    </a>

                                    <a href="#" class="btn btn-default btn-lateral">
                                        <span class="icon_download"> GUÍA PARA EL ESTUDIANTE</span>
                                    </a>
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
            <script nonce="<?= getnonceideas() ?>" >
                window.page = window.location.hash || "#about";
                $(document).ready(function() {
                    if (window.page != "#about") {
                        $(".menu").find("li[data-target=" + window.page + "]").trigger("click");
                    }
                });
                $(window).on("resize", function() {
                    $("html, body").height($(window).height());
                    $(".main, .menu").height($(window).height() - $(".header-panel").outerHeight());
                    $(".pages").height($(window).height());
                }).trigger("resize");
                $(".menu li").click(function() {
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
                    var totop = setInterval(function() {
                        $(".pages").animate({scrollTop: 0}, 0);
                    }, 1);
                    setTimeout(function() {
                        page.addClass("active");
                        setTimeout(function() {
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
                    lines = lines.map(function(line) {
                        if (line.match(re)) {
                            line = line.substring(indentSize);
                        }
                        return line;
                    });
                    lines = lines.join("\n");
                    return lines;
                }
                $("#opensource").click(function() {
                    $.get(window.location.href, function(data) {
                        var html = $(data).find(window.page).html();
                        html = cleanSource(html);
                        $("#source-modal pre").text(html);
                        $("#source-modal").modal();
                    });
                });
            </script>

            
            
            <!-- Twitter Bootstrap -->
            <script nonce="<?= getnonceideas() ?>"  src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/3.3.6/bootstrap.min.js"></script>

            <!-- Material Design for Bootstrap -->
            <script nonce="<?= getnonceideas() ?>"  src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/js/material.js"></script>
            <script nonce="<?= getnonceideas() ?>"  src="<?= \Yii::$app->request->BaseUrl ?>/bootstrap-material-design-master/dist/js/ripples.min.js"></script>
            <script nonce="<?= getnonceideas() ?>" >
                $.material.init();
            </script>


            <!-- Dropdown.js -->
            <script nonce="<?= getnonceideas() ?>"  src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/master/jquery.dropdown.js"></script>
            <script nonce="<?= getnonceideas() ?>" >
                $("#dropdown-menu select").dropdown();
            </script>

        </body>
    </html>
    <?php $this->endPage() ?>
<?php } else { ?>
    <script nonce="<?= getnonceideas() ?>" >
        window.location.replace('../web/site/index')
    </script>
<?php } ?>