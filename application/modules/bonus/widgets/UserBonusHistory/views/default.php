<?php

use yii\helpers\Html;

/* @var $models \app\modules\bonus\models\entity\UserBonusHistory[] */
/* @var $date_format string */

?>
<h3>История поступлений бонусов</h3>
<div class="bonus-history-table">
    <div class="bonus-history-table-header">
        <div class="bonus-history-table__reason">Причина</div>
        <div class="bonus-history-table__count">Кол-во</div>
        <div class="bonus-history-table__date">Дата начисления</div>
        <div class="bonus-history-table__available">Статус</div>
    </div>
    <?php foreach ($models as $item): ?>
        <div class="bonus-history-table-body">
            <div class="bonus-history-table__reason"><?= $item->reason; ?></div>
            <div class="bonus-history-table__count"><?= $item->count; ?></div>
            <div class="bonus-history-table__date"><?= date($date_format, $item->created_at); ?></div>
            <div class="bonus-history-table__available">
                <?= $item->is_active ? Html::tag('i', '', [
                    'class' => 'green far fa-check-circle'
                ]) : Html::tag('i', '', [
                    'class' => 'red far fa-clock'
                ]); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>