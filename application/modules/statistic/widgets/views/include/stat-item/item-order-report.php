<?php

use app\modules\order\models\helpers\OrderHelper;
use app\modules\site\models\tools\Currency;
use app\modules\order\models\entity\Order;
use app\modules\site\models\tools\Price;

$avail_mont_start = strtotime('01.01.' . date('Y'));
$avail_mont_end = strtotime('31.12.' . date('Y'));

?>
<div class="statistic__item">
    <div class="statistic__icon" data-toggle="modal" data-target="#order-list"><i class="fas fa-cookie"></i></div>
    <div class="statistic__content">
        <div class="statistic-info">
            <div class="statistic-info__item">
                <div class="statistic-info__key">Заказов</div>
                <div class="statistic-info__value"><?= Order::find()->where(['>', 'created_at', $avail_mont_start])->andWhere(['<', 'created_at', $avail_mont_end])->count(); ?></div>
            </div>
            <div class="statistic-info__item">
                <div class="statistic-info__key">Прибыль</div>
                <div class="statistic-info__value"><?= Price::format(OrderHelper::marginalityAllOrder([
                        ['>', 'created_at', $avail_mont_start],
                        ['<', 'created_at', $avail_mont_end]
                    ])); ?><?= Currency::getInstance()->show(); ?></div>
            </div>
            <div class="statistic-info__item">
                <div class="statistic-info__key">Оборот</div>
                <div class="statistic-info__value"><?= Price::format(OrderHelper::rotate([
                        ['>', 'created_at', $avail_mont_start],
                        ['<', 'created_at', $avail_mont_end]
                    ])); ?><?= Currency::getInstance()->show(); ?></div>
            </div>
        </div>
    </div>
</div>