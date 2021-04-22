<?php

namespace app\modules\reviews\widgets\ProductReviews;


use app\modules\reviews\models\entity\Reviews;
use yii\base\Widget;

class ProductReviewsWidget extends Widget
{
    public $view = 'default';
    public $product_id;

    public function run()
    {
        $product_id = $this->product_id;
        $models = \Yii::$app->cache->getOrSet('reviews_product_' . $product_id, function () use ($product_id) {
            return Reviews::find()->where(['product_id' => $product_id])->all();
        });

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}