<?php

namespace app\modules\news\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news_comment".
 *
 * @property int $id
 * @property int|null $is_active
 * @property int|null $parent_id
 * @property int|null $author_id
 * @property string $text
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class NewsComment extends \yii\db\ActiveRecord
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

            [['is_active'], 'default', 'value' => 0],
            [['author_id'], 'default', 'value' => Yii::$app->user->id],

            [['is_active', 'parent_id', 'author_id', 'created_at', 'updated_at'], 'integer'],

            [['text'], 'required'],

            [['text'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'parent_id' => 'Родительский комментарий',
            'author_id' => 'Автор',
            'text' => 'Текст',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}
