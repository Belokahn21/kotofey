<?php

namespace app\modules\mailer\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

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
 * @property string|null $layout
 * @property string|null $template
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class MailTemplates extends \yii\db\ActiveRecord
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

            [['name', 'code', 'event_id'], 'required'],

            [['text', 'event_id', 'layout', 'template'], 'string'],

            [['name', 'to', 'from'], 'string', 'max' => 128],

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
            'to' => 'Получатель',
            'from' => 'Отправитель',
            'code' => 'Символьный код',
            'text' => 'Текст письма',
            'event_id' => 'ID события',
            'layout' => 'Layout',
            'template' => 'Шаблон письма',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
