<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        //'css/default.css',
        //'css/index.css',
        //'css/jquery.fullPage.css'
        //'http://fonts.googleapis.com/css?family=Headland+One|Open+Sans:400italic,400,700',
        //'AdminLTE/bootstrap/css/bootstrap.min.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        //'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'.
        'http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css',
        'AdminLTE/dist/css/AdminLTE.min.css',
        'AdminLTE/dist/css/skins/_all-skins.min.css',
        'AdminLTE/plugins/iCheck/flat/blue.css',
        //'AdminLTE/plugins/morris/morris.css',
        //'AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
        //'AdminLTE/plugins/datepicker/datepicker3.css',
        //'AdminLTE/plugins/daterangepicker/daterangepicker-bs3.css',
        //'AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'
    ];
    public $js = [
        //'AdminLTE/plugins/jQuery/jQuery-2.1.3.min.js',
        
        //'http://code.jquery.com/ui/1.11.2/jquery-ui.min.js',
        //'http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
        'AdminLTE/plugins/morris/morris.min.js',
        'AdminLTE/plugins/sparkline/jquery.sparkline.min.js',
        'AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'AdminLTE/plugins/fastclick/fastclick.min.js',
        'AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        
        'AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js',
        'https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js',
        'AdminLTE/dist/js/app.min.js',
        'AdminLTE/dist/js/demo.js',
        //'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js',
        //'https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js',
        //'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.js',
        //'http://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular-touch.js',
        //'http://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular-animate.js',
        //'http://ui-grid.info/docs/grunt-scripts/csv.js',
        //'http://ui-grid.info/docs/grunt-scripts/pdfmake.js',
        //'http://ui-grid.info/docs/grunt-scripts/vfs_fonts.js',
        //'js/app.js',
        //'http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js',
        //'js/app.js',
        //'js/jquery.fullPage.js',
        //'js/jquery.slimscroll.min.js',
        //'js/jquery.hovercard.js',
        'js/bootstrap-notify.js',
        //'js/extensions.js',
        //'//code.jquery.com/ui/1.11.4/jquery-ui.js',
        //'js/typeahead.bundle.js'
        //'js/notify.js',
        //'js/notify.min.js'
        //'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',
        //'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js'
        //'js/jquery-1.10.2.min.js',
        //'js/scrollIt.js',
        //'https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'
        //'https://code.angularjs.org/2.0.0-beta.0/angular2-polyfills.js',
        //'https://code.angularjs.org/2.0.0-beta.0/Rx.umd.js',
        //'https://code.angularjs.org/2.0.0-beta.0/angular2-all.umd.dev.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
