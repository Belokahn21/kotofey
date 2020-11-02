<?php

use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\models\entity\Order;
use app\models\tool\Currency;
use yii\helpers\ArrayHelper;
use app\models\tool\Price;

?>
<div class="modal fade" id="order-list" tabindex="-1" role="dialog" aria-labelledby="order-listLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="order-listLabel">Отчет по продажам</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <ul class="month-stat">
					<?php foreach (['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'] as $i => $month): ?>
                        <li class="month-stat__item">
							<?php
							$avail_mont_start = strtotime('01.' . ($i + 1) . '.' . date('Y'));
							$avail_mont_end = strtotime('31.' . ($i + 1) . '.' . date('Y'));
							$query = Order::find()->where(['>', 'created_at', $avail_mont_start])->andWhere(['<', 'created_at', $avail_mont_end]);
							?>
                            <div class="month-stat__title"><?= $month; ?></div>
                            <div class="month-stat__count">Заказов: <?= $query->count(); ?></div>
                            <div class="month-stat__rotate">Оборот: <?= ArrayHelper::getValue($query->all(), function ($models, $defaultValue) {
									$out = 0;
									foreach ($models as $model) {
										$out += OrderHelper::income($model->id);
									}
									return Price::format($out) . Currency::getInstance()->show();
								}) ?>
                            </div>
                            <div class="month-stat__summary">Доход: <?= ArrayHelper::getValue($query->all(), function ($models, $defaultValue) {
									$out = 0;
									foreach ($models as $model) {
										$out += OrderHelper::marginality($model->id);
									}
									return Price::format($out) . Currency::getInstance()->show();
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