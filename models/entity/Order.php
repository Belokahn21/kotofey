<?php

namespace app\models\entity;


use app\models\helpers\OrderHelper;
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
 * @property integer $status
 * @property boolean $is_paid
 * @property string $promo_code
 * @property string $is_bonus
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrdersItems[] $items
 */
class Order extends ActiveRecord
{
    const SCENARIO_FAST_ORDER = 1;
    const SCENARIO_SIMPLE_ORDER = 2;

    public $product_id;
    public $is_update;

    public static function tableName()
    {
        return "orders";
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_FAST_ORDER => ['payment_id', 'delivery_id', 'user_id', 'is_bonus', 'is_paid', 'status', 'comment', 'product_id', 'type'],
            self::SCENARIO_SIMPLE_ORDER => ['payment_id', 'delivery_id', 'user_id', 'is_bonus', 'is_paid', 'status', 'comment', 'product_id', 'type'],
        ];
    }

    public function rules()
    {
        return [
            [['payment_id', 'delivery_id', 'user_id', 'type'], 'integer'],

            [['payment_id', 'delivery_id', 'user_id', 'status'], 'default', 'value' => 0],

            [['is_paid', 'is_bonus'], 'default', 'value' => false],

            [['is_bonus'], 'boolean'],

            ['type', 'default', 'value' => self::SCENARIO_SIMPLE_ORDER],

            [['user_id'], 'required', 'message' => '{attribute} необходимо указать'],

            [['comment', 'promo_code'], 'string'],

            [['product_id'], 'safe'],
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
            if ($this->is_paid == 1 && $this->is_bonus == 0) {
                if ($discount = Discount::findByUserId($this->user_id)) {
                    $discount->count += ceil(OrderHelper::orderSummary($this->id) * 0.05);
                    if ($discount->validate()) {
                        $discount->update();
                    }
                } else {
                    $discount = new Discount();
                    $discount->user_id = $this->user_id;
                    $discount->count = ceil(OrderHelper::orderSummary($this->id) * 0.05);
                    if ($discount->validate()) {
                        $discount->save();
                    }
                }

                $this->is_bonus = true;
                $this->update();
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
            'user_id' => 'Покупатель',
            'cash' => 'Сумма заказа',
            'created_at' => 'Дата создания',
            'comment' => 'Комментарий к заказу',
            'product_id' => 'Товар',
            'promo_code' => 'Промо код',
        ];
    }

    public function saveOrder()
    {
        if ($this->load(\Yii::$app->request->post())) {
            if ($this->validate()) {
                if ($this->save() === true) {
                    $this->id = \Yii::$app->db->lastInsertID;
                    return true;
                }
            }
        }
        return false;
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
}