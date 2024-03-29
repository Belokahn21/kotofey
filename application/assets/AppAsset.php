<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;


class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
//        'css/style.min.css',
    ];
    public $js = [
//        'js/frontend-core.min.js',
//        'js/bundle.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = [
        'position' => View::POS_END
    ];
}
