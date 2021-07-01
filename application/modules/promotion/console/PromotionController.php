<?php

namespace app\modules\promotion\console;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\logger\models\service\LogService;
use app\modules\mailer\models\helpers\PromotionHtmlHelper;
use app\modules\mailer\models\services\MailService;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\Month;
use app\modules\site\models\tools\Price;
use app\modules\site\models\tools\System;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class PromotionController extends Controller
{
    public function actionGroupNotify()
    {
        $list_promo_mechanics = PromotionProductMechanics::find()
            ->joinWith('promotion')
            ->andWhere([
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

        $data = [];
        $sender = new MailService();

        $list_all_product_id_current_promo = ArrayHelper::getColumn($list_promo_mechanics, 'product_id');

        $order_items = OrdersItems::find()->where(['product_id' => $list_all_product_id_current_promo])->select(['order_id'])->groupBy(['order_id'])->all();
        $list_order_id = ArrayHelper::getColumn($order_items, 'order_id');

        $orders = Order::find()->where(['id' => $list_order_id])->andWhere(['<>', 'email', ''])->all();

        $products = Product::find()->where(['id' => $list_all_product_id_current_promo])->limit(5)->all();


        foreach ($orders as $order) {
            foreach ($order->items as $item) {

                if ($item->product) {
                    if (ArrayHelper::isIn($item->product->id, $list_all_product_id_current_promo)) {
                        $data[$order->email]['FROM_CURRENT_PROMO_BY_SALES'][] = $item->product;
                    }
                }
            }


            $data[$order->email]['ALL_ITEMS_ALL_PROMO_NO_MORE_FIVE'] = $products;
        }

        foreach ($orders as $order) {

            $current_items = $data[$order->email]['FROM_CURRENT_PROMO_BY_SALES'];
            $all_items = $data[$order->email]['ALL_ITEMS_ALL_PROMO_NO_MORE_FIVE'];

            try {
                $sender->sendEvent(5, [
                    'EMAIL_FROM' => 'sale@kotofey.store',
//                    'EMAIL_TO' => 'popugau@gmail.com',
                    'EMAIL_TO' => $order->email,
                    'LINK_MORE_PROMO' => Url::to(['promotion/promotion/index'],true),
                    'MONTH' => Month::getLabelCurrentMonth(date('m') - 1),
                    'FROM_CURRENT_PROMO_BY_SALES' => call_user_func(function () use ($current_items) {
                        $html = '';
                        foreach ($current_items as $product) {
                            $html .= PromotionHtmlHelper::renderProduct($product);
                        }
                        return $html;
                    }),
                    'ALL_ITEMS_ALL_PROMO_NO_MORE_FIVE' => call_user_func(function () use ($all_items) {
                        $html = '';
                        foreach ($all_items as $product) {
                            $html .= PromotionHtmlHelper::renderProduct($product);
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