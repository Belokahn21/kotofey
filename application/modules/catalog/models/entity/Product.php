<?php

namespace app\modules\catalog\models\entity;

use app\modules\catalog\models\behaviors\ArticleBehavior;
use app\modules\catalog\models\behaviors\SocialStore;
use app\modules\media\components\behaviors\ImageUploadMinify;
use app\modules\media\models\entity\Media;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * Product model
 *
 * @property integer $id
 * @property integer $article
 * @property string $name
 * @property string $description
 * @property string $feed
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $image
 * @property integer $media_id
 * @property string $images
 * @property string $slug
 * @property integer $sort
 * @property integer $status_id
 * @property integer $is_ali
 * @property integer $category_id
 * @property integer $vendor_id
 * @property integer $discount_price
 * @property integer $price
 * @property integer $base_price
 * @property integer $purchase
 * @property integer $count
 * @property boolean $vitrine
 * @property boolean $stock_id
 * @property string $code
 * @property string $barcode
 * @property string $threeDCode
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Category $category
 * @property string $detail
 * @property Media $media
 */
class Product extends \yii\db\ActiveRecord
{
    public $has_store;
    public $imagesFiles;
    public $properties;
    public $is_product_order;
    public $prop_sales;

    const SCENARIO_NEW_PRODUCT = 'insert';
    const SCENARIO_UPDATE_PRODUCT = 'update';
//    const SCENARIO_CREATE_EXT_PRODUCT = 'external';

    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public function scenarios()
    {
        return [
            self::SCENARIO_NEW_PRODUCT => ['is_ali', 'barcode', 'status_id', 'threeDCode', 'vendor_id', 'discount_price', 'base_price', 'name', 'sort', 'category_id', 'description', 'price', 'purchase', 'count', 'vitrine', 'seo_description', 'seo_keywords', 'image', 'images', 'vitrine', 'properties', 'stock_id', 'code', 'has_store', 'is_product_order', 'feed'],
            self::SCENARIO_UPDATE_PRODUCT => ['is_ali', 'barcode', 'status_id', 'threeDCode', 'vendor_id', 'discount_price', 'base_price', 'name', 'sort', 'category_id', 'description', 'price', 'purchase', 'count', 'vitrine', 'seo_description', 'seo_keywords', 'image', 'images', 'vitrine', 'properties', 'stock_id', 'code', 'has_store', 'is_product_order', 'feed'],
//            self::SCENARIO_CREATE_EXT_PRODUCT => ['barcode', 'status_id', 'threeDCode', 'vendor_id', 'discount_price', 'base_price', 'name', 'sort', 'category_id', 'description', 'price', 'purchase', 'count', 'vitrine', 'seo_description', 'seo_keywords', 'image', 'images', 'vitrine', 'properties', 'stock_id', 'code', 'has_store', 'is_product_order', 'feed'],
        ];
    }

    public function rules()
    {
        return [
            [['name', 'count', 'price'], 'required', 'message' => '{attribute} обязательное поле'],

            [['count', 'price', 'purchase', 'category_id', 'vitrine', 'stock_id', 'base_price', 'vendor_id', 'discount_price', 'status_id', 'is_ali'], 'integer'],

            [['images', 'code', 'description', 'feed', 'threeDCode'], 'string'],

            ['barcode', 'string', 'max' => 255],

            ['description', 'string', 'min' => 10],

            [['vitrine', 'is_ali'], 'default', 'value' => 0],

            [['has_store', 'is_product_order'], 'boolean'],

            ['code', 'unique', 'message' => 'Такой внешний код уже используется'],

            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
            [['imagesFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions'], 'maxFiles' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article' => 'Артикул',
            'name' => 'Название',
            'description' => 'Описание',
            'sort' => 'Сортировка',
            'category_id' => 'Раздел',
            'category' => 'Раздел',
            'price' => 'Цена',
            'purchase' => 'Закупочная цена',
            'base_price' => 'Базовая цена',
            'discount_price' => 'Цена со скидкой',
            'count' => 'Количество',
            'vitrine' => 'Товар витрина',
            'seo_description' => 'Описание (SEO)',
            'seo_keywords' => 'Ключые слова (SEO)',
            'image' => 'Изображение товара',
            'imageFile' => 'Изображение товара',
            'imagesFiles' => 'Галлерея фото',
            'properties' => 'Свойства',
            'stock_id' => 'Склад',
            'vendor_id' => 'Поставщик',
            'code' => 'Внешний код',
            'has_store' => 'Сохранить в маркете Вконтакте',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'is_product_order' => 'Товар под заказ',
            'feed' => 'Поисковой контент',
            'threeDCode' => '3D представление',
            'status_id' => 'Статус товара',
            'barcode' => 'Штрих-код',
            'is_ali' => 'Размещается на Aliexpress',
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
                'class' => ImageUploadMinify::class,
                'attribute' => 'image',
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/upload/',
                'url' => '@web/upload/'
            ],
            [
                'class' => SocialStore::class,
                'has_store' => 'has_store',
            ],
            ArticleBehavior::className()
        ];
    }

