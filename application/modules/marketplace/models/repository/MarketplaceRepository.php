<?php

namespace app\modules\marketplace\models\repository;

use app\modules\marketplace\models\entity\Marketplace;
use yii\caching\DbDependency;

class MarketplaceRepository
{
    public static function getActiveMarketplaces()
    {
        return \Yii::$app->cache->getOrSet(__METHOD__ . __CLASS__, function () {
            return Marketplace::findAll(['is_active' => true]);
        }, \Yii::$app->params['cache_time'], new DbDependency(['sql' => 'select max(created_at) from `marketplace` where `is_active`=1 limit 1']));
    }
}