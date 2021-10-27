<?php


namespace app\modules\vendors\models\reopository;

use app\modules\vendors\models\entity\Vendor;

class VendorRepository
{
    public static function getAllVendors()
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return Vendor::find()->all();
        });
    }

    public static function getVendor(int $vendor_id)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $vendor_id, function () use ($vendor_id) {
            return Vendor::findOne($vendor_id);
        });
    }
}