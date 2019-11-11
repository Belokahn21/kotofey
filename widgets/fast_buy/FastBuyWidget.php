<?

namespace app\widgets\fast_buy;

use app\models\entity\Promo;
use Yii;
use app\models\entity\Basket;
use app\models\entity\Delivery;
use app\models\entity\Order;
use app\models\entity\OrdersItems;
use app\models\entity\Payment;
use app\models\entity\Product;
use app\models\entity\User;
use app\models\entity\user\Billing;
use app\models\tool\Debug;
use app\models\tool\payments\Robokassa;
use app\widgets\notification\Notify;
use yii\debug\models\search\Base;

class FastBuyWidget extends \yii\base\Widget
{
    public $template = 'default';
    public $product;

    public function run()
    {
        $user = new User(['scenario' => User::SCENARIO_CHECKOUT]);

        if (Yii::$app->request->isPost) {
            if ($user->load(Yii::$app->request->post()) && $user->validate()) {
                if ($user->save() === false) {
                    Notify::setErrorNotify(Debug::modelErrors($user));
                    Yii::$app->controller->refresh();
                }

                Yii::$app->user->login($user, Yii::$app->params['users']['rememberMeDuration']);
            } else {
                $user = User::findOne(Yii::$app->user->id);
            }

            $basket = new Basket();
            $basket->product = $this->product;
            $basket->count = 1;
            $basket->add();

            $order = new Order(['scenario' => Order::SCENARIO_FAST_ORDER]);
            $order->user = $user->id;
            if ($order->validate() == false) {
                Notify::setErrorNotify(Debug::modelErrors($order));
                Yii::$app->controller->refresh();
            }

            $order->save();

            $items = new OrdersItems();
            $items->order_id = $order->id;
            if ($items->saveItems() === false) {
                Notify::setErrorNotify(Debug::modelErrors($items));
                Yii::$app->controller->refresh();
            }

            Basket::clear();
            Promo::clear();
            Notify::setSuccessNotify('Вы успешно купили товар');
            Yii::$app->controller->refresh();
        }


        return $this->render($this->template, [
            'user' => $user,
            'product' => $this->product,
        ]);
    }

    public function init()
    {
        return;
    }
}