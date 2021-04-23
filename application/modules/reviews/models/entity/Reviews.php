<?php

namespace app\modules\reviews\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int|null $user_id
 * @property boolean $is_active
 * @property int $status_id
 * @property int $product_id
 * @property string $text
 * @property string|null $image
 * @property int|null $rate
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Reviews extends \yii\db\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ENABLE = 1;
    const STATUS_MODERATE = 2;

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['status_id'], 'default', 'value' => self::STATUS_MODERATE],

            [['is_active'], 'default', 'value' => true],

            [['user_id'], 'default', 'value' => Yii::$app->user->id],

            [['user_id', 'product_id', 'rate', 'created_at', 'updated_at', 'status_id'], 'integer'],

            [['product_id', 'text'], 'required'],

            [['text'], 'string'],

            [['is_active'], 'boolean'],

            [['image'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'text' => 'Ваше сообщение',
            'image' => 'Картинка',
            'rate' => 'Оценка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
