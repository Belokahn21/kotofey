<?php

namespace app\modules\geo\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class GeoTimezone extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],

            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],

            [['sort'], 'integer'],
            [['sort'], 'default', 'value' => 500],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'value' => 'Занчение',
            'is_active' => 'Активность',
            'sort' => 'Порядок сортировки',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }
}