<?php
/* @var $ordersNow Order[]
 * @var $lastSearch \app\modules\search\models\entity\SearchQuery[]
 * @var $last_admission \app\modules\catalog\models\entity\NotifyAdmission[]
 * @var $searches \app\modules\search\models\entity\SearchQuery[]
 * @var $logs \app\modules\logger\models\entity\Logger[]
 * @var $this \yii\web\View
 * @var $no_attention_reviews \app\modules\reviews\models\entity\Reviews[]
 * @var $ozon_new \app\modules\marketplace\models\entity\MarketplaceProductStatus[]
 * @var $buy_items Product[]
 */

use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\modules\site\models\tools\Backup;
use yii\helpers\StringHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$product = Product::find();
?>
    <div class="statistic-wrap">
        <div class="statistic">
            <div class="statistic__item">
                <div class="statistic__icon"><i class="fas fa-tools"></i></div>
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


            <?= $this->render('include/stat-item/item-order-report'); ?>


            <div class="statistic__item">
                <div class="statistic__icon" data-toggle="modal" data-target="#product-stat"><i class="fas fa-cookie"></i></div>
                <div class="statistic__content">
                    <div class="statistic-info">
                        <div class="statistic-info__item">
                            <div class="statistic-info__key">Товаров</div>
                            <div class="statistic-info__value"><?= $product->count(); ?></div>
                        </div>
                        <div class="statistic-info__item">
                            <div class="statistic-info__key">А/Ожид/БП</div>
                            <div class="statistic-info__value"><?= $product->where(['status_id' => Product::STATUS_ACTIVE])->count(); ?>/<?= $product->where(['status_id' => Product::STATUS_WAIT])->count(); ?>/<?= $product->where(['vendor_id' => null])->count(); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="statistic__item">
                <a href="<?= Url::to(['/admin/search/search-history-backend/index']) ?>" target="_blank" class="statistic__icon"><i class="fas fa-search"></i></a>
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
                <a href="<?= Url::to(['/admin/logger/log-backend/index']); ?>" target="_blank" class="statistic__icon"><i class="fas fa-history"></i></a>
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
                <div class="statistic__icon"><i class="fas fa-truck"></i></div>
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
            <div class="statistic__item">
                <div class="statistic__icon"><i class="fas fa-feather-alt"></i></div>
                <div class="statistic__content">
                    <?php if ($no_attention_reviews): ?>
                        <div class="statistic-summary">
                            <?php foreach ($no_attention_reviews as $review): ?>
                                <div class="statistic-summary__item" title="<?= $review->text; ?>">
                                    <?= Html::a($review->text, Url::to(['/admin/reviews/reviews-backend/update', 'id' => $review->id])) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <span class="green">Отзывов без внимания нет!</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="statistic__item">
                <div class="statistic__icon"><i class="far fa-clock"></i></div>
                <div class="statistic__content">
                    <?php if ($last_admission): ?>
                        <div class="statistic-summary">
                            <?php foreach ($last_admission as $admission): ?>
                                <div class="statistic-summary__item" title="<?= $admission->email; ?>">
                                    <?= Html::a($admission->email . ' (' . date('d.m.Y', $admission->created_at) . ')', Url::to(['/admin/catalog/admission-backend/update', 'id' => $admission->id])) ?>
                                    <p style="font-size: 8px; margin: 0;">
                                        <?php $product = Product::findOne($admission->product_id); ?>

                                        <?= Html::a($product->name, Url::to(['/admin/catalog/product-backend/update', 'id' => $admission->product_id])) ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <span class="green">Никто не подписан на товар</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="statistic__item">
                <div class="statistic__icon"><i class="fas fa-cloud-moon"></i></div>
                <div class="statistic__content">
                    <?php if ($ozon_new): ?>
                        <div class="statistic-summary">
                            <?php foreach ($ozon_new as $model): ?>
                                <div class="statistic-summary__item" title="<?= $model->product_id; ?>">
                                    <?= Html::a($model->product_id . ' (' . date('d.m.Y', $model->created_at) . ')', Url::to(['/admin/catalog/admission-backend/update', 'id' => $model->id])) ?>
                                    <p style="font-size: 8px; margin: 0;">
                                        <?php $product = Product::findOne($model->product_id); ?>

                                        <?= Html::a($product->name, Url::to(['/admin/catalog/product-backend/update', 'id' => $model->product_id])) ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <span class="green">Новых товаров Ozon нет</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="statistic__item">
                <div class="statistic__icon"><i class="fas fa-cubes"></i></div>
                <div class="statistic__content">
                    <?php if ($buy_items): ?>
                        <div class="statistic-summary">
                            <?php foreach ($buy_items as $model): ?>
                                <?php if (!$model instanceof Product) continue; ?>
                                <div class="statistic-summary__item" title="<?= $model->name; ?>">
                                    <p style="font-size: 14px; margin: 0;">
                                        <?= Html::a($model->name, Url::to(['/admin/catalog/product-backend/update/', 'id' => $model->id])) ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <span class="green">Закупать для заказов ничего не требуется</span>
                    <?php endif; ?>
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
<?= $this->render('include/modal-product-stat'); ?>