<?php

namespace app\modules\catalog\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "notify_admission".
 *
 * @property int $id
 * @property int|null $is_active
 * @property string $email
 * @property integer $phone
 * @property int $product_id
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class NotifyAdmission extends \yii\db\ActiveRecord
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
            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],

            [['product_id', 'created_at', 'updated_at'], 'integer'],

            [['email', 'product_id'], 'required', 'message' => '{attribute} нужно обязательно заполнить'],
//            [['email'], 'string', 'max' => 255],

            [['email'], 'email'],

            [['is_active'], 'default', 'value' => 1],

            ['email', 'unique', 'targetAttribute' => ['email', 'product_id'], 'message' => 'Вы уже отслеживаете этот товар'],

            [
                ['phone'],
                'filter',
                'filter' => function ($value) {
                    $value = str_replace('+7', '8', $value);
                    return str_replace([' ', '(', ')', '-'], '', $value);
                },
            ],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'email' => 'Email',
            'phone' => 'Телефон',
            'product_id' => 'Товар ID',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
