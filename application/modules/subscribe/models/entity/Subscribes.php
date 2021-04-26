<?php

namespace app\modules\subscribe\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "subscribes".
 *
 * @property int $id
 * @property string $email
 * @property int $active
 * @property int $created_at
 * @property int $updated_at
 */
class Subscribes extends \yii\db\ActiveRecord
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
            [['email', 'active'], 'required'],

            [['active', 'created_at', 'updated_at'], 'integer'],

            [['email'], 'string', 'max' => 255],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
