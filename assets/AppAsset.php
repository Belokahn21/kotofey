<?
namespace app\assets;

use yii\web\AssetBundle;


class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
//        'css/site.min.css',

        'css/media.css',
        'css/additional.css',
        'css/demo.css',
        'css/magnific-popup.css',
        'css/assets-owl/owl.carousel.min.css',
        'css/assets-owl/owl.theme.default.min.css',
        'plugins/magnific/magnific-popup.css',
    ];
    public $js = [
        'js/site.js',
        'js/basket.js',
        'js/tools.js',
        'js/tabs.js',
        'js/cookie.js',
        'js/configurator.js',
        'js/jquery.magnific-popup.js',
        'js/owl/owl.carousel.min.js',
        'plugins/magnific/jquery.magnific-popup.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
