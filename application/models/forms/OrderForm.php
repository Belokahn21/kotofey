<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 0:07
 */

namespace app\models\forms;


use app\modules\order\models\entity\Order;
use yii\base\Model;

class OrderForm extends Model
{
    public $user_id;
    public $product_id;
    public $status;
    public $paid;
    public $comment;

    public $email, $new_password;

    public $first_name, $name, $last_name;

    public $payment_id, $delivery_id;

    public function rules()
    {
        return [
            [['status', 'payment_id', 'delivery_id', 'paid'], 'integer'],

            [['user_id'], 'safe'],
            [['product_id'], 'safe'],

            [['product_id', 'user_id'], 'required', 'message' => '{attribute} необходимо указать'],

            [['new_password', 'email', 'first_name', 'name', 'last_name', 'comment'], 'string'],

            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            "product_id" => "Товар",
            "user_id" => "Пользователь",
            "status" => "Статус заказа",
            "new_password" => "Пароль",
            "first_name" => "Фамилия",
            "name" => "Имя",
            "last_name" => "Отчество",
            "payment_id" => "Способ оплаты",
            "delivery_id" => "Способ доставки",
            "paid" => "Флаг оплаты",
            "comment" => "Комментарий к заказу",
        ];
    }

    public function createOrder()
    {
        if ($this->load(\Yii::$app->request->post())) {

            if ($this->validate()) {

                $order = new Order();
                $order->user = $this->user_id;
                $order->paid = $this->paid;
                $order->status = $this->status;
                $order->delivery = $this->delivery_id;
                $order->payment = $this->payment_id;
                $order->user = $this->user_id;
                $order->comment = $this->comment;

                if ($order->validate()) {

                    if ($order->save()) {
                        return $order->id;
                    }

                }

            }

        }
    }
}