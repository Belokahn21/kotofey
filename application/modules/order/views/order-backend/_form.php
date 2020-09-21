<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\order\widgets\map\MapWidget;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\vendors\models\entity\Vendor;
use yii\helpers\Html;

/* @var $users \app\modules\user\models\entity\User[]
 * @var $model \app\modules\order\models\entity\Order
 * @var $deliveries app\modules\delivery\models\entity\Delivery[]
 * @var $payments \app\modules\payment\models\entity\Payment[]
 * @var $status \app\modules\order\models\entity\OrderStatus[]
 * @var $itemsModel \app\modules\order\models\entity\OrdersItems[]
 * @var $dateDelivery \app\modules\order\models\entity\OrderDate
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
    </div>
</nav>


<div class="tab-content" id="backendFormsContent">
    <?php if (!$model->isNewRecord): ?>
        <div class="tab-pane fade<?= ($model->isNewRecord ? '' : ' show active'); ?>" id="nav-detail-info-edit" role="tabpanel" aria-labelledby="nav-detail-info-edit-tab">
            <div class="backendFormsPanel">
                <div class="backendFormsPanel__form-side">
                    <h4></h4>
                    <p>Телефон <a href="tel:<?= $model->phone; ?>"><?= $model->phone; ?></a></p>
                    <p>Почта <a href="mailto:<?= $model->email; ?>"><?= $model->email; ?></a></p>

                    <?php if ($model->ip): ?>
                        <p>IP адрес <?= $model->ip; ?></p>
                    <?php endif; ?>

                    <h4>Время и дата доставки</h4>
                    <?php try { ?>
                        <p><?= $model->dateDelivery->date; ?> - <?= $model->dateDelivery->time; ?></p>
                    <?php } catch (ErrorException $exception) { ?>
                        <p>Отстуствуют</p>
                    <?php } ?>

                    <h4>Адрес доставки</h4>
                    <?php try { ?>
                        <ul style="display: flex; flex-direction: column;">
                            <?php if ($model->country): ?>
                                <li style="margin: 0 5px;">Страна <?= $model->country; ?></li>
                            <?php endif; ?>

                            <?php if ($model->city): ?>
                                <li style="margin: 0 5px;">Нас. пункт <?= $model->city; ?></li>
                            <?php endif; ?>

                            <?php if ($model->street): ?>
                                <li style="margin: 0 5px;">Улица <?= $model->street; ?></li>
                            <?php endif; ?>

                            <?php if ($model->number_home): ?>
                                <li style="margin: 0 5px;">Дом <?= $model->number_home; ?></li>
                            <?php endif; ?>

                            <?php if ($model->number_appartament): ?>
                                <li style="margin: 0 5px;">Квртира <?= $model->number_appartament; ?></li>
                            <?php endif; ?>

                        </ul>
                    <?php } catch (ErrorException $exception) { ?>
                        <p>Отстуствуют</p>
                    <?php } ?>

                    <h4>Финансы</h4>
                    <p>Закуп: <?= OrderHelper::orderPurchase($model->id); ?></p>
                    <p>Сумма заказа: <?= OrderHelper::orderSummary($model->id); ?></p>

                    <?php if ($model->promocodeEntity): ?>
                        <h4>Промокод</h4>
                        <p class="red"><?= $model->promocodeEntity->code; ?>, -<?= $model->promocodeEntity->discount; ?>%</p>
                    <?php endif; ?>

                    <?= MapWidget::widget([
                        'model' => $model
                    ]); ?>
                </div>
                <div class="backendFormsPanel__form-side">
                    <?php if (is_array($itemsModel)): ?>
                        <h2>Товары в заказе</h2>
                        <?php
                        $vendros = array();
                        ?>
                        <?php foreach ($itemsModel as $item):
                            if ($item->product->vendor_id):
                                $vendros[$item->product->vendor_id][] = $item;
                            endif;
                        endforeach; ?>

                        <?php if ($vendros): ?>
                            <ul>
                                <?php foreach ($vendros as $vendorId => $product): ?>
                                    <?php $vendor = Vendor::findOne($vendorId); ?>
                                    <li>Поставщк: <?= $vendor->name; ?>(<?= count($vendros[$vendorId]); ?>) <?= Html::a('Написать менеджеру', 'https://api.whatsapp.com/send?phone=89059858726&text=hello'); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <ul class="order-items-list">
                            <?php foreach ($itemsModel as $item): ?>
                                <li class="order-items-list__item">
                                    <?php if ($item->product): ?>
                                        <img class="order-items-list__image" src="<?= ProductHelper::getImageUrl($item->product) ?>" title="<?= $item->name; ?>" alt="<?= $item->name; ?>">
                                    <?php else: ?>
                                        <img class="order-items-list__image" src="/upload/images/not-image.png" title="<?= $item->name; ?>" alt="<?= $item->name; ?>">
                                    <?php endif; ?>

                                    <div class="order-items-list-info">
                                        <?php if ($item->product): ?>
                                            <p><a href="<?= Url::to(['/admin/catalog/product-backend/update', 'id' => $item->product->id]) ?>"><?= $item->name; ?></a></p>
                                        <?php else: ?>
                                            <p><?= $item->name; ?></p>
                                        <?php endif; ?>
                                        <?php if ($item->product): ?>
                                            <p>Внешний код: <?= $item->product->code; ?></p>
                                        <?php endif; ?>
                                        <?php if ($item->product): ?>
                                            <p>Зкупочная: <?= $item->product->purchase; ?></p>
                                        <?php endif; ?>
                                        <p>К продаже: <?= $item->price; ?></p>
                                        <p>Кол-во: <?= $item->count; ?></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
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
        <div class="d-flex flex-row">
            <div class="w-25 p-1"><?= $form->field($model, 'minusStock')->checkbox(); ?></div>
            <div class="w-25 p-1"><?= $form->field($model, 'plusStock')->checkbox(); ?></div>
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
                    <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Телефон'])->label(false); ?>
                </div>
                <div class="w-25 p-1">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false); ?>
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
                        <?= $form->field($model, 'postalcode')->textInput(); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'country')->textInput(); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'region')->textInput(); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'city')->textInput(); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'street')->textInput(); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'number_home')->textInput(); ?>
                    </div>

                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($model, 'number_appartament')->textInput(); ?>
                    </div>

                </div>
            </div>
            <div class="backendFormsPanel__form-side">
                <h3>Дата и время доставки</h3>
                <div class="order-delivery-info">
                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($dateDelivery, 'date')->textInput(['class' => 'js-datepicker form-control']); ?>
                    </div>
                    <div class="form-element order-delivery-info__item">
                        <?= $form->field($dateDelivery, 'time')->textInput(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>