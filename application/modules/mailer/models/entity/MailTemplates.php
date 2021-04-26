<?php

namespace app\modules\mailer\models\entity;

use Yii;

/**
 * This is the model class for table "mail_templates".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $sort
 * @property string $name
 * @property string|null $to
 * @property string|null $from
 * @property string $code
 * @property string|null $text
 * @property string|null $event_id
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class MailTemplates extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['is_active', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code'], 'required'],
            [['text', 'event_id'], 'string'],
            [['name', 'to', 'from'], 'string', 'max' => 128],
            [['code'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Is Active',
            'sort' => 'Sort',
            'name' => 'Name',
            'to' => 'To',
            'from' => 'From',
            'code' => 'Code',
            'text' => 'Text',
            'event_id' => 'Event ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
