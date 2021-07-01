<?php

namespace app\modules\promotion\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "promotion_mail_history".
 *
 * @property int $id
 * @property int $promotion_id
 * @property string|null $email
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class PromotionMailHistory extends \yii\db\ActiveRecord
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
            [['promotion_id'], 'required'],

            [['promotion_id', 'created_at', 'updated_at'], 'integer'],

            [['email'], 'string', 'max' => 255],

            ['email', 'unique', 'targetAttribute' => ['email', 'promotion_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promotion_id' => 'ID акции',
            'email' => 'Почта',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
