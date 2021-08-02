<?php

namespace app\modules\mailer\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "mail_history".
 *
 * @property int $id
 * @property int|null $mail_template_id
 * @property string|null $email
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class MailHistory extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['mail_template_id', 'created_at', 'updated_at'], 'integer'],
            [['email'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mail_template_id' => 'Mail Template ID',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
