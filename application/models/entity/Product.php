<?php

namespace app\models\entity;

use app\models\behaviors\ArticleBehavior;
use app\models\behaviors\SocialStore;
use app\models\tool\Debug;
use mohorev\file\UploadBehavior;
use yii\base\ErrorException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\data\ActiveDataProvider;
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
 * @property string $feed
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $image
 * @property string $images
 * @property string $slug
 * @property integer $sort
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
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Category $category
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
    const SCENARIO_CREATE_EXT_PRODUCT = 'external';

    public function scenarios()
    {
        return [
            self::SCENARIO_NEW_PRODUCT => ['vendor_id', 'discount_price', 'base_price', 'name', 'sort', 'category_id', 'description', 'price', 'purchase', 'count', 'vitrine', 'seo_description', 'seo_keywords', 'image', 'images', 'vitrine', 'properties', 'stock_id', 'active', 'code', 'has_store', 'is_product_order', 'feed'],
            self::SCENARIO_UPDATE_PRODUCT => ['vendor_id', 'discount_price', 'base_price', 'name', 'sort', 'category_id', 'description', 'price', 'purchase', 'count', 'vitrine', 'seo_description', 'seo_keywords', 'image', 'images', 'vitrine', 'properties', 'stock_id', 'active', 'code', 'has_store', 'is_product_order', 'feed'],
            self::SCENARIO_CREATE_EXT_PRODUCT => ['vendor_id', 'discount_price', 'base_price', 'name', 'sort', 'category_id', 'description', 'price', 'purchase', 'count', 'vitrine', 'seo_description', 'seo_keywords', 'image', 'images', 'vitrine', 'properties', 'stock_id', 'active', 'code', 'has_store', 'is_product_order', 'feed'],
        ];
    }

    public function rules()
    {
        return [
            [['name', 'count', 'price'], 'required', 'message' => '{attribute} обязательное поле'],

            [['count', 'price', 'purchase', 'category_id', 'vitrine', 'stock_id', 'active', 'base_price', 'vendor_id', 'discount_price'], 'integer'],

            [['images', 'code', 'description', 'feed'], 'string'],

            ['description', 'string', 'min' => 10],

            [['vitrine'], 'default', 'value' => 0],
            [['active'], 'default', 'value' => 1],

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
            'active' => 'Активность',
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
            'is_product_order' => 'Товар под заказ',
            'feed' => 'Поисковой контент',
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
                    $items[] = "/upload/" . $fileName;
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

    // todo: json edit
//	public function afterFind()
//	{
//		$settings = json_decode($this->settings);
//		$this->brands = $settings->brands;
//		$this->categories = $settings->categories;
//		$this->shop_name = $settings->shop_name;
//		$this->shop_company = $settings->shop_company;
//		$this->shop_url = $settings->shop_url;
//		$this->shop_platform = $settings->shop_platform;
//		$this->shop_version = $settings->shop_version;
//		$this->shop_agency = $settings->shop_agency;
//		$this->shop_email = $settings->shop_email;
//		$this->shop_cpa = $settings->shop_cpa;
//		parent::afterFind();
//	}
//
//
//	/**
//	 * @return bool
//	 */
//	public function beforeValidate()
//	{
//		$settings = [
//			'brands' => $this->brands,
//			'categories' => $this->categories,
//			'shop_name' => $this->shop_name,
//			'shop_company' => $this->shop_company,
//			'shop_url' => $this->shop_url,
//			'shop_platform' => $this->shop_platform,
//			'shop_version' => $this->shop_version,
//			'shop_agency' => $this->shop_agency,
//			'shop_email' => $this->shop_email,
//			'shop_cpa' => $this->shop_cpa,
//		];
//		$this->settings = json_encode($settings);
//
//		return parent::beforeValidate();
//	}

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
}