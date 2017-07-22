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
class AppAssetInterno extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        //'css/default.css',
        //'css/index.css',
        //'css/jquery.fullPage.css'
        //'http://fonts.googleapis.com/css?family=Headland+One|Open+Sans:400italic,400,700',
    ];
    public $js = [
        
        //'js/controllers.js',
        //'http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js',
        //'js/app.js',
        
        'js/bootstrap-notify.js',
        //'js/bootstrap-notify.min.js',
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
        //'yii\bootstrap\BootstrapAsset',
    ];
}
