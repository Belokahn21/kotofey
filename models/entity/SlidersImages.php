<?php

namespace app\models\entity;


use yii\db\ActiveRecord;

class SlidersImages extends ActiveRecord
{
    public static function tableName()
    {
        return "sliders_images";
    }

    public function rules()
    {
        return [];
    }

    public function attributeLabels()
    {
        return [];
    }
}