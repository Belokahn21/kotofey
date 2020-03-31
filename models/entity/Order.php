<?php

namespace app\models\entity;


use app\models\entity\user\Billing;
use app\models\helpers\DiscountHelper;
use app\models\helpers\OrderHelper;
use app\models\services\BonusByBuyService;
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
 * @property boolean $is_cancel
 * @property string $is_bonus
 * @property string $promo_code
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrdersItems[] $items
 */
class Order extends ActiveRecord
{
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_CUSTOM = 'custom';

    public $product_id;
    public $is_update;
    public $select_billing;

    public static function tableName()
    {
        return "orders";
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['type', 'user_id', 'delivery_id', 'payment_id', 'comment', 'notes', 'status', 'is_paid', 'is_cancel', 'is_bonus', 'promo_code', 'created_at', 'updated_at'],
            self::SCENARIO_CUSTOM => ['type', 'user_id', 'delivery_id', 'payment_id', 'comment', 'notes', 'status', 'is_paid', 'is_cancel', 'is_bonus', 'promo_code', 'created_at', 'updated_at'],
        ];
    }

    public function rules()
    {
        return [
            ['type', 'default', 'value' => '3'],

            [['payment_id', 'delivery_id', 'user_id', 'type', 'select_billing'], 'integer'],

            [['payment_id', 'delivery_id', 'user_id', 'status'], 'default', 'value' => 0],

            [['is_paid', 'is_bonus', 'is_cancel'], 'default', 'value' => false],

            [['is_bonus', 'is_cancel'], 'boolean'],


            [['user_id'], 'required', 'message' => '{attribute} необходимо указать', 'on' => self::SCENARIO_DEFAULT],

            [['comment', 'promo_code', 'notes'], 'string'],

            ['promo_code', 'exist', 'targetClass' => Promo::className(), 'targetAttribute' => ['promo_code' => 'code'], 'message' => 'Такого промокода не существует'],


            [['product_id'], 'safe'],

            [
                ['select_billing'],
                'required',
                'message' => 'Укажите {attribute}',
                'when' => function () {
                    return \Yii::$app->user->isGuest === true;
                }
            ],
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

        if ($this->is_update) {
            // заказ оплачен, не получили бонусов и не отменён
            if ($this->is_paid == 1 && $this->is_bonus == 0 && $this->promo_code == 0 && $this->is_cancel == 0 && !empty($this->user_id)) {

                if (BonusByBuyService::isActive()) {
                    if ($discount = Discount::findByUserId($this->user_id)) {
                        $discount->count += DiscountHelper::calcBonus(OrderHelper::orderSummary($this->id));
                        if ($discount->validate()) {
                            $discount->update();
                        }
                    } else {
                        $discount = new Discount();
                        $discount->user_id = $this->user_id;
                        $discount->count += DiscountHelper::calcBonus(OrderHelper::orderSummary($this->id));
                        if ($discount->validate()) {
                            $discount->save();
                        }
                    }
                }

                $this->is_bonus = true;
                $this->update();
            }

            if ($this->is_paid == 1 && $this->is_cancel == 0 && !empty($this->user_id)) {
//				$referal = UsersReferal::findOneByUserId($this->user_id);
//				Debug::p($referal);
//				if ($referal && $referal->has_rewarded == false) {
//					$referal->has_rewarded = true;
//					$referal->count_reward = Discount::REFERAL_COUNT_REWARD_MONEY;
//					if ($referal->validate()) {
//						if ($referal->update() !== false) {
//							DiscountHelper::addBonus($referal->called->user_id, Discount::REFERAL_COUNT_REWARD_MONEY);
//						}
//					}
//				}
            }
        }

        parent::afterSave($insert, $changedAttributes);
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
            'is_cancel' => 'Закакз отменён',
            'user_id' => 'Покупатель',
            'cash' => 'Сумма заказа',
            'created_at' => 'Дата создания',
            'comment' => 'Комментарий к заказу',
            'notes' => 'Заметки(Для админов)',
            'product_id' => 'Товар',
            'promo_code' => 'Промо код',
            'select_billing' => 'Адрес доставки',
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
        return $this->user_id == \Yii::$app->user->id;
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
}