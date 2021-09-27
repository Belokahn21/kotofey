<?php

namespace app\modules\catalog\models\entity;

use app\modules\catalog\models\helpers\ProductCategoryHelper;
use app\modules\site\models\tools\Debug;
use mohorev\file\UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\caching\DbDependency;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Category model
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property string $image
 * @property string $slug
 * @property integer $sort
 * @property integer $parent_category_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductCategory[] $childs
 * @property ProductCategory $parent
 */
class ProductCategory extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['default'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/',
            ],
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
                'immutable' => true
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => '{attribute} должно быть заполнено'],

            [['seo_keywords', 'seo_description', 'description', 'seo_title'], 'string'],

            [['sort', 'parent_category_id'], 'integer'],

            ['parent_category_id', 'default', 'value' => '0'],

            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'slug' => 'Символьный код',
            'description' => 'Описание',
            'sort' => 'Сортировка',
            'parent_category_id' => 'Родительский раздел',
            'image' => 'Изображение',
            'seo_title' => 'Заголовок (seo)',
            'seo_keywords' => 'Ключевые слова (seo)',
            'seo_description' => 'Описание (seo)',
        ];
    }

    public static function findBySlug($slug)
    {
        return static::findOne(['slug' => $slug]);
    }

    public function getChilds()
    {
        return $this->hasMany(ProductCategory::className(), ['parent_category_id' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'parent_category_id']);
    }

    public function extraFields()
    {
        return [
            'image' => function ($model) {
                return ProductCategoryHelper::getImageUrl($model, true);
            },
            'url' => function ($model) {
                return ProductCategoryHelper::getDetailUrl($model);
            },
        ];
    }
}