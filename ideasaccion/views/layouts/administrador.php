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
use app\models\Invitacion;

AppEstandarAsset::register($this);

if (!\Yii::$app->user->isGuest) {
    $etapa1 = Etapa::find()->where('etapa=1 and estado=1')->one();
    $etapa2 = Etapa::find()->where('etapa=2 and estado=1')->one();
    $etapa3 = Etapa::find()->where('etapa=3 and estado=1')->one();
    $usuario = Usuario::find()->where('id=:id', [':id' => \Yii::$app->user->id])->one();
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
            <meta name="viewport" content="width=device-width, initial-scale=0">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>

            <link href="<?= \Yii::$app->request->BaseUrl ?>/img/favicon.ico" rel="Shortcut Icon">
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/util.js" type="text/javascript"></script>

            <!-- jQuery -->
            <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>-->
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/2.2.0/jquery.min.js" type="text/javascript"></script>

            <!-- Material Design fonts -->
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/css.css" type="text/css">
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/material-icons.css" type="text/css">


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

            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.2.1/jquery.webui-popover.min.js"></script>

            <link href="<?= \Yii::$app->request->BaseUrl ?>/css/style.css" rel="stylesheet">

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
        <body class="mi_equipo" >
            <?php $this->beginBody() ?>
            <header>
                <div class="franja_amarilla"></div>
                <div class="content">
                    <a href="#" class="logo">
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
                                                        <div class="cell_div cell_image">
                                                            <div class="image_grupo" style="background-image: url(<?= \Yii::$app->request->BaseUrl ?>/foto_personal/<?= $usuario->avatar ?>);"></div>
                                                        </div>
                                                        <div class="cell_div cell_info">
                                                            <div class="cell_info_content">
                                                                <b class="uppercase">
                                                                    <?= $usuario->name_temporal ?>

                                                                </b>
                                                            </div>
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid_box_line_blue">

                                        <ul class="menu_lateral">
                                            <!--control de acciones-->
                                            <?php if (\Yii::$app->user->can('administrador')) { ?>
                                                <?php if ($etapa1 || $etapa2 || $etapa3) { ?>


                                                    <li>
                                                        <?= Html::a('<div class="table_div">
                                                <div class="row_div">
                                                    <div class="cell_div div_ia_icon">
                                                        <span class="ia_icon ia_icon_idea"></span>
                                                    </div>
                                                    <div class="cell_div">
                                                        Control de acciones <span class="hide">></span>
                                                    </div>
                                                </div>
                                            </div>', ['panel/acciones'], []); ?>
                                                    </li>
                                                    <!--fin control de acciones-->
                                                    <!--Foro-->
                                                    <li>


                                                        <?= Html::a('<div class="table_div">
                                            <div class="row_div">
                                                <div class="cell_div div_ia_icon">
                                                    <span class="ia_icon ia_icon_delivery"></span>
                                                </div>
                                                <div class="cell_div">
                                                    Foros <span class="hide">></span>
                                                </div>
                                            </div>
                                        </div>', ['panel/foros'], ['id' => 'lnk_forosgeneral']); ?>
                                                    </li>
                                                    <!--Fin Foro-->
                                                    <!--Foro proyectos-->
                                                    <!--<li>
                                                    <?= Html::a("Comentario de proyectos", ['panel/forosproyectos'], []); ?>
                                                    </li>-->
                                                    <!--Fin Foro proyectos-->

                                                    <!--Reportes-->
                                                    <?php /* <li>
                                                      <?= Html::a("Reportes de votación de asuntos públicos",['#'],['class'=>'sub_menu']);?>
                                                      <ul>
                                                      <li><?= Html::a("Reportes de votación de asuntos públicos",['reporte/index'],[]);?></li>
                                                      <li><?= Html::a("Reportes de votación por región ",['reporte/region'],[]);?></li>
                                                      </ul>
                                                      </li> */ ?>
                                                    <li>
                                                        <a href="#" class="sub_menu" id="lnk_reporteinscripcion">
                                                            <div class="table_div">
                                                                <div class="row_div">
                                                                    <div class="cell_div div_ia_icon">
                                                                        <span class="ia_icon ia_icon_delivery"></span>
                                                                    </div>
                                                                    <div class="cell_div">
                                                                        Reporte de inscripcrión a la plataforma <span class="hide">></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>


                                                        <ul>
                                                            <li><?= Html::a("Reporte de participantes ", ['reporte/registrados'], ['id' => 'lnk_reporteestudiantes']); ?></li>
                                                            <li><?= Html::a("Reporte de participantes detalles", ['reporte/registrados-detalles'], ['id' => 'lnk_reporteestudiantedet']); ?></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="sub_menu" id="lnk_reporteprimera">
                                                            <div class="table_div">
                                                                <div class="row_div">
                                                                    <div class="cell_div div_ia_icon">
                                                                        <span class="ia_icon ia_icon_delivery"></span>
                                                                    </div>
                                                                    <div class="cell_div">
                                                                        Reporte de primera entrega <span class="hide">></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul>
                                                            <li><?= Html::a("Reporte de equipos", ['reporte/equipo'], ['id' => 'lnk_reporteequipos']); ?></li>
                                                            <li><?= Html::a("Reporte de proyectos", ['reporte/proyecto'], ['id' => 'lnk_reporteproyectos']); ?></li>
                                                            <li><?= Html::a("Reporte de proyectos regionales", ['reporte/proyecto2'], ['id' => 'lnk_reporteproyectosxregion']); ?></li>
                                                            <li><?= Html::a("Reporte total", ['reporte/proyecto3'], ['id' => 'lnk_reportetotal']); ?></li>
                                                        </ul>
                                                    </li>


                                                <?php } ?>



                                                <?php if ($etapa2 || $etapa3) { ?>



                                                    <li>
                                                        <?= Html::a("Reporte de segunda entrega", ['#'], ['class' => 'sub_menu']); ?>
                                                        <ul>
                                                            <li><?= Html::a("Reportes de aportes de proyectos", ['proyecto/buscar-monitor'], []); ?></li>
                                                            <li><?= Html::a("Reportes de proyectos", ['reporte/proyecto2entrega'], []); ?></li>
                                                        </ul>
                                                    </li>

                                                <?php } /*
                                                  <li>
                                                  <?= Html::a("Evaluación de proyectos", ['panel/votacioninterna']); ?>
                                                  </li> */
                                                ?>
                                            <?php } ?>
                                            <?php /*
                                              <li>
                                              <?= Html::a("Reportes",['#'],['class'=>'sub_menu']);?>
                                              <ul>
                                              <li><?= Html::a("Reportes de votación de asuntos públicos",['reporte/index'],[]);?></li>
                                              <li><?= Html::a("Reportes de votación por región ",['reporte/region'],[]);?></li>
                                              <li><?= Html::a("Reportes de estudiantes ",['reporte/registrados'],[]);?></li>
                                              <li><?= Html::a("Reportes de estudiantes detalles",['reporte/registrados-detalles'],[]);?></li>
                                              <li><?= Html::a("Reportes de equipos",['reporte/equipo'],[]);?></li>
                                              <li><?= Html::a("Reportes de proyectos",['reporte/proyecto'],[]);?></li>
                                              <li><?= Html::a("Reportes de proyectos regionales",['reporte/proyecto2'],[]);?></li>

                                              </ul>
                                              </li>
                                             */
                                            ?>
                                            <!--Fin Reportes-->

                                            <!--Contraseña-->
                                            <?php /*
                                              <li>
                                              <?php //= Html::a("Cambio de contraseña",['usuario/cambiar'],[]);?>
                                              </li>
                                              <li><?php //= Html::a("Ingreso de equipo ya inscritos",['equipo/finalizar-equipo2'],[]);?></li>
                                             */ ?>
                                            <!--Fin Contraseña-->
                                        </ul>






                                    </div>
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


            <?php $this->endBody() ?>
            <!-- Open source code -->
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