<?php

namespace app\modules\reviews\models\entity;

use app\modules\user\models\entity\User;
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
 * @property string $pluses
 * @property string $minuses
 * @property string $email
 * @property integer $phone
 * @property string|null $image
 * @property int|null $rate
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $author
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

            [['user_id', 'product_id', 'rate', 'created_at', 'updated_at', 'status_id','phone'], 'integer'],

            [['product_id', 'text'], 'required'],

            [['text', 'pluses', 'minuses','email'], 'string'],

            [['is_active'], 'boolean'],

            [['image'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'user_id' => 'Пользователь ID',
            'status_id' => 'Статус ID',
            'product_id' => 'Продукт ID',
            'text' => 'Ваше сообщение',
            'pluses' => 'Приемущества',
            'minuses' => 'Недостатки',
            'image' => 'Картинка',
            'rate' => 'Оценка',
            'phone' => 'Телефон',
            'email' => 'Почта',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function getStatusList()
    {
        return [
            self::STATUS_ENABLE => 'Активен',
            self::STATUS_MODERATE => 'На модерации',
            self::STATUS_OFF => 'На отклонен',
        ];
    }

    public function getRates()
    {
        return [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5];
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
