<?php

use app\modules\site\models\tools\Price;
use app\modules\site\models\tools\Currency;
use yii\helpers\Html;
use app\modules\seo\models\tools\Title;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\order\models\helpers\OrderHelper;

/* @var $models \app\modules\order\models\entity\Order[]
 * @var $model \app\modules\logistic\models\forms\LogisticForm
 */

$this->title = Title::show("Список доставок");
?>
    <div class="title-group">
        <h1>Список доставок</h1>
    </div>

<?php if ($models): ?>
    <div class="logistic-list">
        <?php foreach ($models as $order): ?>
            <div class="logistic-list__item">
                <div class="logistic-list__title">
                    Заказ #<?= $order->id; ?>
                    <?php if ($order->is_paid): ?>
                        [<span class="green">Оплачено</span>]
                    <?php else: ?>
                        [<span class="red">Не оплачено</span>]
                    <?php endif; ?>
                </div>
                <div class="logistic-list-data">

                    <div class="logistic-list-data__row">
                        <div class="logistic-list-data__key">Сумма заказа:</div>
                        <div class="logistic-list-data__value red bold">
                            <?= Price::format(OrderHelper::orderSummary($order)); ?> <?= Currency::getInstance()->show(); ?>
                        </div>
                    </div>
                    <div class="logistic-list-data__row">
                        <div class="logistic-list-data__key">Статус:</div>
                        <div class="logistic-list-data__value"><?= OrderHelper::getStatus($order); ?></div>
                    </div>
                    <div class="logistic-list-data__row">
                        <div class="logistic-list-data__key">Оплата:</div>
                        <div class="logistic-list-data__value">
                            <?= OrderHelper::getPayment($order); ?>
                            <?php if (!empty($order->odd)): ?>
                                / <span class="red bold">Сдача: <?= Price::format($order->odd - OrderHelper::orderSummary($order)); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="logistic-list-data__col">
                        <div class="logistic-list-data__key">Телефон/Email:</div>
                        <div class="logistic-list-data__value">

                            <?php if ($order->phone): ?>
                                <span class="js-mask-phone"><?= $order->phone; ?></span>
                            <?php endif; ?>

                            <?php if ($order->email): ?>
                                <span><a href="mailto:<?= $order->email; ?>"><?= $order->email; ?></a></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="logistic-list-data__col">
                        <div class="logistic-list-data__key">Адрес доставки:</div>
                        <div class="logistic-list-data__value">
                            <?= !$order->city ? '' : $order->city; ?>
                            <?= !$order->street ? '' : $order->street; ?>
                            <?= !$order->number_home ? '' : $order->number_home; ?>
                            <?= !$order->entrance ? '' : $order->entrance; ?>
                            <?= !$order->number_appartament ? '' : ', кв. ' . $order->number_appartament; ?>
                            <?= !$order->floor_house ? '' : ', эт. ' . $order->floor_house; ?>
                        </div>
                    </div>
                </div>
                <div class="logistic-list__controls">
                    <?= Html::a(Html::tag('i', '', ['class' => 'fas fa-receipt']), Url::to(['/admin/order/order-backend/update', 'id' => $order->id])); ?>
                    <?= Html::a(Html::tag('i', '', ['class' => 'fas fa-phone']), 'tel:' . $order->phone); ?>
                    <?= Html::a(Html::tag('i', '', ['class' => 'fas fa-map-marker-alt']), 'javascript:void(0);'); ?>
                </div>
                <div class="logistic-list__action">
                    <?php if (!$order->is_close): ?>
                        <?php $form = ActiveForm::begin(); ?>
                        <?= $form->field($model, 'order_id')->hiddenInput(['value' => $order->id])->label(false) ?>
                        <?= Html::submitButton('Завершить заказ') ?>
                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>