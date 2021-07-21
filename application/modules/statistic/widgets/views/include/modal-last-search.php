<?php
/* @var $searches \app\modules\search\models\entity\SearchQuery[] */

use yii\helpers\Html;
use app\modules\order\models\entity\Order;
use yii\helpers\Url;

?>
<div class="modal fade" id="search-list" tabindex="-1" role="dialog" aria-labelledby="search-listLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="search-listLabel">Что ищут люди?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if ($searches): ?>
                    <div class="search-history">
                        <div class="search-history__item header-item">
                            <div class="search-history__ip">IP</div>
                            <div class="search-history__phrase">Запрос</div>
                            <div class="search-history__count">Найдено</div>
                            <div class="search-history__date">Дата</div>
                        </div>
                        <?php foreach ($searches as $search): ?>
                            <div class="search-history__item">
                                <div class="search-history__ip"><?= Html::a($search->ip, Url::to(['/admin/order/order-backend/index/', 'OrderSearchForm[ip]' => $search->ip]), ['target' => '_blank']); ?>(<?= Order::find()->where(['ip' => $search->ip])->count(); ?> / <?= $search->count; ?>)</div>
                                <div class="search-history__phrase"><?= Html::a($search->text, '/search/?Search[search]=' . $search->text, ['target' => '_blank']) ?></div>
                                <div class="search-history__count"><?= $search->count_find; ?></div>
                                <div class="search-history__date"><?= date('d.m.Y', $search->created_at) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>