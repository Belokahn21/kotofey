<?php

namespace app\modules\mailer\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "mail_events".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $sort
 * @property string $name
 * @property string $code
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class MailEvents extends \yii\db\ActiveRecord
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
            [['sort'], 'default', 'value' => 500],

            [['is_active'], 'default', 'value' => true],
            [['is_active'], 'boolean'],

            [['sort', 'created_at', 'updated_at'], 'integer'],

            [['name', 'code'], 'required'],

            [['name'], 'string', 'max' => 128],

            [['code'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'name' => 'Название',
            'code' => 'Символьный код',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
