<?php

namespace app\modules\news\models\entity;


use mohorev\file\UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * News model
 *
 * @property integer $id
 * @property boolean $is_active
 * @property string $title
 * @property string $slug
 * @property string $preview
 * @property string $preview_image
 * @property string $detail
 * @property string $detail_image
 * @property integer $sort
 * @property integer $category
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property string $detailurl
 * @property NewsCategory $categoryModel
 */
class News extends ActiveRecord
{
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

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
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/',
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'detail_image',
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['title'], 'required', 'message' => "{attribute} обязательное"],

            [
                ['title', 'preview', 'detail', 'seo_keywords', 'seo_description'],
                'string',
                'message' => "{attribute} должен быть строкой"
            ],

            ['sort', 'default', 'value' => 500],

            [['category', 'is_active'], 'integer'],

            [['preview_image', 'detail_image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
        ];
    }

    public function attributeLabels()
    {
        return [
            "is_active" => 'Активность',
            "title" => 'Заголовок',
            "slug" => 'Символьный код',
            "preview" => 'Краткое описание',
            "detail" => 'Текст страницы',
            "category" => 'Раздел',
            "seo_keywords" => '(SEO) Ключи',
            "seo_description" => '(SEO) Описание',
            "created_at" => 'Дата создания',
            "preview_image_file" => 'Изображение анонса',
            "detail_image_file" => 'Детальное изображение',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_INSERT => ['title', 'sort', 'preview', 'detail', 'category', 'seo_keywords', 'seo_description', 'created_at', 'preview_image', 'detail_image', 'is_active'],
            self::SCENARIO_UPDATE => ['title', 'sort', 'preview', 'detail', 'category', 'seo_keywords', 'seo_description', 'created_at', 'preview_image', 'detail_image', 'is_active']
        ];
    }

    public function getDetailurl()
    {
        return "/news/" . $this->slug . "/";
    }

    public function getCategoryModel()
    {
        return $this->hasOne(NewsCategory::className(), ['id' => 'category']);
    }

    public static function findBySlug($slug)
    {
        return static::findOne(['slug' => $slug]);
    }

    public function hasAccess()
    {
        return (boolean)$this->is_active || \Yii::$app->user->id == 1;
//        return \Yii::$app->user->id != 1 && (boolean) $this->is_active;
    }
}