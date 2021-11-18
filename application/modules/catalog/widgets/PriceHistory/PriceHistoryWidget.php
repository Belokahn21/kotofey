<?php

namespace app\modules\catalog\widgets\PriceHistory;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPriceHistory;
use yii\base\Widget;

class PriceHistoryWidget extends Widget
{
    /**
     * @var Product
     */
    public $product;

    public $view = 'default';

    public function run()
    {
        $history = ProductPriceHistory::find()->where(['product_id' => $this->product->id])->asArray(true)->all();

        if (!$history) return false;

        return $this->render($this->view, [
            'history' => $history
        ]);
    }
}