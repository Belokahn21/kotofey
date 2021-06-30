<?php

namespace app\modules\promotion\console;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\logger\models\service\LogService;
use app\modules\mailer\models\services\MailService;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\Month;
use app\modules\site\models\tools\Price;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class PromotionController extends Controller
{
    public function actionGroupNotify()
    {
        //todo проблема в том что клиенту нужно отправлять товары по скидке, которые он заказал, а приходят все
        //collect promo in current
        $list_promo_mechanics = PromotionProductMechanics::find()->joinWith('promotion')->andWhere([
            'or',
            'promotion.start_at = :default and promotion.end_at = :default',
            'promotion.start_at is null and promotion.end_at is null',
            'promotion.start_at < :now and promotion.end_at > :now'
        ])
            ->andWhere(['promotion.is_active' => true])
            ->addParams([
                ":now" => time(),
                ":default" => 0,
            ])
            ->all();

        $sender = new MailService();
        $list_product_id = ArrayHelper::getColumn($list_promo_mechanics, 'product_id');
        $order_items = OrdersItems::find()->where(['product_id' => $list_product_id])->select(['order_id'])->groupBy(['order_id'])->all();
        $orders = Order::find()->where(['id' => ArrayHelper::getColumn($order_items, 'order_id')])->all();

        $products = Product::find()->where(['id' => $list_product_id])->all();

        foreach ($orders as $order) {
            $user_phone = $order->phone;

            try {
                $sender->sendEvent(5, [
                    'EMAIL_FROM' => 'sale@kotofey.store',
                    'EMAIL_TO' => 'popugau@gmail.com',
//                    'EMAIL_TO' => $order->email,
                    'MONTH' => Month::getLabelCurrentMonth(date('m') - 1),
                    'SALE_ITEMS' => call_user_func(function () use ($products) {
                        $html = '';
                        $cur_icon = Currency::getInstance()->show();
                        foreach ($products as $product) {
                            $detail = ProductHelper::getDetailUrl($product);
                            $html .= "
                            <tr style='display: block; width: 100%;'>
                              <td style='width:45%; padding: 5px; font-size:16px; '>{$product->name}</td>
                              <td style='width:15%; padding: 5px;'>{$product->price} {$cur_icon}</td>
                              <td style='width:15%; padding: 5px;'>{$product->discount_price} {$cur_icon}</td>
                              <td style='width:15%; padding: 5px;'>
                              <a href='{$detail}' style='border:1px solid #ff1a4a; color:#ff1a4a; padding:5px; text-decoration:none!important; text-transform:uppercase; font-size:12px;'>Купить</a>
                              </td>
                            </tr>";
                        }


                        return $html;
                    }),
                    'LAST_ORDERS' => call_user_func(function () use ($user_phone) {
                        $html = '';
                        $last = Order::find()->where(['phone' => $user_phone])->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
                        foreach ($last as $order) {
                            $cur_icon = Currency::getInstance()->show();
                            $sum = OrderHelper::orderSummary($order);
                            $sum_formated = Price::format($sum);
                            $html .= "
                            <tr style='display: block; width: 100%;'>
                              <td style='width:40%; padding: 5px;'>Заказ № {$order->id}</td>
                              <td style='width:45%; padding: 5px;'>Сумма заказа {$sum_formated} {$cur_icon}</td>
                              <td style='width:15%; padding: 5px;'><a href='#' style='border:1px solid #ff1a4a; color:#ff1a4a; padding:5px; text-decoration:none!important; text-transform:uppercase; font-size:12px;'>Повторить</a></td>
                            </tr>";
                        }
                        return $html;
                    }),
                ]);

            } catch (\Exception $exception) {
                LogService::saveErrorMessage($exception->getMessage(), 'mail_service');
            }
        }

    }
}