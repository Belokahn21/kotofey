<?php

namespace app\modules\promotion\console;

use app\modules\catalog\models\entity\Offers;
use app\modules\logger\models\service\LogService;
use app\modules\mailer\models\helpers\PromotionHtmlHelper;
use app\modules\mailer\models\services\MailService;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\promotion\models\entity\PromotionMailHistory;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\Month;
use app\modules\subscribe\models\entity\Subscribes;
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

        $_excluded_email = ArrayHelper::getColumn(Subscribes::find()->select(['email'])->where(['active' => 0])->all(), 'email');
        $_excluded_email = array_merge($_excluded_email, ArrayHelper::getColumn(PromotionMailHistory::find()->select(['email'])->all(), 'email'));
        $excluded_email = array_unique($_excluded_email);

        $list_promotion_id = [];
        foreach ($list_promo_mechanics as $mechanic) {
            $list_promotion_id[] = $mechanic->promotion_id;
        }
        $list_promotion_id = array_unique($list_promotion_id);

        $list_all_product_id_current_promo = ArrayHelper::getColumn($list_promo_mechanics, 'product_id');

        $order_items = OrdersItems::find()->where(['product_id' => $list_all_product_id_current_promo])->select(['order_id'])->groupBy(['order_id'])->all();
        $list_order_id = ArrayHelper::getColumn($order_items, 'order_id');

        $orders = Order::find()->where(['id' => $list_order_id])->andWhere(['<>', 'email', ''])->andWhere(['not in', 'email', $excluded_email])->all();

        $products = Offers::find()->where(['id' => $list_all_product_id_current_promo])->limit(5)->all();


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
                    'EMAIL_TO' => $order->email,
                    'LINK_MORE_PROMO' => Url::to(['promotion/promotion/index'], true),
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

                foreach ($list_promotion_id as $promo_id) {
                    $history = new PromotionMailHistory();
                    $history->promotion_id = $promo_id;
                    $history->email = $order->email;
                    if (!$history->validate() || !$history->save()) {
                        LogService::saveErrorMessage(Debug::modelErrors($history), 'mail_service_history');
                    }
                }

            } catch (\Exception $exception) {
                LogService::saveErrorMessage($exception->getMessage(), 'mail_service');
            }
        }


    }
}