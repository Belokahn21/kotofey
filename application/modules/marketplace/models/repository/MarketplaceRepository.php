<?php

namespace app\modules\marketplace\models\repository;


use app\modules\marketplace\models\entity\Marketplace;

class MarketplaceRepository
{
    /**
     * @return Marketplace[]
     */
    public static function getAllMarketplace()
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return Marketplace::find()->all();
        });
    }
}