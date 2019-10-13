<?

namespace app\models\entity;

use app\models\tool\Debug;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Category model
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $sort
 * @property integer $parent
 * @property integer $created_at
 * @property integer $updated_at
 */
class Category extends ActiveRecord
{
    const SCENARIO_NEW_CATEGORY = 1;
    const SCENARIO_UPDATE_CATEGORY = 2;

    public $imageFile;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
            ],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_NEW_CATEGORY => [
                'name',
                'sort',
                'parent',
                'imageFile',
                'seo_keywords',
                'seo_description',
                'image'
            ],
            self::SCENARIO_UPDATE_CATEGORY => [
                'name',
                'sort',
                'parent',
                'imageFile',
                'seo_keywords',
                'seo_description',
                'image'
            ]
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => '{attribute} должно быть заполнено'],

            [['parent', 'seo_keywords', 'seo_description', 'image'], 'string'],

            ['sort', 'integer'],

            ['parent', 'default', 'value' => '0'],

            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'sort' => 'Сортировка',
            'parent' => 'Родительский раздел',
            'imageFile' => 'Изображение',
            'seo_keywords' => 'Ключевые слова (seo)',
            'seo_description' => 'Описание (seo)',
        ];
    }

    public function createCategory()
    {
        if (\Yii::$app->request->isPost) {
            if ($this->load(\Yii::$app->request->post())) {

                $this->upload();

                if ($this->validate()) {
                    if (!$this->save()) {
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        }
    }

    public function getDetail()
    {
        return "/catalog/" . $this->slug . "/";
    }

    public function findBySlug($slug)
    {
        return self::findOne(['slug' => $slug]);
    }


    public function upload()
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        if (!empty($this->imageFile)) {

            // удалить старое фото
            $this->removeOldImage();

            $fileName = substr(md5($this->imageFile->baseName), 0, 32) . '.' . $this->imageFile->extension;
            $path = \Yii::getAlias('@app') . '/web/upload/' . $fileName;

            $this->imageFile->saveAs($path);
            $this->image = "/web/upload/" . $fileName;

            $this->imageFile = "";
        }
    }

    public function removeOldImage()
    {
        if (!empty($this->image)) {
            try {
                unlink(\Yii::getAlias('@app') . $this->image);
            } catch (\ErrorException $exception) {
            }
        }
    }

    public $items;

    public function categoryTree($parent_id = 0, $delim = "")
    {
        $categories = \app\models\entity\Category::find()->where(['parent' => $parent_id])->all();

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
        if (is_null($parent_id)) {
            $parent_id = $this->id;
            $category = Category::findOne($parent_id);
        } else {

            $category = Category::findOne(['parent' => $parent_id]);
        }
        if ($category) {
            $this->subsections[] = $category;
            $this->subsections($category->id);
        }
        return $this->subsections;
    }
}