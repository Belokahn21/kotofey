<?php

namespace app\modules\catalog\models\repository;


use app\modules\catalog\models\entity\PropertyGroup;

class PropertyGroupRepository
{
    public static function getGroupsByIds(array $ids)
    {
        return \Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . implode(',', $ids), function () use ($ids) {
            return PropertyGroup::find()->where(['id' => $ids])->all();
        });
    }
}