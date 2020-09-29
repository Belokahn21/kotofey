<?php

namespace app\modules\logger\models\entity;

use Yii;

/**
 * This is the model class for table "logger".
 *
 * @property int $id
 * @property string $message
 * @property int $uniqCode
 * @property int $created_at
 * @property int $updated_at
 */
class Logger extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'logger';
    }

    public function rules()
    {
        return [
            [['message', 'uniqCode'], 'required'],
            [['message'], 'string'],
            [['uniqCode', 'created_at', 'updated_at'], 'integer'],
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
        ];
    }
}
