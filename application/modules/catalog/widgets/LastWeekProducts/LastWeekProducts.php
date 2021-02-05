<?php


namespace app\modules\catalog\widgets\LastWeekProducts;

use app\modules\catalog\models\entity\Product;
use app\modules\site\models\tools\Debug;
use yii\bootstrap\Widget;
use yii\caching\DbDependency;

class LastWeekProducts extends Widget
{
    public $view = 'default';
    public $cacheTime = 3600 * 7 * 24;
    public $limit = 10;

    public function run()
    {
        $limit = $this->limit;


        $models = \Yii::$app->cache->getOrSet('last-week-products', function () use ($limit) {
            return Product::find()->select(['id', 'name', 'price', 'media_id', 'media_id', 'image', 'slug', 'article', 'status_id'])->where(['between', 'created_at', time() - 604800, time()])->limit($limit)->all();
        }, $this->cacheTime, new DbDependency([
            'sql' => 'select count(*) from `product` where created_at BETWEEN ' . (time() - 604800) . ' AND ' . time() . ' limit ' . $limit . ';'
        ]));

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}