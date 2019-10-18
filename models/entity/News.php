<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 23:23
 */

namespace app\models\entity;


use mohorev\file\UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Pages model
 *
 * @property integer $id
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
 */
class News extends ActiveRecord
{
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return "pages";
    }

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

            [['category'], 'integer'],

            [['preview_image', 'detail_image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            "title" => 'Заголовок',
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
            self::SCENARIO_INSERT => [
                'title',
                'preview',
                'detail',
                'category',
                'seo_keywords',
                'seo_description',
                'created_at',
                'preview_image',
                'detail_image',
            ],
            self::SCENARIO_UPDATE => [
                'title',
                'preview',
                'detail',
                'category',
                'seo_keywords',
                'seo_description',
                'created_at',
                'preview_image',
                'detail_image',
            ]
        ];
    }

    public function getDetailurl()
    {
        return "/news/" . $this->slug . "/";
    }

    public static function findBySlug($slug)
    {
        return static::findOne(['slug' => $slug]);
    }
}