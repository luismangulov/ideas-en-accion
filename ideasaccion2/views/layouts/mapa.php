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
        <script nonce="<?= getnonceideas() ?>"  src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/2.2.0/jquery.min.js" type="text/javascript"></script>
        <script nonce="<?= getnonceideas() ?>"  src="<?= \Yii::$app->request->BaseUrl ?>/js/util.js" type="text/javascript"></script>


        <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/exo476.css" type="text/css">
        <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/raleway47.css" type="text/css">


        <link href="<?= \Yii::$app->request->BaseUrl ?>/css/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/jquery.custom-scrollbar.css"/>
        <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/style_votacion.css">
        <link href="<?= \Yii::$app->request->BaseUrl ?>/img/favicon.ico" rel="Shortcut Icon">

                <script nonce="<?= getnonceideas() ?>" >
                                      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                                      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                                      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                                      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                                      ga('create', 'UA-102582124-1', 'auto');
                                      ga('send', 'pageview');

                </script>        
        
    </head>
    <body>
        <!-- Google Tag Manager -->
        <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PZX7QM"
                          height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <script nonce="<?= getnonceideas() ?>" >(function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({'gtm.start':
                            new Date().getTime(), event: 'gtm.js'});
                var f = d.getElementsByTagName(s)[0],
                        j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                        '//www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-PZX7QM');</script>
        <!-- End Google Tag Manager -->
        <header>
            <div class="bar_yellow"></div>

            <div class="container">


                <a href="http://www.minedu.gob.pe/ideasenaccion/" class="logos"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/logo.jpg" alt=""></a>
                <a href="http://www.minedu.gob.pe/ideasenaccion/" class="logos ideas"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/logo_ideas_en_accion.png" alt=""></a>
            </div>
        </header>
        <section class="map container">
            <?= $content ?>
        </section>
        <!-- Open source code -->


    </body>
</html>
<?php $this->endPage() ?>

