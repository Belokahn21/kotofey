<?php

/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 0:49
 */

namespace app\models\entity\support;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class SupportStatus extends ActiveRecord
{
    public static function tableName()
    {
        return "support_status";
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Поле {attribute} обязательно нужно заполнить'],
            ['sort', 'default', 'value' => 500],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'sort' => 'Сортировка',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }
}