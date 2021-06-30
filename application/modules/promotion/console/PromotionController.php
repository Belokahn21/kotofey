<?php

namespace app\modules\promotion\console;

use app\modules\promotion\models\entity\PromotionProductMechanics;
use yii\console\Controller;

class PromotionController extends Controller
{
    public function actionGroupNotify()
    {
        //collect promo in current

        $list_promo_mechanics = PromotionProductMechanics::find()->joinWith('promotion')->andWhere([
            'or',
            'promotion.start_at = :default and promotion.end_at = :default',
            'promotion.start_at is null and promotion.end_at is null',
            'promotion.start_at < :now and promotion.end_at > :now'
        ])
            ->andWhere(['promotion.is_active' => true])
            ->addParams([
                ":now" => time(),
                ":default" => 0,
            ])
            ->all();



    }
}