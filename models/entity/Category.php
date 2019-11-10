<?

namespace app\models\entity;

use app\models\tool\Debug;
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
 * @property string $image
 * @property string $slug
 * @property integer $sort
 * @property integer $parent
 * @property integer $created_at
 * @property integer $updated_at
 */
class Category extends ActiveRecord
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
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => '{attribute} должно быть заполнено'],

            [['parent', 'seo_keywords', 'seo_description', 'image'], 'string'],

            ['sort', 'integer'],

            ['parent', 'default', 'value' => '0'],

            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'sort' => 'Сортировка',
            'parent' => 'Родительский раздел',
            'image' => 'Изображение',
            'seo_keywords' => 'Ключевые слова (seo)',
            'seo_description' => 'Описание (seo)',
        ];
    }

    public function getDetail()
    {
        return "/catalog/" . $this->slug . "/";
    }

    public static function findBySlug($slug)
    {
        return static::findOne(['slug' => $slug]);
    }

    public function search($params)
    {
        $query = static::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
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