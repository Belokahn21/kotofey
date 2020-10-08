<?php

namespace app\modules\content\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Sliders extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required'],

            [['name'], 'string'],

            [['active'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'active' => 'Активность',
            'sort' => 'Сортировка',
            'created_at' => 'Дата создания',
        ];
    }
}