<?php

namespace app\modules\promocode\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "promocode_user".
 *
 * @property int $id
 * @property string $phone
 * @property string $code
 * @property int $created_at
 * @property int $updated_at
 */
class PromocodeUser extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'promocode_user';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['phone', 'code'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['phone', 'code'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Телефон',
            'code' => 'Код',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public static function findOneByPhone($phone)
    {
        return self::findOne(['phone' => $phone]);
    }
}
