<?php

namespace app\modules\reviews\widgets\ProductReviews;


use app\modules\reviews\models\entity\Reviews;
use yii\base\Widget;

class ProductReviewsWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $models = Reviews::find()->all();

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}