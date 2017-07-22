<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Foro;
use app\models\Usuario;
use app\models\Integrante;
use app\models\Equipo;
use app\models\Proyecto;
use app\models\Etapa;
use app\models\Invitacion;

AppAsset::register($this);

if (!\Yii::$app->user->isGuest) {

    $etapa2 = Etapa::find()->where('etapa=2')->one();
    $etapa3 = Etapa::find()->where('etapa=3')->one();
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
    <html lang="<?= Yii::$app->language ?>" ng-app="app">
        <head>
            <meta charset="<?= Yii::$app->charset ?>">
            <meta name="viewport" content="width=device-width, initial-scale=0">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.11.1/jquery.min.js"></script>
            <script src='../AdminLTE/bootstrap/js/bootstrap.min.js'></script>
            <script src="<?= \Yii::$app->request->BaseUrl ?>/js/util.js" type="text/javascript"></script>
            <link href="<?= \Yii::$app->request->BaseUrl ?>/img/favicon.ico" rel="Shortcut Icon">

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
        <body class="skin-blue">
            <?php $this->beginBody() ?>
            <div class="wrapper">
                <header class="main-header">
                    <!-- Logo -->
                    <a href="index2.html" class="logo"><?= Html::img('../images/logo_ministerio_educacion.png', ['class' => 'img-responsive logo', 'alt' => 'Responsive image']) ?></a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top" role="navigation">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>

                    </nav>
                </header>
                <aside class="main-sidebar">
                    <section class="sidebar">
                        <div class="user-panel ">
                            <div class="pull-left image col-md-4">
                                <img src="../foto_personal/<?= $usuario->avatar ?>" class="img-circle" alt="User Image" />
                            </div>
                            <div class="pull-left info col-md-8">
                                <p style="font-size: 12px" class="pull-left text-left"><?= $usuario->estudiante->nombres . " " . $usuario->estudiante->apellido_paterno . " " . $usuario->estudiante->apellido_materno ?></p>
                            </div>
                            <div class="clearfix"></div>
                            <div class="pull-right col-md-12 text-right">
                                <?= Html::a('Cerrar sesión', ['login/logout'], ['class' => '']); ?>
                            </div>
                        </div>
                        <ul class="sidebar-menu">
                            <li class="header">Menú</li>
                            <?php if ($integrante) { ?>
                                <li><?= Html::a('<i class="fa fa-book"></i> Ideas en acción', ['panel/ideas-accion'], []); ?></li>
                            <?php } ?>

                            <li><?= Html::a('<i class="fa fa-book"></i> Mi equipo', ['panel/index'], []); ?></li>
                            <?php if ($integrante && $equipo) { ?>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-share"></i> <span>Foros</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <?php foreach ($foros as $foro): ?>
                                            <?php if ($foro->id == 2 || ($integrante && $foro->asunto_id == $equipo->asunto_id)) { ?>
                                                <li><?= Html::a("$foro->titulo", ['foro/view', 'id' => $foro->id], []); ?></li>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if ($integrante && $equipo && !$proyecto && $integrante->rol == 1 && $equipo->etapa == 0) { ?>
                                <li><?= Html::a("Mi proyecto", ['proyecto/index'], []); ?> </li>
                            <?php } elseif ($integrante && $equipo && $proyecto && $equipo->etapa == 0 && ($integrante->rol == 1 || $integrante->rol == 2)) { ?>
                                <li><?= Html::a("Mi proyecto", ['proyecto/actualizar'], []); ?></li>
                                <!--<li><?= Html::a("Mi video", ['video/index'], []); ?></li>-->
                                <li><?= Html::a("Mis entregas", ['entrega/index'], []); ?></li>
                            <?php } ?>
                            <?php if ($integrante && $equipo && $etapa2 && ($equipo->etapa == 1 || $equipo->etapa == 2)) { ?>
                                <li><?= Html::a("Búsqueda de proyectos", ['proyecto/buscar'], []); ?></li>
                            <?php } ?>
                            <?php if ($integrante && $equipo && $etapa3 && ($equipo->etapa == 2)) { ?>
                                <li><?= Html::a("Votación interna", ['proyecto/votacion'], []); ?></li>
                            <?php } ?>
                        </ul>
                    </section>
                </aside>
                <div class="content-wrapper">
                    <section class="content">
                        <?= $content ?>
                    </section>
                </div>
            </div>


            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } else { ?>
    <script>
        window.location.replace('../web/site/index')
    </script>
<?php } ?>

