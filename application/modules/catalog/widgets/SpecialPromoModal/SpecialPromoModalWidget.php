<?php

namespace app\modules\catalog\widgets\SpecialPromoModal;

use app\modules\catalog\models\entity\Product;
use app\modules\vendors\models\entity\Vendor;
use yii\base\Widget;

class SpecialPromoModalWidget extends Widget
{
    public $view = 'default';
    public $product;

    public function run()
    {
        $product = $this->product;

        if (!$product instanceof Product) return false;

        if ($product->vendor_id != Vendor::VENDOR_ID_ROYAL) return false;

        return $this->render($this->view);
    }
}