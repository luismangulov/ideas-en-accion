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
    $etapa2 = Etapa::find()->where('etapa=2')->one();
    $etapa3 = Etapa::find()->where('etapa=3')->one();
    $usuario = Usuario::find()->where('id=:id', [':id' => \Yii::$app->user->id])->one();
    $estudiante = Estudiante::find()->where('id=:id', [':id' => $usuario->estudiante_id])->one();
    $votacionpublica = VotacionPublica::find()->all();
//$invitacion=Invitacion::find()->where('equipo_id=:equipo_id and estado=1',[':equipo_id'=>$equipo->id])->one();
    $integrante = Integrante::find()->where('estudiante_id=:estudiante_id', [':estudiante_id' => $usuario->estudiante_id])->one();
    if ($integrante) {
        $equipo = Equipo::find()->where('id=:id and estado=1', [':id' => $integrante->equipo_id])->one();
        if ($equipo) {

            $proyecto = Proyecto::find()->where('equipo_id=:equipo_id', [':equipo_id' => $equipo->id])->one();
        }

        if ($equipo && ($equipo->etapa == 0 or $equipo->etapa == NULL)) {
            $msg = "Gracias por tu esfuerzo, te invitamos a participar de los foros y seguir poniendo tus ideas en acción.";
        } elseif ($equipo && $equipo->etapa == 1) {
            $msg = "No te olvides de hacer tu video de la primera actividad y aportar en los proyectos de tus compañeros.";
        }
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
            <link href="<?= \Yii::$app->request->BaseUrl ?>/img/favicon.ico" rel="Shortcut Icon">
                        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>-->
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/2.2.0/jquery.min.js" type="text/javascript"></script>
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/angularjs/1.5.5/angular.min.js"></script>
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/457.css" type="text/css">
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/material-icons.css" type="text/css">
            <!-- Page style -->
            <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">

            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.2.1/jquery.webui-popover.min.js"></script>

            <link href="<?= \Yii::$app->request->BaseUrl ?>/css/bootstrap/bootstrap.min.css" rel="stylesheet">
            <!-- Twitter Bootstrap -->
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/3.3.6/bootstrap.min.js"></script>
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
        <body class="mi_equipo">
            <?php $this->beginBody() ?>

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
                                                        <div class="cell_div cell_image">
                                                            <div class="image_grupo" style="background-image: url(../foto_personal/<?= $usuario->avatar ?>);"></div>
                                                        </div>
                                                        <div class="cell_div cell_info">
                                                            <div class="cell_info_content">
                                                                <b class="uppercase"><?= Html::a("" . $usuario->estudiante->nombres . " " . $usuario->estudiante->apellido_paterno . " " . $usuario->estudiante->apellido_materno . "", ['usuario/configuracion']); ?> </b>
                                                            </div>
                                                            <div class="line_separator"></div>
                                                            <div class="cell_info_content">
                                                                <b></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>

                                <div class="col-md-9">
                                    <div class="grid_box_line_blue content_infografia">
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
                $('#myModalVideo').on('hidden.bs.modal', function () {
                    $("#myModalVideo iframe").attr("src", $("#myModalVideo iframe").attr("src"));
                });

                $(".menu_lateral li a.sub_menu").on("click", function (e) {
                    e.preventDefault();
                    var _a = $(this);
                    var _li = _a.parent();

                    _a.toggleClass("active");
                    $("ul", _li).stop(true).slideToggle();
                });

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
            <div class="modal-body " id="video">
                <div  class="embed-responsive embed-responsive-16by9">
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