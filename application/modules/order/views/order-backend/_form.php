<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\site\models\tools\Price;
use app\modules\site\models\tools\Currency;
use app\modules\order\widgets\map\MapWidget;
use \app\modules\user\models\helpers\UserHelper;
use app\modules\order\models\helpers\OrderHelper;
use app\models\tool\parser\providers\SibagroTrade;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\order\widgets\BuyerInfo\BuyerInfoWidget;
use app\modules\delivery\ProfileTracking\ProfileTrackingWidget;
use app\modules\order\widgets\CustomerInput\CustomerInputWidget;
use app\modules\order\widgets\FastManagerMessage\FastManagerMessage;

/* @var $users \app\modules\user\models\entity\User[]
 * @var $model \app\modules\order\models\entity\Order
 * @var $deliveries app\modules\delivery\models\entity\Delivery[]
 * @var $payments \app\modules\payment\models\entity\Payment[]
 * @var $status \app\modules\order\models\entity\OrderStatus[]
 * @var $itemsModel \app\modules\order\models\entity\OrdersItems[]
 * @var $dateDelivery \app\modules\order\models\entity\OrderDate
 * @var $trackForm \app\modules\order\models\entity\OrderTracking
 */

?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <?php if (!$model->isNewRecord): ?>
            <a class="nav-item nav-link<?= (!$model->isNewRecord ? ' active' : ''); ?>" id="nav-detail-info-edit-tab" data-toggle="tab" href="#nav-detail-info-edit" role="tab" aria-controls="nav-detail-info-edit" aria-selected="false">Общая инофрмация</a>
        <?php endif; ?>
        <a class="nav-item nav-link<?= ($model->isNewRecord ? ' active' : ''); ?>" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-items-edit-tab" data-toggle="tab" href="#nav-items-edit" role="tab" aria-controls="nav-items-edit" aria-selected="false">Товары в заказе</a>
        <a class="nav-item nav-link" id="nav-delivery-edit-tab" data-toggle="tab" href="#nav-delivery-edit" role="tab" aria-controls="nav-delivery-edit" aria-selected="false">Доставка</a>
        <a class="nav-item nav-link" id="nav-history-edit-tab" data-toggle="tab" href="#nav-history-edit" role="tab" aria-controls="nav-history-edit" aria-selected="false">История заказа</a>
        <a class="nav-item nav-link" id="nav-tracking-edit-tab" data-toggle="tab" href="#nav-tracking-edit" role="tab" aria-controls="nav-tracking-edit" aria-selected="false">Отслеживание заказа</a>
    </div>
</nav>


