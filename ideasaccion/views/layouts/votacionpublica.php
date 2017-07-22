<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

$this->title = "Ideas en acción";
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=0">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/2.2.0/jquery.min.js" type="text/javascript"></script>

        <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/exo476.css" type="text/css">
        <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/raleway47.css" type="text/css">
        <link href="<?= \Yii::$app->request->BaseUrl ?>/css/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/votacion/css/style.css">

        <!-- Facebook Share Tags -->
        <meta property="og:title"              content="Ideas en Acción | Minedu" />
        <meta property="og:description"        content="¡Ya elegí mis proyectos favoritos en Ideas en Acción! Vota tu también y hagamos la diferencia." />
        <meta property="og:image"              content="http://face.ideasenaccion.pe/images/share_facebook_image.png" />
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
        <?php
        $mensajes = ['Conoce los proyectos finalistas de las 26 regiones.', 'Selecciona los 03 proyectos más pajas.', 'Recuerda que pueden ser de <u>DISTINTAS</u> regiones.'];
        $key = array_rand($mensajes);
        ?>
        <div class="personaje_derecha_fixed personaje_entregas">

        </div>
        <header>
            <div class="bar_yellow"></div>

            <div class="container">
                <a href="http://www.minedu.gob.pe/ideasenaccion/" class="logos"><img src="<?= \Yii::$app->request->BaseUrl ?>/votacion/images/logo.jpg" alt=""></a>
                <a href="http://www.minedu.gob.pe/ideasenaccion/" class="logos ideas"><img src="<?= \Yii::$app->request->BaseUrl ?>/votacion/images/logo_ideas_en_accion.png" alt=""></a>
            </div>
        </header>
        <section class="map container" style="padding-top: 21px">
            <?= $content ?>
        </section>
        <!-- Open source code -->


    </body>
</html>
<?php $this->endPage() ?>

