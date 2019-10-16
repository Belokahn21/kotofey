<?php

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Providers extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name'], 'required']
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }
}