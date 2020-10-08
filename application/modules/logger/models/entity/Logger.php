<?php

namespace app\modules\logger\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "logger".
 *
 * @property int $id
 * @property string $message
 * @property int $status
 * @property int $uniqCode
 * @property int $created_at
 * @property int $updated_at
 */
class Logger extends \yii\db\ActiveRecord
{
    const STATUS_SUCCESS = 200;
    const STATUS_ERROR = 500;
    const STATUS_WARNING = 400;

    public static function tableName()
    {
        return 'logger';
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
            [['message', 'uniqCode'], 'required'],
            [['message', 'uniqCode'], 'string'],
            [['status'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Сообщение',
            'uniqCode' => 'Уникальный код',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'status' => 'Статус',
        ];
    }

    public function saveMessage($message, $code, $status = self::STATUS_SUCCESS)
    {
        $this->message = $message;
        $this->uniqCode = $code;
        $this->status = $status;

        if (!$this->validate()) {
            return false;
        }
        if (!$this->save()) {
            return false;
        }

        return true;
    }
}
