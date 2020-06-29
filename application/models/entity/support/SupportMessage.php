<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 2:01
 */

namespace app\models\entity\support;


use app\modules\user\models\entity\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * SupportMessage model
 *
 * @property integer $id
 * @property integer $ticket_id
 * @property integer $user_id
 * @property string $text
 * @property integer  $created_at
 * @property integer  $updated_at
 *
 * @property User $user
 */

class SupportMessage extends ActiveRecord
{
    public static function tableName()
    {
        return "support_message";
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
            [['text'], 'required', 'message' => 'Поле {attribute} должно быть заполнено'],

            ['user_id', 'default', 'value' => \Yii::$app->user->identity->id],

            [['user_id', 'ticket_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Сообщение',
        ];
    }

    public function getUser()
    {
        return User::findOne($this->user_id);
    }
}