<?php


namespace app\modules\catalog\widgets\LastWeekProducts;

use app\modules\catalog\models\entity\Product;
use app\modules\site\models\tools\Debug;
use yii\bootstrap\Widget;

class LastWeekProducts extends Widget
{
    public $view = 'default';
    public $cacheTime = 3600 * 7 * 24;

    public function run()
    {
        if (!Debug::isPageSpeed()) {

            $cache = \Yii::$app->cache;

            $models = $cache->getOrSet('last-week-products', function () {
                return Product::find()->select(['id', 'name', 'price', 'media_id', 'image', 'image'])->where(['between', 'created_at', time() - 604800, time()])->all();
            }, $this->cacheTime);


            return $this->render($this->view, [
                'models' => $models
            ]);
        }
    }
}