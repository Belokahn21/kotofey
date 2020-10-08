<?php

namespace app\modules\geo\models\entity;


use app\modules\geo\models\entity\Geo;

class CurrentGeo extends Geo
{
    public static function find()
    {
        return parent::find()->where(['id' => \Yii::$app->session->get('city_id')]);
    }
}