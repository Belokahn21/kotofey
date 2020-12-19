<?php

namespace app\modules\catalog\models\entity;

use app\modules\site\models\tools\Debug;
use mohorev\file\UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
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
 * @property integer $parent
 * @property integer $created_at
 * @property integer $updated_at
 */
class Category extends ActiveRecord
{
    public static function tableName()
    {
        return "product_category";
    }

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
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => '{attribute} должно быть заполнено'],

            [['parent', 'seo_keywords', 'seo_description', 'description', 'seo_title'], 'string'],

            ['sort', 'integer'],

            ['parent', 'default', 'value' => '0'],

            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'sort' => 'Сортировка',
            'parent' => 'Родительский раздел',
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

    public $items;

    public function categoryTree($parent_id = 0, $delim = "")
    {
        $categories = Category::find()->select(['id', 'name', 'parent'])->where(['parent' => $parent_id])->all();

        if ($categories) {

            foreach ($categories as &$category) {
                $category->name = $delim . $category->name;
                $this->items[] = $category;
                self::categoryTree($category->id, $delim . '---');
            }

        }

        return $this->items;
    }

    public $subsections;

    public function subsections($parent_id = null)
    {
        $cache = \Yii::$app->cache;
        $current_category_id = $this->id;
        if ($parent_id) {
            $current_category_id = $parent_id;
        } else {

            $this->subsections[] = $cache->getOrSet('subsection-' . $current_category_id, function () use ($current_category_id) {
                return Category::findOne($current_category_id);
            });
        }

//        $categories = $cache->getOrSet('subsections', function () use ($current_category_id) {
//            return Category::find()->where(['parent' => $current_category_id])->all();
//        });
        $categories = Category::find()->where(['parent' => $current_category_id])->all();

        if ($categories) {
            foreach ($categories as $category) {
                $this->subsections[] = $category;
                $this->subsections($category->id);
            }
        }

        return $this->subsections;
    }

    public $under_sections;

    public function undersections($parent_id = null)
    {
        if ($parent_id === null) {
            $parent_id = $this->id;
        }
        $category = Category::findOne($parent_id);

        if ($category) {
            $this->under_sections[] = $category;
            $this->undersections($category->parent);
        }

        return array_reverse($this->under_sections);
    }
}