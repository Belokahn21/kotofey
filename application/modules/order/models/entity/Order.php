<?php

namespace app\modules\order\models\entity;

use app\modules\acquiring\models\services\ofd\OFDFermaService;
use app\modules\bonus\models\helper\BonusHelper;
use app\modules\bonus\models\service\BonusService;
use app\modules\order\models\service\NotifyService;
use app\modules\promocode\models\entity\Promocode;
use app\modules\promocode\models\events\Manegment;
use app\modules\site\models\behaviors\UserEntityBehavior;
use app\modules\site\models\tools\Debug;
use app\modules\user\models\entity\User;
use app\modules\user\models\entity\UserBilling;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\user\models\helpers\UserHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Order model
 *
 * @property integer $id
 * @property integer $created_user_id
 * @property integer $updated_user_id
 * @property integer $odd
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
 * @property string $entrance
 * @property string $floor_house
 * @property string $number_appartament
 * @property string $promocode
 * @property string $email
 * @property string $client
 * @property string $phone
 * @property string $ip
 * @property string $discount
 * @property integer $manager_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrdersItems[] $items
 * @property Promocode $promocodeEntity
 * @property boolean $chargeBonus
 * @property OrderDate $dateDelivery
 * @property User $manager
 */
class Order extends ActiveRecord
{
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_CUSTOM = 'custom';
    const SCENARIO_CLIENT_BUY = 'client_buy';
    const SCENARIO_FAST = 'fast';

