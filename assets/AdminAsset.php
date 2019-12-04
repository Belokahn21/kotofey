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

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/backend.min.css',
//        'css/admin.css',
//        'css/tabs.css',
    ];
    public $js = [
//        'plugins/editor/ckeditor/ckeditor.js',
//        'https://cdn.ckeditor.com/4.11.3/standard/ckeditor.js',
//        'js/tabs.js',
//        'js/admin.js',
        'js/backend.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
