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

class FastBuyWidget extends \yii\base\Widget
{
    public function run()
    {
        $delivery = Delivery::find()->all();
        $payments = Payment::find()->all();
        $route = Yii::$app->urlManager->parseRequest(Yii::$app->request);

        if (\Yii::$app->controller->action->id == 'product') {

            if (array_key_exists('id', $route[1])) {
                $product = Product::findBySlug($route[1]['id']);
            }

        }

        if (\Yii::$app->user->isGuest) {
            $order = new Order();
            $billing = new Billing();
            $user = new User(['scenario' => User::SCENARIO_REGISTER_IN_CHECKOUT]);
            $items = new OrderItems();
            $basket = new Basket();
        } else {
            $order = new Order();
            $user = User::findOne(\Yii::$app->user->identity->id);
            $billing = Billing::findByUser($user->id);
            if (!$billing) {
                $billing = new Billing();
            }
            $items = new OrderItems();
            $basket = new Basket();
        }

        $basket->product = $product;
        $basket->count = 1;
        $basket->add();


        if (\Yii::$app->user->isGuest) {
            // форма отправлена

            $template = 'fast_buy_guest';

            if (\Yii::$app->request->isPost) {
                $newUser = $user->createUser();
                if ($newUser instanceof User) {
                    if ($newUser->login()) {
                        $order->user = $newUser->id;

                        if ($billing->load(\Yii::$app->request->post())) {
                            $billing->user_id = $newUser->id;
                            if ($billing->validate()) {
                                if ($billing->save() === false) {
                                    return false;
                                }
                            }
                        }

                        if ($order->saveOrder()) {
                            $items->orderId = $order->id;
                            if ($items->saveItems()) {

                                $robokassa = new Robokassa();
                                $robokassa->config->setInvID($order->id);
                                $robokassa->config->setDescription("Оплата товара");
                                $robokassa->config->setSum($order->cash());


                                $basket->clear();
                                Promo::clear();

                                $order->userNotify();
                                $order->adminNotify();

                                if ($_POST['type'] == 'paid') {
                                    \Yii::$app->controller->redirect($robokassa->generateUrl());
                                } else {
                                    Notify::setSuccessNotify("Заказ успешно создан!");
                                    \Yii::$app->controller->redirect("/");
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $template = 'fast_buy_user';

            if (\Yii::$app->request->isPost) {

                $order->user = \Yii::$app->user->identity->id;
                if ($billing->load(\Yii::$app->request->post())) {

                    if (empty($billing->user_id)) {
                        $billing->user_id = \Yii::$app->user->identity->id;

                        if ($billing->validate()) {
                            if ($billing->save() === false) {
                                return false;
                            }
                        }

                    } else {

                        if ($billing->validate()) {
                            if ($billing->update() === false) {
                                return false;
                            }

                        }
                    }
                }

                if ($order->saveOrder()) {
                    $items->orderId = $order->id;
                    if ($items->saveItems()) {

                        $robokassa = new Robokassa();
                        $robokassa->config->setInvID($order->id);
                        $robokassa->config->setSum($order->cash());

                        $basket->clear();
                        Promo::clear();

                        $order->userNotify();
                        $order->adminNotify();

                        if ($_POST['type'] == 'paid') {
                            \Yii::$app->controller->redirect($robokassa->generateUrl());
                        } else {
                            Notify::setSuccessNotify("Заказ успешно создан!");
                            \Yii::$app->controller->redirect("/");
                        }
                    }

                }
            }
        }


        return $this->render($template, [
            'order' => $order,
            'billing' => $billing,
            'user' => $user,

            'delivery' => $delivery,
            'payments' => $payments,
        ]);
    }

    public function init()
    {
        return;
    }
}