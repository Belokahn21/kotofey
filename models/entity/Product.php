<?

namespace app\models\entity;

use app\models\behaviors\ArticleBehavior;
use mohorev\file\UploadBehavior;
use yii\base\ErrorException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * Product model
 *
 * @property integer $id
 * @property integer $article
 * @property integer $active
 * @property string $name
 * @property string $description
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $image
 * @property string $images
 * @property string $slug
 * @property integer $sort
 * @property integer $category
 * @property integer $price
 * @property integer $purchase
 * @property integer $count
 * @property boolean $vitrine
 * @property boolean $stock_id
 * @property string $code
 * @property integer $created_at
 * @property integer $updated_at
 */
class Product extends \yii\db\ActiveRecord
{

    public $imagesFiles;
    public $properties;

    const SCENARIO_NEW_PRODUCT = 'insert';
    const SCENARIO_UPDATE_PRODUCT = 'update';

    public function scenarios()
    {
        return [
            self::SCENARIO_NEW_PRODUCT => [
                'name',
                'sort',
                'category',
                'description',
                'price',
                'purchase',
                'count',
                'vitrine',
                'seo_description',
                'seo_keywords',
                'image',
                'images',
                'vitrine',
                'properties',
                'stock_id',
                'active',
                'code'
            ],
            self::SCENARIO_UPDATE_PRODUCT => [
                'name',
                'sort',
                'category',
                'description',
                'price',
                'purchase',
                'count',
                'vitrine',
                'seo_description',
                'seo_keywords',
                'image',
                'images',
                'vitrine',
                'properties',
                'stock_id',
                'active',
                'code'
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name', 'count', 'price'], 'required', 'message' => '{attribute} обязательное поле'],

            [['count', 'price', 'purchase', 'category', 'vitrine', 'stock_id', 'active'], 'integer'],

            [['images', 'code'], 'string'],

            [['vitrine'], 'default', 'value' => false],
            [['active'], 'default', 'value' => 1],


            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, webp'],
            [['imagesFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, webp', 'maxFiles' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'active' => 'Активность',
            'article' => 'Артикул',
            'name' => 'Название',
            'description' => 'Описание',
            'sort' => 'Сортировка',
            'category' => 'Раздел',
            'price' => 'Цена',
            'purchase' => 'Закупочная цена',
            'count' => 'Количество',
            'vitrine' => 'Товар витрина',
            'seo_description' => 'Описание (SEO)',
            'seo_keywords' => 'Ключые слова (SEO)',
            'image' => 'Изображение товара',
            'imageFile' => 'Изображение товара',
            'imagesFiles' => 'Галлерея фото',
            'properties' => 'Свойства',
            'stock_id' => 'Склад',
            'code' => 'Внешний код',
            'created_at' => 'Дата создания',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/',
            ],
            ArticleBehavior::className()
        ];
    }

    public function createProduct()
    {
        if (\Yii::$app->request->isPost) {
            if ($this->load(\Yii::$app->request->post())) {
                $this->uploadGallery();
                if ($this->validate()) {
                    if (!$this->save()) {
                        return false;
                    }

                    foreach ($this->properties as $propertyId => $value) {
                        if (empty($value)) {
                            continue;
                        }
                        $propertyValues = new ProductPropertiesValues();
                        $propertyValues->product_id = $this->id;
                        $propertyValues->property_id = $propertyId;
                        $propertyValues->value = $value;
                        if ($propertyValues->save() === false) {
                            return false;
                        }
                    }
                    return true;
                }
            }
        }
    }

    public function updateProduct()
    {
        if (\Yii::$app->request->isPost) {
            if ($this->load(\Yii::$app->request->post())) {
//                $this->upload();
                $this->uploadGallery();
                if ($this->validate()) {
                    if (!$this->update()) {
                        return false;
                    }
                    ProductPropertiesValues::deleteAll(['product_id' => $this->id]);
                    foreach ($this->properties as $propertyId => $value) {
                        if (empty($value)) {
                            continue;
                        }

                        $propertyValues = new ProductPropertiesValues();
                        $propertyValues->product_id = $this->id;
                        $propertyValues->property_id = $propertyId;
                        $propertyValues->value = $value;
                        if ($propertyValues->save() === false) {
                            return false;
                        }
                    }
                    return true;
                }
            }
        }
    }

    public function removeOldImage()
    {
        try {
            if (!empty($this->image)) {
                unlink(\Yii::getAlias('@app') . $this->image);
            }
        } catch (ErrorException $exception) {
        }
    }

    public function uploadGallery()
    {
        $items = [];
        $this->imagesFiles = UploadedFile::getInstances($this, 'imagesFiles');

        if (count($this->imagesFiles) > 0 && is_array($this->imagesFiles)) {

            $this->removeOldImages();

            if ($this->validate()) {
                /* @var $file UploadedFile */
                foreach ($this->imagesFiles as $file) {
                    $fileName = substr(md5($file->baseName), 0, 32) . '.' . $file->extension;
                    $path = \Yii::getAlias('@app') . '/web/upload/' . $fileName;
                    $items[] = "/web/upload/" . $fileName;
                    $file->saveAs($path);
                }

                $this->images = Json::encode($items);

                return true;
            }
        } else {
            return false;
        }
    }

    public function removeOldImages()
    {
        if (!empty($this->images)) {
            foreach (Json::decode($this->images) as $image) {
                unlink(\Yii::getAlias('@app') . $image);
            }
        }
    }

    public function getDetail()
    {
        return "/product/" . (!empty($this->slug) ? $this->slug : $this->id) . "/";
    }

    public function getDisplay()
    {
        return $this->name;
    }

    public static function findBySlug($slug)
    {
        return self::findOne(['slug' => $slug]);
    }

    public function isCommented()
    {
        return (ProductReviews::find()->where([
                'product' => $this->id,
                'user_id' => \Yii::$app->user->identity->id
            ])->count() > 0) ? true : false;
    }

    public static function countRent()
    {
        $count = 0;
        foreach (Product::find()->all() as $product) {
            $count += $product->purchase;
        }

        return $count;
    }

    public static function countProfit()
    {
        $count = 0;
        foreach (Product::find()->all() as $product) {
            $count += $product->price;
        }

        return $count;
    }
}