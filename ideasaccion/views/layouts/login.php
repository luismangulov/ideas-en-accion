<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

//use app\assets\AppAssetInterno;
//AppAssetInterno::register($this);
?>
<?php //$this->beginPage()   ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>

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
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="<?= \Yii::$app->request->BaseUrl ?>/img/favicon.ico" rel="Shortcut Icon">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>

        <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.10.2/jquery-1.10.2.min.js"></script>
        <script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/2.2.0/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/google/material-icons.css" type="text/css">
        <link rel="stylesheet" href="<?= \Yii::$app->request->BaseUrl ?>/css/bootstrap.min.css" media="screen" charset="utf-8">
        <link href="<?= \Yii::$app->request->BaseUrl ?>/css/bootstrap-material-design.css" rel="stylesheet">
        <link href="<?= \Yii::$app->request->BaseUrl ?>/css/ripples.min.css" rel="stylesheet">
        <link href="<?= \Yii::$app->request->BaseUrl ?>/css/master/jquery.dropdown.css" rel="stylesheet">
        <link href="<?= \Yii::$app->request->BaseUrl ?>/css/style.css" rel="stylesheet">
        <script src="<?= \Yii::$app->request->BaseUrl ?>/js/bootstrap-notify.js"></script>
        <script src="<?= \Yii::$app->request->BaseUrl ?>/js/util.js" type="text/javascript"></script>

        <?php $this->head() ?>
    </head>
    <body class="login">
        <header>
            <div class="franja_amarilla"></div>
            <div class="content">
                <a href="http://www.minedu.gob.pe/ideasenaccion/" class="logo">
                    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/logo.jpg" alt="" />
                </a>
            </div>
        </header>
        <div class="body content">
            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/personaje_izquierda.png" class="personaje personaje_izquierda" alt="" />
            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/personaje_derecha.png" class="personaje personaje_derecha" alt="" />
            <div class="form">
                <div class="logo_proyecto">
                    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/logo_ideas_en_accion.png" alt="" />
                </div>
                <?= $content ?>
            </div>
        </div>


        <!-- Open source code -->
        <script>
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
