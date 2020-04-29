<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 14:26
 */

namespace app\models\entity;


use yii\db\ActiveRecord;

class UserSex extends ActiveRecord
{
    public static function tableName()
    {
        return "user_sex";
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Поле {attribute} должно быть заполнено'],
            ['name', 'string'],
        ];
    }

}