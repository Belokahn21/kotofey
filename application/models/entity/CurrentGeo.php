<?php

namespace app\models\entity;


class CurrentGeo extends Geo
{
    public static function find()
    {
        return parent::find()->where(['id' => \Yii::$app->session->get('city_id')]);
    }
}