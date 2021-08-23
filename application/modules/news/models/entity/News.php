<?php

namespace app\modules\news\models\entity;

use app\modules\user\models\entity\User;
use mohorev\file\UploadBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int|null $detail_media_id
 * @property int|null $preview_media_id
 * @property int|null $created_user_id
 * @property int|null $author_id
 * @property int|null $is_active
 * @property string $title
 * @property string $slug
 * @property int $sort
 * @property int|null $category_id
 * @property string $preview
 * @property string|null $preview_image
 * @property string $detail
 * @property string|null $detail_image
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $author
 * @property NewsCategory $category
 */
class News extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true,
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'preview_image',
                'scenarios' => ['default'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/',
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'detail_image',
                'scenarios' => ['default'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['created_user_id'], 'default', 'value' => Yii::$app->user->id],

            [['detail_media_id', 'preview_media_id', 'created_user_id', 'author_id', 'is_active', 'sort', 'category_id', 'created_at', 'updated_at'], 'integer'],

            [['title'], 'required'],

            [['preview', 'detail'], 'string'],

            [['title', 'slug', 'preview_image', 'detail_image', 'seo_keywords', 'seo_description'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'detail_media_id' => 'Детальная картинка',
            'preview_media_id' => 'Картинка превью',
            'created_user_id' => 'Кто создал',
            'author_id' => 'Автор статьи',
            'is_active' => 'Активность',
            'title' => 'Заголовок',
            'slug' => 'Символьный код',
            'sort' => 'Сортировка',
            'category_id' => 'Категория',
            'preview' => 'Превью текст',
            'preview_image' => 'Превью картинка',
            'detail' => 'Детальное описание',
            'detail_image' => 'Дательная картинка',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public static function findBySlug($slug)
    {
        return static::findOne(['slug' => $slug]);
    }

    public function hasAccess()
    {
        return Yii::$app->user->id == 1;
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(NewsCategory::className(), ['id' => 'category_id']);
    }
}
