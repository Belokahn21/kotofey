<?php

namespace app\modules\user\models\entity;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\modules\site\models\tools\System;

/**
 * UserResetPassword model
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $key
 * @property integer $created_at
 * @property integer $updated_at
 *
 */
class UserResetPassword extends ActiveRecord
{
    const ALIVE_TIME = 1800;

    public function rules()
    {
        return [
            [['user_id', 'key'], 'required'],
            [['user_id'], 'integer'],
            [['key'], 'string'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function setKey()
    {
        $this->key = \Yii::$app->security->generateRandomString(7);
    }

    public function sendNotifyMessage()
    {
        if (!$user = User::findOne($this->user_id)) return false;

        $link = $this->generateRestoreLink();

        $result = Yii::$app->mailer->compose('restore-password', [
            'link' => $link
        ])
            ->setFrom([Yii::$app->params['email']['sale'] => 'kotofey.store'])
            ->setTo($user->email)
            ->setSubject('Восстановление пароля')
            ->send();

        return $result;
    }

    public function generateRestoreLink()
    {
        return System::domain() . '/restore/' . $this->key . '/';
    }

    public function isAlive()
    {
        return $this->created_at + self::ALIVE_TIME > time();
    }

    public static function findOneByCode($code)
    {
        return static::findOne(['key' => $code]);
    }
}