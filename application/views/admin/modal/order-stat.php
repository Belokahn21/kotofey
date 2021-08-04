<?php

use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\models\entity\Order;
use yii\helpers\ArrayHelper;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\PriceTool;

?>
<div class="modal fade" id="show-order-stat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Отчет по продажам(Закр+опл)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <ul class="month-stat">
                    <?php foreach (['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Ноябрь', 'Октябрь', 'Декабрь'] as $i => $month): ?>
                        <li class="month-stat__item">
                            <?php
                            $avail_mont_start = strtotime('01.' . ($i + 1) . '.' . date('Y'));
                            $avail_mont_end = strtotime('31.' . ($i + 1) . '.' . date('Y'));
                            $query = Order::find()
                                ->where(['>', 'created_at', $avail_mont_start])
                                ->andWhere(['<', 'created_at', $avail_mont_end])
                                ->andWhere(['is_close' => true, 'is_paid' => true]);
                            ?>
                            <div class="month-stat__title"><?= $month; ?></div>
                            <div class="month-stat__count">Заказов: <?= $query->count(); ?></div>
                            <div class="month-stat__rotate">Оборот: <?= ArrayHelper::getValue($query->all(), function ($models, $defaultValue) {
                                    $out = 0;
                                    foreach ($models as $model) {
                                        $out += OrderHelper::income($model);
                                    }
                                    return PriceTool::format($out) . Currency::getInstance()->show();
                                }) ?>
                            </div>
                            <div class="month-stat__summary">Доход: <?= ArrayHelper::getValue($query->all(), function ($models, $defaultValue) {
                                    $out = 0;
                                    foreach ($models as $model) {
                                        $out += OrderHelper::marginality($model->id);
                                    }
                                    return PriceTool::format($out) . Currency::getInstance()->show();
                                }) ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>