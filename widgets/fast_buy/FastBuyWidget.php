<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 14:03
 */


namespace app\widgets\fast_buy;

use app\models\entity\Promo;
use Yii;
use app\models\entity\Basket;
use app\models\entity\Delivery;
use app\models\entity\Order;
use app\models\entity\OrderItems;
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
    public $product = 'default';

    public function run()
    {
        $user = new User(['scenario' => User::SCENARIO_REGISTER_IN_CHECKOUT]);
        $order = new Order();
        $order_items = new OrderItems();

        if (Yii::$app->request->isPost) {

            if ($user->load(Yii::$app->request->post())) {
                if ($user->validate()) {
                    if ($user->save() === false) {
                        Yii::$app->controller->refresh();
                    }
                }
            }

            if (Yii::$app->user->login($user)) {

                $order->user = $user->id;

                if ($order->validate()) {
                    if ($order->save() === false) {
                        Yii::$app->controller->refresh();
                    }
                }


                $order_items->orderId = $order->id;
                $order_items->productId = $this->product->id;
                $order_items->count = 1;
                $order_items->summ = $this->product->price;

                if ($order_items->save()) {
                    Yii::$app->controller->refresh();
                }
            }

        }

        return $this->render($this->template, [
            'user' => $user
        ]);
    }

    public
    function init()
    {
        return;
    }
}