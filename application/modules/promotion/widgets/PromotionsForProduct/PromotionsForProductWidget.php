<?php

namespace app\modules\promotion\widgets\PromotionsForProduct;

use app\modules\promotion\models\entity\PromotionProductMechanics;
use yii\base\Widget;

class PromotionsForProductWidget extends Widget
{
    public $view = 'default';
    public $product_id;

    public function run()
    {
        $models = [];
        $mechaniscs = PromotionProductMechanics::find()
            ->joinWith('promotion')
            ->where(['product_id' => $this->product_id])
            ->andWhere([
                'or',
                'promotion.start_at = :default and promotion.end_at = :default',
                'promotion.start_at is null and promotion.end_at is null',
                'promotion.start_at < :now and promotion.end_at > :now'
            ])->andWhere(['promotion.is_active' => true])
            ->addParams([
                ":now" => time(),
                ":default" => 0,
            ])
            ->all();
        if (!$mechaniscs) return false;

        foreach ($mechaniscs as $mechanics) {
            $models[] = $mechanics->promotion;
        }

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}