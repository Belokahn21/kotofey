<?php
/* @var $lastSearch \app\modules\search\models\entity\SearchQuery[]
 * @var $searches \app\modules\search\models\entity\SearchQuery[]
 * @var $logs \app\modules\logger\models\entity\Logger[]
 * @var $this \yii\web\View
 */

use app\models\tool\Currency;
use app\models\tool\Price;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use yii\helpers\StringHelper;
use app\models\tool\Backup;

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
                <div class="statistic__icon" data-toggle="modal" data-target="#order-list"><i class="fas fa-cookie"></i></div>
                <div class="statistic__content">
                    <div class="statistic-info">
                        <div class="statistic-info__item">
                            <div class="statistic-info__key">Заказов</div>
                            <div class="statistic-info__value"><?= Order::find()->count(); ?></div>
                        </div>
                        <div class="statistic-info__item">
                            <div class="statistic-info__key">Прибыль</div>
                            <div class="statistic-info__value"><?= Price::format(OrderHelper::marginality()); ?><?= Currency::getInstance()->show(); ?></div>
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
                            <div class="statistic-info__value"><?= Product::find()->count(); ?></div>
                        </div>
                        <div class="statistic-info__item">
                            <div class="statistic-info__key">Прибыль</div>
                            <div class="statistic-info__value">---</div>
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
                                <div class="statistic-summary__item" title="<?= $search->text; ?>"><?= StringHelper::truncate($search->text, 25, '...'); ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="statistic__item">
                <div class="statistic__icon" data-toggle="modal" data-target="#log-list"><i class="fas fa-history"></i></div>
                <div class="statistic__content">
                    <?php if ($lastlogs): ?>
                        <div class="statistic-summary">
                            <?php foreach ($lastlogs as $log): ?>
                                <div class="statistic-summary__item" title="<?= $log->message; ?>"><?= StringHelper::truncate($log->message, 25, '...'); ?></div>
                            <?php endforeach; ?>
                        </div>
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