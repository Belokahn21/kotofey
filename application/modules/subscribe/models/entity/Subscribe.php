<?php

namespace app\modules\subscribe\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Subscribe extends ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public static function tableName()
    {
        return "subscribes";
    }

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'string'],
            ['email', 'unique'],

            ['active', 'integer'],
            ['active', 'default', 'value' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [];
    }
}