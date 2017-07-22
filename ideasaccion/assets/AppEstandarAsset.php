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
class AppEstandarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        //'http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css',
        //'AdminLTE/dist/css/AdminLTE.min.css',
        //'AdminLTE/dist/css/skins/_all-skins.min.css',
        //'AdminLTE/plugins/iCheck/flat/blue.css',
    ];
    public $js = [
        //'AdminLTE/plugins/morris/morris.min.js',
        //'AdminLTE/plugins/sparkline/jquery.sparkline.min.js',
        //'AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        //'AdminLTE/plugins/fastclick/fastclick.min.js',
        //'AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        //'AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        ////'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js',
        //'https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js',
        //'AdminLTE/dist/js/app.min.js',
        //'AdminLTE/dist/js/demo.js',
        'js/bootstrap-notify.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
