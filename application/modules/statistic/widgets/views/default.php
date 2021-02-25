<?php
/* @var $ordersNow Order[]
 * /* @var $lastSearch \app\modules\search\models\entity\SearchQuery[]
 * @var $searches \app\modules\search\models\entity\SearchQuery[]
 * @var $logs \app\modules\logger\models\entity\Logger[]
 * @var $this \yii\web\View
 */

use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\Price;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use yii\helpers\StringHelper;
use app\modules\site\models\tools\Backup;
use yii\helpers\Url;

$product = Product::find();
?>
    <div class="statistic-wrap">
        <div class="statistic">
            <div class="statistic__item">
                <div class="statistic__icon"><i class="fas fa-cookie"></i></div>
                <div class="statistic__content">
                    <div class="statistic-info">
                        <div class="statistic-info__item">
                            <div class="statistic-info__key">Последний бэкап</div>
                            <div class="statistic-info__value"><?= date('d.m.Y H:i:s', Backup::getInstance()->getFileDate()); ?></div>
                        </div>
                    </div>
                    <div class="statistic-action">
                        <a class="statistic-action__item" href="?save_dump=Y"><i class="fas fa-sync"></i></a>
                        <a class="statistic-action__item" href="?save_dump=Y&out=Y"><i class="fas fa-download"></i></a>
                    </div>
                </div>
            </div>
            <div class="statistic__item">
                <div class="statistic__icon" data-toggle="modal" data-target="#order-list"><i class="fas fa-cookie"></i>
                </div>
                <div class="statistic__content">
                    <div class="statistic-info">
                        <div class="statistic-info__item">
                            <div class="statistic-info__key">Заказов</div>
                            <div class="statistic-info__value"><?= Order::find()->count(); ?></div>
                        </div>
                        <div class="statistic-info__item">
                            <div class="statistic-info__key">Прибыль</div>
                            <div class="statistic-info__value"><?= Price::format(OrderHelper::marginalityAllOrder()); ?><?= Currency::getInstance()->show(); ?></div>
                        </div>
                        <div class="statistic-info__item">
                            <div class="statistic-info__key">Оборот</div>
                            <div class="statistic-info__value"><?= Price::format(OrderHelper::rotate()); ?><?= Currency::getInstance()->show(); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="statistic__item">
                <div class="statistic__icon"><i class="fas fa-cookie"></i></div>
                <div class="statistic__content">
                    <div class="statistic-info">
                        <div class="statistic-info__item">
                            <div class="statistic-info__key">Товаров</div>
                            <div class="statistic-info__value"><?= $product->count(); ?></div>
                        </div>
                        <div class="statistic-info__item">
                            <div class="statistic-info__key">А/Ч/БП</div>
                            <div class="statistic-info__value"><?= $product->where(['status_id' => Product::STATUS_ACTIVE])->count(); ?>/<?= $product->where(['status_id' => Product::STATUS_DRAFT])->count(); ?>/<?= $product->where(['vendor_id' => null])->count(); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="statistic__item">
                <div class="statistic__icon" data-toggle="modal" data-target="#search-list"><i class="fas fa-search"></i></div>
                <div class="statistic__content">
                    <?php if ($lastSearch): ?>
                        <div class="statistic-summary">
                            <?php foreach ($lastSearch as $search): ?>
                                <div class="statistic-summary__item"
                                     title="<?= $search->text; ?>"><?= StringHelper::truncate($search->text, 25, '...'); ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="statistic__item">
                <div class="statistic__icon" data-toggle="modal" data-target="#log-list"><i class="fas fa-history"></i>
                </div>
                <div class="statistic__content">
                    <?php if ($lastlogs): ?>
                        <div class="statistic-summary">
                            <?php foreach ($lastlogs as $log): ?>
                                <div class="statistic-summary__item"
                                     title="<?= $log->message; ?>"><?= StringHelper::truncate($log->message, 25, '...'); ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="statistic__item">
                <div class="statistic__icon"><i class="fas fa-truck"></i>
                </div>
                <div class="statistic__content">
                    <div class="now-order-delivery-container">
                        <?php $now = new DateTime(); ?>
                        <?php $nowDate = $now->format('d.m.Y') ?>
                        <?php $now->add(new DateInterval('P1D')); ?>
                        <?php $tomorowDate = $now->format('d.m.Y') ?>
                        <div class="now-order-delivery-dates">
                            <div class="now-order-delivery-dates__item"><a href="?deliveryDate=<?= $nowDate; ?>"><?= $nowDate; ?></a></div>
                            <div class="now-order-delivery-dates__item"><a href="?deliveryDate=<?= $tomorowDate; ?>"><?= $tomorowDate; ?></a></div>
                        </div>
                        <?php if ($ordersNow): ?>
                            <ul class="now-order-delivery ">
                                <?php foreach ($ordersNow as $order): ?>
                                    <li class="now-order-delivery__item<?= $order->status == 8 ? ' finish' : null ?>">
                                        <a href="<?= Url::to(['/admin/order/order-backend/update', 'id' => $order->id]); ?>">
                                            <?= $order->dateDelivery->date; ?>/<?= $order->dateDelivery->time; ?><br><?= $order->phone; ?><br><?= $order->street ? $order->street : null; ?><?= $order->number_home ? ',дом. ' . $order->number_home : null; ?><?= $order->number_appartament ? ',кв. ' . $order->number_appartament : null; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            На сегодня нет доставок!
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->render('include/modal-last-search', [
    'searches' => $searches
]); ?>
<?= $this->render('include/modal-loglist', [
    'logs' => $logs
]); ?>
<?= $this->render('include/modal-last-order'); ?>