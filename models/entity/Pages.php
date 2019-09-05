<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 23:23
 */

namespace app\models\entity;


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
class Pages extends ActiveRecord
{

    public $preview_image_file;
    public $detail_image_file;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true,
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

            [['preview_image_file', 'detail_image_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
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

    public function savePreviewPicture()
    {
        $this->preview_image_file = UploadedFile::getInstance($this, 'preview_image_file');
        if (!empty($this->preview_image_file)) {

            // удалить старое фото
            $this->removeOldPreviewImage();

            $fileName = substr(md5($this->preview_image_file->baseName), 0,
                    32) . '.' . $this->preview_image_file->extension;
            $path = \Yii::getAlias('@app') . '/web/upload/' . $fileName;

            $this->preview_image_file->saveAs($path);
            $this->preview_image = "/web/upload/" . $fileName;

            $this->preview_image_file = null;
        }
        return true;
    }

    public function removeOldPreviewImage()
    {
        if (!empty($this->preview_image)) {
            unlink(\Yii::getAlias('@app') . $this->preview_image);
        }
    }

    public function saveDetailPicture()
    {
        $this->detail_image_file = UploadedFile::getInstance($this, 'detail_image_file');
        if (!empty($this->detail_image_file)) {

            // удалить старое фото
            $this->removeOldDetailImage();

            $fileName = substr(md5($this->detail_image_file->baseName), 0,
                    32) . '.' . $this->detail_image_file->extension;
            $path = \Yii::getAlias('@app') . '/web/upload/' . $fileName;

            $this->detail_image_file->saveAs($path);
            $this->detail_image = "/web/upload/" . $fileName;

            $this->detail_image_file = null;
        }
        return true;
    }

    public function removeOldDetailImage()
    {
        if (!empty($this->detail_image)) {
            unlink(\Yii::getAlias('@app') . $this->detail_image);
        }
    }

    public function getDetailurl()
    {
        return "/articles/" . $this->slug . "/";
    }

    public static function findBySlug($slug)
    {
        return static::findOne(['slug' => $slug]);
    }
}