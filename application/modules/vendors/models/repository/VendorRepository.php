<?php

namespace app\modules\vendors\models\repository;

use app\modules\vendors\models\entity\Vendor;

class VendorRepository
{
    public static function getAll()
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__, function () {
            return Vendor::find()->all();
        });
    }

    /**
     * @return Vendor
     */
    public static function getOne(int $id)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . $id, function () use ($id) {
            return Vendor::findOne($id);
        });
    }
}