    public $is_skip;
    public $is_update;
    public $bonus;
    public $address;

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['is_skip', 'created_user_id', 'updated_user_id', 'manager_id', 'client', 'odd', 'bonus', 'entrance', 'floor_house', 'discount', 'ip', 'email', 'postalcode', 'country', 'region', 'city', 'street', 'number_home', 'number_appartament', 'phone', 'is_close', 'type', 'user_id', 'delivery_id', 'payment_id', 'comment', 'notes', 'status', 'is_paid', 'is_cancel', 'promocode', 'created_at', 'updated_at'],
            self::SCENARIO_CUSTOM => ['is_skip', 'created_user_id', 'updated_user_id', 'manager_id', 'client', 'odd', 'bonus', 'entrance', 'floor_house', 'discount', 'ip', 'email', 'postalcode', 'country', 'region', 'city', 'street', 'number_home', 'number_appartament', 'phone', 'is_close', 'type', 'user_id', 'delivery_id', 'payment_id', 'comment', 'notes', 'status', 'is_paid', 'is_cancel', 'promocode', 'created_at', 'updated_at'],
            self::SCENARIO_CLIENT_BUY => ['is_skip', 'created_user_id', 'updated_user_id', 'manager_id', 'client', 'odd', 'bonus', 'entrance', 'floor_house', 'discount', 'ip', 'email', 'postalcode', 'country', 'region', 'city', 'street', 'number_home', 'number_appartament', 'phone', 'is_close', 'type', 'user_id', 'delivery_id', 'payment_id', 'comment', 'notes', 'status', 'is_paid', 'is_cancel', 'promocode', 'created_at', 'updated_at', 'address'],
            self::SCENARIO_FAST => ['is_skip', 'created_user_id', 'updated_user_id', 'manager_id', 'email', 'phone', 'type', 'is_paid', 'status', 'ip'],
        ];
    }

    public function rules()
    {
        $module = \Yii::$app->getModule('order');
        return [
            ['manager_id', 'integer'],
            ['manager_id', 'default', 'value' => $module->default_manager_id],

            ['type', 'default', 'value' => '3'],

            [['phone'], 'string', 'max' => 25],
            [['phone'], 'required', 'message' => '{attribute} необходимо указать', 'on' => [self::SCENARIO_DEFAULT, self::SCENARIO_CLIENT_BUY, self::SCENARIO_FAST]],
            [
                ['phone'],
                'filter',
                'filter' => function ($value) {
                    $value = str_replace('+7', '8', $value);
                    return str_replace([' ', '(', ')', '-'], '', $value);
                }
            ],

            [['created_user_id', 'updated_user_id'], 'default', 'value' => 0],

            [['payment_id', 'delivery_id', 'user_id', 'type', 'select_billing', 'entrance', 'floor_house', 'odd', 'created_user_id', 'updated_user_id'], 'integer'],


            [['payment_id', 'delivery_id'], 'required', 'on' => self::SCENARIO_CLIENT_BUY, 'message' => 'Укажите {attribute}'],
            [['payment_id', 'delivery_id', 'user_id', 'status'], 'default', 'value' => 0],

            [['is_paid', 'is_cancel'], 'default', 'value' => false],

            [['is_cancel', 'is_close', 'is_skip'], 'boolean'],

            ['email', 'email', 'message' => 'Не верный формат Email адреса'],
            [['email'], 'required', 'message' => '{attribute} необходимо указать', 'on' => self::SCENARIO_CLIENT_BUY],
            ['email', 'string', 'max' => 255, 'tooLong' => '{attribute} не должен содержать больше 255 символов'],

            [['discount', 'postalcode'], 'string', 'max' => 15, 'tooLong' => '{attribute} не должен содержать больше 15 символов'],

            [['comment', 'notes'], 'string'],
            [['number_appartament', 'number_home'], 'string', 'max' => 10, 'tooLong' => '{attribute} не должен содержать больше 10 символов'],
            [['country', 'region', 'city', 'street'], 'string', 'max' => 100, 'tooLong' => '{attribute} не должен содержать больше 100 символов'],

            ['promocode', 'string', 'max' => 255, 'tooLong' => '{attribute} не должен содержать больше 255 символов'],

            [['ip'], 'string'],
            [['ip'], 'default', 'value' => \Yii::$app->request->userIP],

            ['client', 'required', 'message' => 'Укажите ваше фио', 'on' => self::SCENARIO_CLIENT_BUY, 'when' => function ($model) {
                return $model->delivery_id == 1;
            }],

            // всё ниже нештатные переменные
            [['address'], 'required', 'on' => self::SCENARIO_CLIENT_BUY, 'message' => 'Укажите адрес доставки'],
            [['bonus'], 'integer'],
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
        if ($this->is_paid) {
            OrderHelper::minusStockCount($this);
        }

        BonusService::getInstance()->addUserBonus($this);
        if (empty($this->is_skip)) {
            OFDFermaService::getInstance()->doSendCheck($this, [
                'email' => $this->email,
                'phone' => $this->phone,
            ]);
        }

        if ($module = \Yii::$app->getModule('bonus') && !empty($this->bonus)) {
            if ($module->getEnable()) {
                if ($this->bonus && $this->bonus > 0) {
                    BonusHelper::addHistory($this, $this->bonus * -1, 'Списание за заказ #' . $this->id, true);
                    $this->discount = $this->bonus * -1;
                }
            }
        }

        // todo: херня выходит с пересохранением заказа, надо поправить
        if (!$this->is_update) {
            (new Manegment())->applyCodeToUser($this);
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => UserEntityBehavior::className(),
                'attr_at_save' => 'created_user_id',
                'attr_at_update' => 'updated_user_id',
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'IP',
            'status' => 'Статус',
            'payment_id' => 'Способ оплаты',
            'delivery_id' => 'Способ доставки',
            'is_paid' => 'Оплачено',
            'is_cancel' => 'Заказ отменён',
            'is_close' => 'Заказ закрыт',
            'user_id' => 'Покупатель',
            'cash' => 'Сумма заказа',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'comment' => 'Комментарий к заказу',
            'notes' => 'Заметки(Для админов)',
            'promocode' => 'Промо код',
            'phone' => 'Телефон',
            'postalcode' => 'Почтовый индекс',
            'country' => 'Страна',
            'region' => 'Регион',
            'city' => 'Город',
            'street' => 'Улица',
            'number_home' => 'Дом',
            'entrance' => 'Подъезд',
            'floor_house' => 'Этаж',
            'number_appartament' => 'Квартира',
            'minusStock' => 'Списать товары',
            'plusStock' => 'Вернуть товары',
            'discount' => 'Скидка',
            'chargeBonus' => 'Начислить бонусы',
            'odd' => 'С какой суммы сдача?',
            'client' => 'Ваше ФИО',
            'created_user_id' => 'Кем создан',
            'updated_user_id' => 'Кем обновлен',
        ];
    }

    public function hasAccess()
    {
        if (\Yii::$app->user->isGuest) return false;
        return $this->phone == \Yii::$app->user->identity->phone || $this->user_id == \Yii::$app->user->identity->id || in_array(\Yii::$app->user->identity->id, ArrayHelper::getColumn(UserHelper::getManagers(), 'id'));
    }

    public function getBilling()
    {
        $order_billing = OrderBilling::findOne(['order_id' => $this->id]);
        if ($order_billing) {
            return UserBilling::findOne($order_billing->user_billing_id);
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

    public function getManager()
    {
        return $this->hasOne(User::className(), ['id' => 'manager_id']);
    }
}