<div class="tab-content" id="backendFormsContent">
    <?php if (!$model->isNewRecord): ?>
        <div class="tab-pane fade<?= ($model->isNewRecord ? '' : ' show active'); ?>" id="nav-detail-info-edit" role="tabpanel" aria-labelledby="nav-detail-info-edit-tab">
            <div class="backendFormsPanel">
                <div class="backendFormsPanel__form-side">
                    <div class="info-card-wrapper">

                        <?= BuyerInfoWidget::widget([
                            'order' => $model
                        ]); ?>

                        <div class="info-card">
                            <div class="title">Финансы</div>
                            <div class="text">Закуп: <?= Price::format(OrderHelper::orderPurchase($model->id)); ?></div>
                            <div class="text">Сумма заказа: <?= Price::format(OrderHelper::orderSummary($model)); ?></div>
                            <?php $marge = OrderHelper::marginality($model); ?>
                            <div class="text">Прибыль: <?= $marge > 1 ? '<span class="green">+' . $marge . '</span>' : '<span class="red">' . $marge . '</span>'; ?></div>
                            <hr/>
                            <?php if (!empty($model->bonus)): ?>
                                <div class="text">Бонусы: <?= $model->bonus; ?> <?= Currency::getInstance()->show(); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($model->odd)): ?>
                                <div class="text red">
                                    Требуется сдача с: <?= $model->odd; ?> <?= Currency::getInstance()->show(); ?>
                                    <br>
                                    Сдача <?= $model->odd - OrderHelper::orderSummary($model); ?> <?= Currency::getInstance()->show(); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="info-card">
                            <div class="title">Статус заказа</div>
                            <div class="text">[<?= $model->is_paid ? '<span class="green">Оплачено</span>' : '<span class="red">Не оплачено</span>'; ?>]</div>
                            <div class="text">[<?= $model->is_close ? '<span class="green">Закрыт</span>' : '<span class="red">Не закрыт</span>'; ?>]</div>
                        </div>

                        <div class="info-card">
                            <div class="title">Дата и адрес доставки</div>
                            <div class="text">
                                <?php try { ?>
                                    <?= $model->dateDelivery->date; ?> - <?= $model->dateDelivery->time; ?>
                                <?php } catch (ErrorException $exception) { ?>
                                    Отстуствуют
                                <?php } ?>
                            </div>

                            <?php if ($model->country): ?>
                                <div class="text">Страна <?= $model->country; ?></div>
                            <?php endif; ?>

                            <?php if ($model->city): ?>
                                <div class="text">Нас. пункт <?= $model->city; ?></div>
                            <?php endif; ?>

                            <?php if ($model->street): ?>
                                <div class="text">Улица <?= $model->street; ?></div>
                            <?php endif; ?>

                            <?php if ($model->number_home): ?>
                                <div class="text">Дом <?= $model->number_home; ?></div>
                            <?php endif; ?>

                            <?php if ($model->entrance): ?>
                                <div class="text">Подьезд <?= $model->entrance; ?></div>
                            <?php endif; ?>

                            <?php if ($model->floor_house): ?>
                                <div class="text">Этаж <?= $model->floor_house; ?></div>
                            <?php endif; ?>

                            <?php if ($model->number_appartament): ?>
                                <div class="text">Квртира <?= $model->number_appartament; ?></div>
                            <?php endif; ?>

                        </div>

                        <?php if ($model->promocodeEntity): ?>
                            <div class="info-card">
                                <div class="title">Промокод</div>
                                <div class="red text"><?= $model->promocodeEntity->code; ?>, -<?= $model->promocodeEntity->discount; ?>%</div>
                            </div>
                        <?php endif; ?>

                    </div>
                    <?= MapWidget::widget([
                        'model' => $model
                    ]); ?>
                </div>
                <div class="backendFormsPanel__form-side">
                    <?php if (is_array($itemsModel)): ?>
                        <h2>Товары в заказе</h2>
                        <?= FastManagerMessage::widget([
                            'items' => $itemsModel
                        ]); ?>

                        <?php $summary_weight = 0; ?>

                        <div class="order-items-list">
                            <?php foreach ($itemsModel as $item): ?>
                                <div class="order-items-list__item<?= ($item->product && ($item->product->count >= $item->count)) ? ' isFull' : ''; ?>">
                                    <?php if ($item->product): ?>
                                        <img class="order-items-list__image" src="<?= ProductHelper::getImageUrl($item->product) ?>" title="<?= $item->name; ?>" alt="<?= $item->name; ?>">
                                    <?php else: ?>
                                        <img class="order-items-list__image" src="/upload/images/not-image.png" title="<?= $item->name; ?>" alt="<?= $item->name; ?>">
                                    <?php endif; ?>

                                    <div class="order-items-list-info">
                                        <?php if ($item->product): ?>
                                            <div class="order-items-list-info__name"><a href="<?= Url::to(['/admin/catalog/product-backend/update', 'id' => $item->product->id]) ?>"><?= $item->name; ?></a></div>
                                        <?php else: ?>
                                            <div><?= $item->name; ?></div>
                                        <?php endif; ?>
                                        <?php if ($item->product): ?>
                                            <div>Внешний код: <?= $item->product && $item->product->vendor_id == 4 ? Html::a($item->product->code, SibagroTrade::getProductDetailByCode($item->product->code), ['target' => '_blank']) : $item->product->code; ?></div>
                                            <div>Зкупочная: <?= $item->product->purchase; ?></div>
                                            <div>Сейчас на складе: <?= $item->product->count; ?></div>
                                            <div>Вес позиций: <?= $summary_weight += PropertiesHelper::getProductWeight($item->product->id) * $item->count; ?></div>
                                        <?php endif; ?>
                                        <div>К продаже за штуку: <?= Price::format($item->price); ?><?= $item->discount_price ? ' / со скидкой ' . Price::format($item->discount_price) : null; ?></div>
                                        <div>Кол-во: <?= $item->count; ?></div>
                                        <div>Итого к продаже:
                                            <?= Price::format($item->price * $item->count) ?>
                                            <?= $item->discount_price ? ' / со скидкой ' . Price::format($item->discount_price * $item->count) : null; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div>Общий вес заказа: <?= $summary_weight; ?> кг.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="tab-pane fade<?= ($model->isNewRecord ? ' show active' : ''); ?>" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="d-flex flex-row">
            <div class="w-25 p-1"><?= $form->field($model, 'is_paid')->checkbox(); ?></div>
            <div class="w-25 p-1"><?= $form->field($model, 'is_cancel')->checkbox(); ?></div>
            <div class="w-25 p-1"><?= $form->field($model, 'is_close')->checkbox(); ?></div>
        </div>
        <div class="form-element">
            <div class="d-flex flex-row">
                <div class="w-25 p-1">
                    <?= $form->field($model, 'delivery_id')->dropDownList(ArrayHelper::map($deliveries, 'id', 'nameF'), [
                        'prompt' => 'Доставка'
                    ])->label(false); ?>
                </div>

                <div class="w-25 p-1">
                    <?= $form->field($model, 'payment_id')->dropDownList(ArrayHelper::map($payments, 'id', 'nameF'), [
                        'prompt' => 'Оплата'
                    ])->label(false); ?>
                </div>

                <div class="w-25 p-1">
                    <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map($status, 'id', 'name'), [
                        'prompt' => 'Статус'
                    ])->label(false); ?>
                </div>

                <div class="w-25 p-1">
                    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map($users, 'id', 'email'), [
                        'prompt' => 'Покупатель'
                    ])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-element">
            <div class="d-flex flex-row">
                <div class="w-25 p-1">
                    <?php if (Yii::$app->user->id == 1 && Yii::$app->request->get('debug') == 'Y'): ?>
                        <?= $form->field($model, 'phone')->widget(CustomerInputWidget::className(), [
                            'placeholder' => 'Телефон клиента'
                        ])->label(false); ?>
                    <?php else: ?>
                        <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Телефон', 'class' => 'form-control clean-phone'])->label(false); ?>
                    <?php endif; ?>
                </div>
                <div class="w-25 p-1">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false); ?>
                </div>
                <div class="w-25 p-1">
                    <?= $form->field($model, 'promocode')->textInput(['placeholder' => 'Промокод'])->label(false); ?>
                </div>
                <div class="w-25 p-1">
                    <?= $form->field($model, 'discount')->textInput(['placeholder' => 'Скидка'])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-element">
            <div class="d-flex flex-row">
                <div class="w-25 p-1">
                    <?= $form->field($model, 'client')->textInput(['placeholder' => 'ФИО клиента', 'class' => 'form-control clean-phone'])->label(false); ?>
                </div>
                <div class="w-25 p-1">
                    <?= $form->field($model, 'odd')->textInput(['placeholder' => 'Сдача'])->label(false); ?>
                </div>
                <div class="w-25 p-1">
                    <?= $form->field($model, 'manager_id')->dropDownList(ArrayHelper::map(UserHelper::getManagers(), 'id', 'email'), ['prompt' => 'Менеджер заказа'])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-element">
            <div class="d-flex flex-row">
                <div class="w-50 p-1">
                    <?= $form->field($model, 'notes')->textarea(['rows' => 10]); ?>
                </div>
                <div class="w-50 p-1">
                    <?= $form->field($model, 'comment')->textarea(['rows' => 10]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-items-edit" role="tabpanel" aria-labelledby="nav-items-edit-tab">
        <?php if ($model->isNewRecord or !is_array($itemsModel)): ?>
            <?= $this->render('include/new_items', [
                'itemsModel' => $itemsModel,
                'form' => $form
            ]); ?>
        <?php else: ?>
            <?= $this->render('include/update_items', [
                'itemsModel' => $itemsModel,
                'form' => $form
            ]); ?>
        <?php endif; ?>

    </div>

    <div class="tab-pane fade" id="nav-delivery-edit" role="tabpanel" aria-labelledby="nav-delivery-edit">
        <div class="backendFormsPanel">
            <div class="backendFormsPanel__form-side">
                <h3>Адрес доставки</h3>
                <div class="order-delivery-info">
                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'postalcode')->textInput(['placeholder' => 'Почтовый индекс'])->label(false); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'country')->textInput(['placeholder' => 'Регион'])->label(false); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'region')->textInput(['placeholder' => 'Регион'])->label(false); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'city')->textInput(['placeholder' => 'Город'])->label(false); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'street')->textInput(['placeholder' => 'Улица'])->label(false); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'number_home')->textInput(['placeholder' => 'Номер дома'])->label(false); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'entrance')->textInput(['placeholder' => 'Подъезд'])->label(false); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'floor_house')->textInput(['placeholder' => 'Этаж'])->label(false); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'number_appartament')->textInput(['placeholder' => 'Квартира'])->label(false); ?>
                    </div>

                </div>
            </div>
            <div class="backendFormsPanel__form-side">
                <h3>Дата и время доставки</h3>
                <div class="order-delivery-info">
                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($dateDelivery, 'date')->textInput(['class' => 'js-datepicker form-control', 'placeholder' => 'День доставки'])->label(false); ?>
                    </div>
                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($dateDelivery, 'time')->textInput(['placeholder' => 'Время доставки'])->label(false); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="nav-history-edit" role="tabpanel" aria-labelledby="nav-history-edit">
        <?php if ($bonus = \app\modules\bonus\models\entity\UserBonusHistory::findOneByOrder($model)): ?>
            <?= Html::a('Начислено ' . $bonus->count . ' бонуса', Url::to(['/admin/bonus/bonus-history-backend/update', 'id' => $bonus->id])); ?>
        <?php endif; ?>

        <?php if ($sberPayment = \app\modules\acquiring\models\entity\AcquiringOrder::findOne(['order_id' => $model->id])): ?>
            <hr/>
            <?= Html::a('Эквайринг транзакция: ' . $sberPayment->identifier_id, Url::to(['/admin/acquiring/acquiring-backend/update', 'id' => $sberPayment->id])); ?>
        <?php endif; ?>

        <?php if ($check = \app\modules\acquiring\models\entity\AcquiringOrderCheck::findOne(['order_id' => $model->id])): ?>
            <hr/>
            <?= Html::a('Выдан чек: ' . $check->identifier_id, Url::to(['/admin/acquiring/acquiring-check-backend/update', 'id' => $check->id])); ?>
        <?php endif; ?>
    </div>

    <div class="tab-pane fade" id="nav-tracking-edit" role="tabpanel" aria-labelledby="nav-tracking-edit">
        <div class="row">
            <div class="col-6">
                <?= $form->field($trackForm, 'ident_key'); ?>
                <?= $form->field($trackForm, 'service_id')->dropDownList($trackForm->listDeliveryServices(), ['prompt' => 'Сервис доставки']); ?>
            </div>
            <div class="col-6">
                Ответ от сервера отслеживания
                <?= ProfileTrackingWidget::widget(['order' => $model]); ?>
            </div>
        </div>
    </div>
</div>