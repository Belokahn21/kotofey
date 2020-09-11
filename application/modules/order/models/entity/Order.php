<?php

namespace app\modules\order\models\entity;


use app\modules\promocode\models\entity\Promocode;
use app\modules\promocode\models\entity\PromocodeUser;
use app\modules\promocode\models\events\Manegment;
use app\modules\user\models\entity\User;
use app\modules\user\models\entity\Billing;
use app\modules\order\models\helpers\OrderHelper;
use yii\base\Event;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * Order model
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $delivery_id
 * @property integer $payment_id
 * @property string $comment
 * @property string $notes
 * @property integer $status
 * @property boolean $is_paid
 * @property boolean $is_close
 * @property boolean $is_cancel
 * @property string $postalcode
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $street
 * @property string $number_home
 * @property string $number_appartament
 * @property string $promocode
 * @property string $email
 * @property string $phone
 * @property string $ip
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrdersItems[] $items
 * @property Promocode $promocodeEntity
 */
class Order extends ActiveRecord
{
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_CUSTOM = 'custom';
    const SCENARIO_CLIENT_BUY = 'client_buy';

    public $product_id;
    public $is_update;
    public $minusStock;
    public $plusStock;

    public static function tableName()
    {
        return "orders";
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['ip', 'minusStock', 'plusStock', 'email', 'postalcode', 'country', 'region', 'city', 'street', 'number_home', 'number_appartament', 'phone', 'is_close', 'type', 'user_id', 'delivery_id', 'payment_id', 'comment', 'notes', 'status', 'is_paid', 'is_cancel', 'promocode', 'created_at', 'updated_at'],
            self::SCENARIO_CUSTOM => ['ip', 'minusStock', 'plusStock', 'email', 'postalcode', 'country', 'region', 'city', 'street', 'number_home', 'number_appartament', 'phone', 'is_close', 'type', 'user_id', 'delivery_id', 'payment_id', 'comment', 'notes', 'status', 'is_paid', 'is_cancel', 'promocode', 'created_at', 'updated_at'],
            self::SCENARIO_CLIENT_BUY => ['ip', 'minusStock', 'plusStock', 'email', 'postalcode', 'country', 'region', 'city', 'street', 'number_home', 'number_appartament', 'phone', 'is_close', 'type', 'user_id', 'delivery_id', 'payment_id', 'comment', 'notes', 'status', 'is_paid', 'is_cancel', 'promocode', 'created_at', 'updated_at'],
        ];
    }

    public function rules()
    {
        return [
            ['type', 'default', 'value' => '3'],

            [['phone'], 'string', 'max' => 25],
            [['phone'], 'required', 'message' => '{attribute} необходимо указать', 'on' => [self::SCENARIO_DEFAULT, self::SCENARIO_CLIENT_BUY]],
            [
                ['phone'],
                'filter',
                'filter' => function ($value) {
                    $value = str_replace('+7', '8', $value);
                    return str_replace([' ', '(', ')', '-'], '', $value);
                }
            ],

            [['payment_id', 'delivery_id', 'user_id', 'type', 'select_billing'], 'integer'],


            [['payment_id', 'delivery_id', 'user_id', 'status'], 'default', 'value' => 0],

            [['is_paid', 'is_cancel'], 'default', 'value' => false],

            [['is_cancel', 'is_close', 'minusStock', 'plusStock'], 'boolean'],

            ['email', 'email'],
            [['email'], 'required', 'message' => '{attribute} необходимо указать', 'on' => self::SCENARIO_CLIENT_BUY],
            ['email', 'string', 'string', 'max' => 255, 'tooLong' => '{attribute} не должен содержать больше 255 символов'],

            ['postalcode', 'string', 'string', 'max' => 15, 'tooLong' => '{attribute} не должен содержать больше 15 символов'],

            [['comment', 'notes'], 'string'],
            [['number_appartament', 'number_home'], 'string', 'max' => 10, 'tooLong' => '{attribute} не должен содержать больше 10 символов'],
            [['country', 'region', 'city', 'street'], 'string', 'max' => 100, 'tooLong' => '{attribute} не должен содержать больше 100 символов'],

            ['promocode', 'string', 'string', 'max' => 255, 'tooLong' => '{attribute} не должен содержать больше 255 символов'],

            [['product_id'], 'safe'],

            [['ip'], 'string'],
        ];
    }

    public function beforeSave($insert)
    {
        if (!$this->isNewRecord) {
            $this->is_update = true;
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->minusStock) {
            OrderHelper::minusStockCount($this);
        }

        if ($this->plusStock) {
            OrderHelper::minusStockCount($this, false);
        }

        (new Manegment())->applyCodeToUser($this);

        return parent::afterSave($insert, $changedAttributes);
    }

    public function beforeValidate()
    {
        if (empty($this->ip)) {
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        return parent::beforeValidate();
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Статус',
            'payment_id' => 'Способ оплаты',
            'delivery_id' => 'Способ доставки',
            'is_paid' => 'Оплачено',
            'is_cancel' => 'Заказ отменён',
            'is_close' => 'Заказ закрыт',
            'user_id' => 'Покупатель',
            'cash' => 'Сумма заказа',
            'created_at' => 'Дата создания',
            'comment' => 'Комментарий к заказу',
            'notes' => 'Заметки(Для админов)',
            'product_id' => 'Товар',
            'promocode' => 'Промо код',
            'phone' => 'Телефон',
            'postalcode' => 'Почтовый индекс',
            'country' => 'Страна',
            'region' => 'Регион',
            'city' => 'Город',
            'street' => 'Улица',
            'number_home' => 'Дом',
            'number_appartament' => 'Квартира',
            'minusStock' => 'Списать товары',
            'plusStock' => 'Вернуть товары',
        ];
    }

    public function getStatus()
    {
        $status = null;
        if ($this->status == 0) {
            $status = new OrderStatus();
            $status->name = 'В обработке';
        } else {
            $status = OrderStatus::findOne($this->status);
        }

        return $status->name;
    }


    public function hasAccess()
    {
        return $this->phone == \Yii::$app->user->identity->phone or $this->user_id == \Yii::$app->user->identity->id;
    }

    public function getBilling()
    {
        $order_billing = OrderBilling::findOne(['order_id' => $this->id]);
        if ($order_billing) {
            return Billing::findOne($order_billing->user_billing_id);
        }
    }

    public function getDateDelivery()
    {
        return OrderDate::findOne(['order_id' => $this->id]);
    }

    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getItems()
    {
        return $this->hasMany(OrdersItems::className(), ['order_id' => 'id']);
    }

    public function getPromocodeEntity()
    {
        return $this->hasOne(Promocode::className(), ['code' => 'promocode']);
    }
}