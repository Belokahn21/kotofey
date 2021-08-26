<?php

namespace app\modules\catalog\models\entity;

use app\modules\catalog\models\behaviors\ArticleBehavior;
use app\modules\catalog\models\behaviors\ElasticSearchBehavior;
use app\modules\catalog\models\behaviors\SocialStore;
use app\modules\catalog\models\helpers\CompositionProductHelper;
use app\modules\catalog\models\helpers\PriceHelper;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\helpers\ProductPriceHelper;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;
use app\modules\catalog\models\helpers\ProductStockHelper;
use app\modules\catalog\models\helpers\ProductToBreadHelper;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\media\components\behaviors\ImageUploadMinify;
use app\modules\media\models\entity\Media;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\reviews\models\entity\Reviews;
use app\modules\site\models\behaviors\UserEntityBehavior;
use app\modules\site\models\tools\Debug;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UploadedFile;
use function foo\func;

/**
 * Product model
 *
 * @property integer $id
 * @property integer $created_user_id
 * @property integer $updated_user_id
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
 * @property integer $category_id
 * @property integer $vendor_id
 * @property integer $discount_price
 * @property integer $price
 * @property integer $base_price
 * @property integer $purchase
 * @property integer $count
 * @property boolean $vitrine
 * @property string $code
 * @property string $ident_key
 * @property string $barcode
 * @property string $threeDCode
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductCategory $category
 * @property string $detail
 * @property Media $media
 * @property PropertiesProductValues $propsValues
 * @property Reviews[] $comments
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
    const SCENARIO_STOCK_COUNT = 'stock';

    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;

    public function scenarios()
    {
        $parent = parent::scenarios();

        $parent[self::SCENARIO_NEW_PRODUCT] = ['ident_key','created_user_id', 'updated_user_id', 'slug', 'media_id', 'barcode', 'status_id', 'threeDCode', 'vendor_id', 'discount_price', 'base_price', 'name', 'sort', 'category_id', 'description', 'price', 'purchase', 'count', 'vitrine', 'seo_description', 'seo_keywords', 'image', 'images', 'properties', 'code', 'has_store', 'is_product_order', 'feed'];
        $parent[self::SCENARIO_UPDATE_PRODUCT] = ['ident_key','created_user_id', 'updated_user_id', 'slug', 'media_id', 'barcode', 'status_id', 'threeDCode', 'vendor_id', 'discount_price', 'base_price', 'name', 'sort', 'category_id', 'description', 'price', 'purchase', 'count', 'vitrine', 'seo_description', 'seo_keywords', 'image', 'images', 'properties', 'code', 'has_store', 'is_product_order', 'feed'];
        $parent[self::SCENARIO_STOCK_COUNT] = ['price', 'count', 'purchase', 'discount_price', 'base_price'];

        return $parent;
    }

    public function rules()
    {
        return [
            [['name', 'count', 'price'], 'required', 'message' => '{attribute} обязательное поле'],

            [['count', 'price', 'purchase', 'category_id', 'vitrine', 'base_price', 'vendor_id', 'discount_price', 'status_id', 'media_id', 'created_user_id', 'updated_user_id'], 'integer'],

            [['images', 'code', 'description', 'feed', 'threeDCode'], 'string'],

            ['barcode', 'string', 'max' => 255],

            ['name', 'string', 'max' => 128],

            ['description', 'string', 'min' => 10],

            [['vitrine'], 'default', 'value' => 1],

            [['has_store', 'is_product_order'], 'boolean'],

            [['code', 'slug', 'barcode','ident_key'], 'unique', 'message' => 'Такой {attribute} уже используется'],

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
            'vendor_id' => 'Поставщик',
            'code' => 'Внешний код',
            'ident_key' => 'Специальный ключ',
            'has_store' => 'Сохранить в маркете Вконтакте',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'is_product_order' => 'Товар под заказ',
            'feed' => 'Поисковой контент',
            'threeDCode' => '3D представление',
            'status_id' => 'Статус товара',
            'barcode' => 'Штрих-код',
            'media_id' => 'Изображение',
            'created_user_id' => 'Кем создано',
            'updated_user_id' => 'Кем обновлено',
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
                'immutable' => true
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
            ArticleBehavior::className(),
            [
                'class' => UserEntityBehavior::className(),
                'attr_at_save' => 'created_user_id',
                'attr_at_update' => 'updated_user_id',
            ],
            ElasticSearchBehavior::className()
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

                    if ($this->properties) ProductPropertiesValuesHelper::saveProductProperties($this->properties, $this->id);
                    ProductStockHelper::saveItems($this->id);
                    CompositionProductHelper::saveItems($this->id);
                    ProductPriceHelper::saveItems($this->id);
                    ProductToBreadHelper::saveItems($this->id);

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

                    if ($this->properties) ProductPropertiesValuesHelper::saveProductProperties($this->properties, $this->id);

                    ProductStockHelper::saveItems($this->id);
                    CompositionProductHelper::saveItems($this->id);
                    ProductPriceHelper::saveItems($this->id);
                    ProductToBreadHelper::saveItems($this->id);

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

    public static function findBySlug($slug)
    {
        return self::findOne(['slug' => $slug]);
    }

    public function getCategory()
    {
        if ($this->category_id) {
            return ProductCategory::findOne($this->category_id);
        }

        $category = new ProductCategory();
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

    public function getPurchase()
    {
        $price = PriceHelper::getPriceByCode($this->id, 'purchase');
        if ($price) return $price->value;
        return $this->purchase;
    }

    public function getPrice()
    {
        $price = PriceHelper::getPriceByCode($this->id, 'sale');
        if ($price) return $price->value;
        return $this->price;
    }

    public function getDiscountPrice()
    {

        $action = \Yii::$app->cache->getOrSet('PromotionProductMechanics-' . $this->id, function () {
            return PromotionProductMechanics::find()->where(['product_id' => $this->id])->joinWith('promotion')->andWhere([
                'or',
                'promotion.start_at = :default and promotion.end_at = :default',
                'promotion.start_at is null and promotion.end_at is null',
                'promotion.start_at < :now and promotion.end_at > :now'
            ])->andWhere(['promotion.is_active' => true])
                ->addParams([
                    ":now" => time(),
                    ":default" => 0,
                ])
                ->one();
        });


        if ($action) $this->discount_price = round($this->price - ($this->price * ($action->amount / 100)));

        return $this->discount_price;
    }

    public function getStatusList()
    {
        return [
            self::STATUS_DRAFT => "Черновик",
            self::STATUS_WAIT => "Ожидается",
            self::STATUS_ACTIVE => "Активен",
        ];
    }

    public function getPropsValues()
    {
        return $this->hasMany(PropertiesProductValues::className(), ['product_id' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(Reviews::className(), ['product_id' => 'id'])->where(['status_id' => Reviews::STATUS_ENABLE, 'is_active' => true]);
    }

    public function extraFields()
    {
        return [
            'href' => function ($model) {
                return ProductHelper::getDetailUrl($model);
            },
            'discount_price' => function ($model) {
                return $model->getDiscountPrice();
            },
            'backendHref' => function ($model) {
                return Url::to(['/admin/catalog/product-backend/update', 'id' => $model->id]);
            },
            'imageUrl' => function ($model) {
                return ProductHelper::getImageUrl($model);
            },
            'weight' => function ($model) {
                try {
                    return PropertiesHelper::extractPropertyById($model, PropertiesHelper::PROPERTY_WEIGHT)->value;
                } catch (\Exception $exception) {
                    return false;
                }
            },
            'width' => function ($model) {
                try {
                    return PropertiesHelper::extractPropertyById($model, PropertiesHelper::PROPERTY_WIDTH)->value;
                } catch (\Exception $exception) {
                    return false;
                }
            },
            'height' => function ($model) {
                try {
                    return PropertiesHelper::extractPropertyById($model, PropertiesHelper::PROPERTY_HEIGHT)->value;
                } catch (\Exception $exception) {
                    return false;
                }
            },
            'length' => function ($model) {
                try {
                    return PropertiesHelper::extractPropertyById($model, PropertiesHelper::PROPERTY_LENGTH)->value;
                } catch (\Exception $exception) {
                    return false;
                }
            },
        ];
    }
}