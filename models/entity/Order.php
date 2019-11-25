<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 14:22
 */

namespace app\models\entity;


use app\models\tool\payments\Robokassa;
use app\models\tool\Price;
use app\models\tool\vk\VKMethods;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


/**
 * Order model
 *
 * @property integer $id
 * @property integer $user
 * @property integer $delivery
 * @property integer $payment
 * @property string $comment
 * @property integer $status
 * @property boolean $paid
 * @property string $promo_code
 * @property string $summared
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
            self::SCENARIO_FAST_ORDER => ['payment', 'delivery', 'user', 'summared', 'paid', 'status', 'comment', 'product_id', 'type'],
            self::SCENARIO_SIMPLE_ORDER => ['payment', 'delivery', 'user', 'summared', 'paid', 'status', 'comment', 'product_id', 'type'],
        ];
    }

    public function rules()
    {
        return [
            [['payment', 'delivery', 'user', 'summared', 'type'], 'integer'],

            [['payment', 'delivery', 'user'], 'default', 'value' => 0],

            ['paid', 'default', 'value' => false],

            [['summared', 'status'], 'default', 'value' => 0],

            ['type', 'default', 'value' => self::SCENARIO_SIMPLE_ORDER],

            [['user'], 'required', 'message' => '{attribute} необходимо указать'],

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
        parent::afterSave($insert, $changedAttributes);

        if ($this->is_update) {
            if ($this->paid == 1) {
                if ($discount = Discount::findByUserId(\Yii::$app->user->id)) {
                    $discount->count += ceil($this->cash() * 0.05);
                    if ($discount->validate()) {
                        $discount->update();
                    }
                } else {
                    $discount = new Discount();
                    $discount->user_id = $this->user;
                    $discount->count = ceil($this->cash() * 0.05);
                    if ($discount->validate()) {
                        $discount->save();
                    }
                }
            }
        }
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
            'payment' => 'Способ оплаты',
            'delivery' => 'Способ доставки',
            'paid' => 'Оплачено',
            'user' => 'Покупатель',
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

    public function cash()
    {
        $cash = false;
        $items = OrdersItems::findAll(['order_id' => $this->id]);
        /* @var $promo Promo */
        $promo = Promo::findByCode($this->promo_code);
        foreach ($items as $item) {
            if ($promo) {
                $cash += $item->price - (($item->price * $promo->discount) / 100);
            } else {
                $cash += $item->price;
            }
        }
        return $cash;
    }

    public function getCash()
    {
        return $this->cash();
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

    public function findByFilter($params)
    {
        if (!$params) {
            throw new \InvalidArgumentException("Empty params.");
        }
        if (\Yii::$app->user->isGuest) {
            throw new \Exception("Need auth user.");
        }

        $params['filter']['user'] = \Yii::$app->user->identity->id;

        return static::find()->where($params['filter'])->all();
    }

    public static function orderProfit()
    {
        $cash = 0;
        $orders = Order::find()->where(['paid' => 1])->all();


        /* @var $order Order */
        foreach ($orders as $order) {
            $cash += $order->cash();
        }

        return $cash;

    }

    public function hasAccess()
    {
        return $this->user == \Yii::$app->user->identity->id;
    }

    public function search($params)
    {
        $query = static::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'delivery', $this->delivery])
            ->andFilterWhere(['like', 'payment', $this->payment]);

        return $dataProvider;
    }
}