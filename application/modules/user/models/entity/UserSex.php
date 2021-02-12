<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 14:26
 */

namespace app\modules\user\models\entity;


use yii\db\ActiveRecord;

/**
 * UserSex model
 *
 * @property integer $id
 * @property string $name
 *
 */
class UserSex extends ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Поле {attribute} должно быть заполнено'],
            ['name', 'string'],
        ];
    }

}