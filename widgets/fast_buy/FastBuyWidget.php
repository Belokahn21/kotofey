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
    public $product;

    public function run()
    {
        $user = new User();
        $order = new Order();
        $order_items = new OrderItems();


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