<?

namespace app\widgets\calc_porduct_delivery\assets\classes;

use yii\web\AssetBundle;

class DeliveryCalcAsset extends AssetBundle
{
    public $basePath = '@app';
    public $baseUrl = '@web';
    public $css = [
        '/widgets/calc_porduct_delivery/assets/style.css',
    ];
    public $js = [
        '/widgets/calc_porduct_delivery/assets/calc_sciprt.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}