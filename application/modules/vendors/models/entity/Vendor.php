<?php

namespace app\modules\vendors\models\entity;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "vendor".
 *
 * @property int $id
 * @property int $is_active
 * @property int $sort
 * @property string $name
 * @property string $slug
 * @property string $address
 * @property string $delivery_days
 * @property string $email
 * @property string $phone
 * @property string $type_price
 * @property string $notes
 * @property int $group_id
 * @property int $discount
 * @property int $min_summary_sale
 * @property int $time_open
 * @property int $time_close
 * @property int $how_send_order
 * @property int $created_at
 * @property int $updated_at
 */
class Vendor extends \yii\db\ActiveRecord
{

    const SEND_ORDER_VARIANT_WA = 1;
    const SEND_ORDER_VARIANT_EMAIL = 2;

    
    const VENDOR_ID_PURINA = 1;
    const VENDOR_ID_MARS = 2;
    const VENDOR_ID_ROYAL = 3;
    const VENDOR_ID_SIBAGRO = 4;
    const VENDOR_ID_HILLS = 5;
    const VENDOR_ID_ZOO_ALFA = 6;
    const VENDOR_ID_FORZA = 7;
    const VENDOR_ID_SANABELLE = 8;
    const VENDOR_ID_SIBMARKET = 9;
    const VENDOR_ID_VALTA = 10;
    const VENDOR_ID_TAVELA = 12;
    const VENDOR_ID_LIVERA = 14;
    const VENDOR_ID_MURKEL = 15;
    const VENDOR_ID_LUKAS = 16;

    const TYPE_PRICE_BASE = 'base';
    const TYPE_PRICE_PURCHASE = 'purchase';

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

    public function rules()
    {
        return [
            [['is_active', 'sort', 'group_id', 'created_at', 'updated_at', 'discount', 'time_open', 'time_close', 'min_summary_sale', 'phone', 'how_send_order'], 'integer'],

            [['name'], 'required'],

            [['name', 'slug', 'address', 'legal_name', 'type_price'], 'string', 'max' => 255],

            [['email', 'notes'], 'string'],

            [['delivery_days'], 'safe'],

            [['email'], 'email'],

            ['how_send_order', 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активность',
            'sort' => 'Сортировка',
            'name' => 'Название',
            'email' => 'Контактный E-Mail',
            'phone' => 'Контактный телефон',
            'delivery_days' => 'В какие дни отгрузка',
            'legal_name' => 'Юридическое название',
            'slug' => 'Символьный код',
            'address' => 'Адрес',
            'group_id' => 'Группа',
            'discount' => 'Скидка',
            'type_price' => 'Цена в прайсе',
            'notes' => 'Заметки',
            'min_summary_sale' => 'Минимальная сумма заказа',
            'time_open' => 'Время открытия',
            'time_close' => 'Время закрытия',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата опоздания',
            'how_send_order' => 'Заявку на покупку через:',
        ];
    }

    public function afterFind()
    {
        $this->delivery_days = Json::decode($this->delivery_days);
        parent::afterFind();
    }

    public function beforeValidate()
    {
        $this->delivery_days = Json::encode($this->delivery_days);
        return parent::beforeValidate();
    }

    public function getSendOrderVariants()
    {
        return [
            self::SEND_ORDER_VARIANT_WA => 'Whatsapp',
            self::SEND_ORDER_VARIANT_EMAIL => 'E-Mail',
        ];
    }

    public function getTypePrice()
    {
        return [
            self::TYPE_PRICE_BASE => 'В прайсе базовая цена',
            self::TYPE_PRICE_PURCHASE => 'В прайсе закупочная цена',
        ];
    }
}
