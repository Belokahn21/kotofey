<?php

namespace app\modules\reviews\widgets\ProductReviewsForm;


use app\modules\reviews\models\entity\Reviews;
use yii\base\Widget;

class ProductReviewsFormWidget extends Widget
{
    public $view = 'default';
    public $product_id;

    public function run()
    {
        $model = new Reviews();

        return $this->render($this->view, [
            'model' => $model,
            'product_id' => $this->product_id,
        ]);
    }
}