<?php

use app\modules\site\models\tools\Price;
use app\modules\site\models\tools\Currency;
use yii\helpers\Html;
use app\modules\seo\models\tools\Title;
use yii\helpers\Url;
use app\modules\order\models\helpers\OrderHelper;

/* @var $models \app\modules\order\models\entity\Order[]
 */

$this->title = Title::show("Список доставок");
?>
    <div class="title-group">
        <h1>Список доставок</h1>
    </div>

<?php if ($models): ?>
    <div class="logistic-list">
        <?php foreach ($models as $model): ?>
            <div class="logistic-list__item">
                <div class="logistic-list__title">
                    Заказ #<?= $model->id; ?>
                </div>
                <div class="logistic-list-data">

                    <div class="logistic-list-data__row">
                        <div class="logistic-list-data__key">Сумма заказа:</div>
                        <div class="logistic-list-data__value red bold"><?= Price::format(OrderHelper::orderSummary($model)); ?> <?= Currency::getInstance()->show(); ?></div>
                    </div>
                    <div class="logistic-list-data__row">
                        <div class="logistic-list-data__key">Статус:</div>
                        <div class="logistic-list-data__value"><?= OrderHelper::getStatus($model); ?></div>
                    </div>

                    <div class="logistic-list-data__row">
                        <div class="logistic-list-data__key">Адрес доставки:</div>
                        <div class="logistic-list-data__value"><?= !$model->city ?: 'г.' . $model->city; ?><?= !$model->street ?: ', ул.' . $model->street; ?><?= !$model->number_home ?: ', д.' . $model->number_home; ?><?= !$model->number_appartament ?: ', кв.' . $model->number_appartament; ?></div>
                    </div>
                </div>
                <div class="logistic-list__controls">
                    <?= Html::a(Html::tag('i', '', ['class' => 'fas fa-receipt']), Url::to(['/admin/order/order-backend/update', 'id' => $model->id])); ?>
                    <?= Html::a(Html::tag('i', '', ['class' => 'fas fa-phone']), 'tel:' . $model->phone); ?>
                    <?= Html::a(Html::tag('i', '', ['class' => 'fas fa-map-marker-alt']), 'javascript:void(0);'); ?>
                </div>
                <div class="logistic-list__action">
                    <?php if (!$model->is_close): ?>
                        <a href="#">Завершить</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>