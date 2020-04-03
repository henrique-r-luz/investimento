<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        "js/grow-js/jquery.growl.css"
    ];
    public $js = [
        //"/usr/local/bin/node-server/node_modules/socket.io-client/dist/socket.io.js",
       "js/node_modules/socket.io-client/dist/socket.io.js",
         //"js/msg.js",
        "js/notificacao.js",
        "js/grow-js/jquery.growl.js"
       
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