    public function createProduct()
    {
        if (\Yii::$app->request->isPost) {
            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();
            if ($this->load(\Yii::$app->request->post())) {
                $this->uploadGallery();
                if ($this->validate()) {
                    if (!$this->save()) {
                        $transaction->rollBack();
                        return false;
                    }

                    foreach ($this->properties as $propertyId => $value) {
                        if (empty($value)) {
                            continue;
                        }
                        //save multiple property
                        if (is_array($value) && count($value) > 0) {
                            foreach ($value as $select_variant) {
                                $propertyValues = new ProductPropertiesValues();
                                $propertyValues->product_id = $this->id;
                                $propertyValues->property_id = $propertyId;
                                $propertyValues->value = $select_variant;
                                if ($propertyValues->save() === false) {
                                    return false;
                                }
                            }
                        } else {
                            $propertyValues = new ProductPropertiesValues();
                            $propertyValues->product_id = $this->id;
                            $propertyValues->property_id = $propertyId;
                            $propertyValues->value = $value;
                            if ($propertyValues->save() === false) {
                                $transaction->rollBack();
                                return false;
                            }
                        }
                    }


                    if ($this->is_product_order == true) {
                        $productOrder = new ProductOrder();
                        $productOrder->product_id = $this->id;
                        if ($productOrder->load(\Yii::$app->request->post())) {
                            if ($productOrder->validate()) {
                                if (!$productOrder->save()) {
                                    $transaction->rollBack();
                                    return false;
                                }
                            }
                        }
                    }

                    $transaction->commit();
                    return true;
                }
            }
        }

        return false;
    }

    public function updateProduct()
    {
        if (\Yii::$app->request->isPost) {
            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();
            if ($this->load(\Yii::$app->request->post())) {
                $this->uploadGallery();
                if ($this->validate()) {
                    if (!$this->update()) {
                        return false;
                    }

                    if ($this->properties) {

                        ProductPropertiesValues::deleteAll(['product_id' => $this->id]);

                        foreach ($this->properties as $propertyId => $value) {
                            if (empty($value)) {
                                continue;
                            }

                            //save multiple property
                            if (is_array($value) && count($value) > 0) {
                                foreach ($value as $select_variant) {
                                    $propertyValues = new ProductPropertiesValues();
                                    $propertyValues->product_id = $this->id;
                                    $propertyValues->property_id = $propertyId;
                                    $propertyValues->value = $select_variant;
                                    if ($propertyValues->save() === false) {
                                        $transaction->rollBack();
                                        return false;
                                    }
                                }
                            } else {


                                $propertyValues = new ProductPropertiesValues();
                                $propertyValues->product_id = $this->id;
                                $propertyValues->property_id = $propertyId;
                                $propertyValues->value = $value;
                                if ($propertyValues->save() === false) {
                                    $transaction->rollBack();
                                    return false;
                                }
                            }
                        }
                    }

                    if ($this->is_product_order == true) {

                        $is_new_record = false;

                        if (!$productOrder = ProductOrder::findOneByProductId($this->id)) {
                            $productOrder = new ProductOrder();
                            $is_new_record = true;
                        }

                        $productOrder->product_id = $this->id;
                        if ($productOrder->load(\Yii::$app->request->post())) {
                            if ($productOrder->validate()) {

                                if ($is_new_record) {
                                    if (!$productOrder->save()) {
                                        $transaction->rollBack();
                                        return false;
                                    }
                                } else {
                                    if ($productOrder->update() === false) {
                                        $transaction->rollBack();
                                        return false;
                                    }
                                }
                            }
                        }
                    }


                    $transaction->commit();

                    return true;
                }
            }
        }
        return false;
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
                    if ($file->saveAs($path)) {
                        $items[] = "/upload/" . $fileName;
                    }
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
                @unlink(\Yii::getAlias('@app') . $image);
            }
        }
    }

    public function getDetail()
    {
        return Url::to(['/catalog/product/view', 'id' => $this->slug]);
    }

    public function getDisplay()
    {
        return $this->name;
    }

    public static function findBySlug($slug)
    {
        return self::findOne(['slug' => $slug]);
    }

    public function getCategory()
    {
        if ($this->category_id) {
            return Category::findOne($this->category_id);
        }

        $category = new Category();
        $category->name = 'Без категории';

        return $category;
    }

    public static function findOneByCode($code)
    {
        return static::findOne(['code' => $code]);
    }

    public static function findOneBySlug($slug)
    {
        return static::findOne(['slug' => $slug]);
    }

    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }

    public function getStatusList()
    {
        return [
            self::STATUS_DRAFT => "Черновик",
            self::STATUS_ACTIVE => "Активен",
        ];
    }
}