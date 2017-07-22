<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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


                <script>
                                      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                                      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                                      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                                      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                                      ga('create', 'UA-102582124-1', 'auto');
                                      ga('send', 'pageview');

                </script>


    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                //'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => '',
                ],
            ]);
            ?>
            <ul class="nav navbar-nav navbar-right text-right" style="padding: 0px;">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Ingresar</b> </a>
                    <ul id="login-dp" class="dropdown-menu" >
                        <li>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12 text-center">
                                        <h4>Ingreso a la Plataforma</h4>
                                    </div>
                                    <form name="form" ng-app >
                                        <div class="form-group" ng-class="{true: 'has-error'}[submitted && form.Usuario[username].$invalid]">
                                            <label class="control-label" >Usuario</label>
                                            <input type="text" class="form-control" name="Usuario[username]" id="usuario-username" placeholder="Usuario" required >
                                        </div>
                                        <!--<div class="form-group">
                                            <label class="control-label" for="usuario-password">Contraseña</label>
                                            <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Contraseña" required>
                                        <!--<div class="help-block text-right"><a href="">Forget the password ?</a></div>
                            </div>-->
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block" ng-click="submitted = true">Ingresar</button>
                                        </div>
                                        <!--<div class="checkbox">
                                            <label><input type="checkbox"> keep me logged-in</label>
                                        </div>-->
                                    </form>
                                </div>
                                <div class="bottom text-center">
                                    Si aún no te haz registrado, puedes hacerlo <a href="#"><b>aquí</b></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php
            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
<?= $content ?>
            </div>
        </div>

        <!--
        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        
                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>
        -->
<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
