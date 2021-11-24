<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\site\models\tools\Currency;
use app\modules\order\widgets\map\MapWidget;
use app\modules\site\models\tools\PriceTool;
use \app\modules\user\models\helpers\UserHelper;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\search\models\entity\SearchQuery;
use app\models\tool\parser\providers\SibagroTrade;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\order\models\entity\OrderMailHistory;
use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\order\widgets\BuyerInfo\BuyerInfoWidget;
use app\modules\acquiring\models\entity\AcquiringOrderCheck;
use app\modules\catalog\models\entity\ProductTransferHistory;
use app\modules\order\widgets\CustomerInput\CustomerInputWidget;
use app\modules\order\widgets\FastManagerMessage\FastManagerMessage;
use app\modules\delivery\widgets\ProfileTracking\ProfileTrackingWidget;

/* @var $users \app\modules\user\models\entity\User[]
 * @var $model \app\modules\order\models\entity\Order
 * @var $deliveries app\modules\delivery\models\entity\Delivery[]
 * @var $payments \app\modules\payment\models\entity\Payment[]
 * @var $status \app\modules\order\models\entity\OrderStatus[]
 * @var $itemsModel \app\modules\order\models\entity\OrdersItems[]
 * @var $dateDelivery \app\modules\order\models\entity\OrderDate
 * @var $trackForm \app\modules\order\models\entity\OrderTracking
 * @var $form \yii\widgets\ActiveForm
 */

?>
<div class="new-design-form">
    <div class="row">
        <div class="col-12 col-lg-6">

            <div class="row">
                <div class="col-sm-3"><?= $form->field($model, 'is_paid')->checkbox(); ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'is_cancel')->checkbox(); ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'is_close')->checkbox(); ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'is_skip')->checkbox(); ?></div>
            </div>

            <div class="row">
                <div class="col-sm-3"><?= $form->field($model, 'delivery_id')->dropDownList(ArrayHelper::map($deliveries, 'id', 'nameF'), ['prompt' => 'Доставка']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'payment_id')->dropDownList(ArrayHelper::map($payments, 'id', 'nameF'), ['prompt' => 'Оплата']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'status')->dropDownList(ArrayHelper::map($status, 'id', 'name'), ['prompt' => 'Статус']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map($users, 'id', 'email'), ['prompt' => 'Покупатель']) ?></div>
            </div>

            <div class="row">
                <div class="col-sm-3"><?= $form->field($model, 'phone')->widget(CustomerInputWidget::className(), ['placeholder' => 'Телефон клиента']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'email')->textInput(['placeholder' => 'Email']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'promocode')->textInput(['placeholder' => 'Промокод']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'discount')->textInput(['placeholder' => 'Скидка']) ?></div>
            </div>

            <div class="row">
                <div class="col-sm-3"><?= $form->field($model, 'client')->textInput(['placeholder' => 'ФИО клиента', 'class' => 'form-control clean-phone']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'odd')->textInput(['placeholder' => 'Сдача']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'manager_id')->dropDownList(ArrayHelper::map(UserHelper::getManagers(), 'id', 'email'), ['prompt' => 'Менеджер заказа']) ?></div>
                <div class="col-sm-3"><?= $form->field($model, 'bonus')->textInput(['placeholder' => 'Списать клиентские бонусы']) ?></div>
            </div>

            <div class="row">
                <div class="col-sm-6"><?= $form->field($model, 'notes')->textarea(['rows' => 10]); ?></div>
                <div class="col-sm-6"><?= $form->field($model, 'comment')->textarea(['rows' => 10]); ?></div>
            </div>

            <h4>Список товаров</h4>
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

            <div class="row">
                <div class="col-sm-6">
                    <h4>Адрес доставки</h4>
                    <div class="row">
                        <div class="col-sm-4"><?= $form->field($model, 'postalcode')->textInput(['placeholder' => 'Почтовый индекс'])->label("Индекс") ?></div>
                        <div class="col-sm-4"><?= $form->field($model, 'country')->textInput(['placeholder' => 'Страна']) ?></div>
                        <div class="col-sm-4"><?= $form->field($model, 'region')->textInput(['placeholder' => 'Регион']) ?></div>
                        <div class="col-sm-4"><?= $form->field($model, 'city')->textInput(['placeholder' => 'Город']) ?></div>
                        <div class="col-sm-4"><?= $form->field($model, 'street')->textInput(['placeholder' => 'Улица']) ?></div>
                        <div class="col-sm-4"><?= $form->field($model, 'number_home')->textInput(['placeholder' => 'Номер дома']) ?></div>
                        <div class="col-sm-4"><?= $form->field($model, 'entrance')->textInput(['placeholder' => 'Подъезд']) ?></div>
                        <div class="col-sm-4"><?= $form->field($model, 'floor_house')->textInput(['placeholder' => 'Этаж']) ?></div>
                        <div class="col-sm-4"><?= $form->field($model, 'number_appartament')->textInput(['placeholder' => 'Квартира']) ?></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h4>Дата и время доставки</h4>
                    <div class="row">
                        <div class="col-sm-6"><?= $form->field($dateDelivery, 'date')->textInput(['class' => 'js-datepicker form-control', 'placeholder' => 'День доставки']) ?></div>
                        <div class="col-sm-6"><?= $form->field($dateDelivery, 'time')->textInput(['placeholder' => 'Время доставки']) ?></div>
                    </div>
                </div>
            </div>


            <h4>Отслеживание заказа</h4>
            <div class="row">
                <div class="col-sm-6"><?= $form->field($trackForm, 'ident_key'); ?></div>
                <div class="col-sm-6"><?= $form->field($trackForm, 'service_id')->dropDownList($trackForm->listDeliveryServices(), ['prompt' => 'Сервис доставки']); ?></div>
            </div>

        </div>

        <?php if (!$model->isNewRecord): ?>
            <div class="col-12 col-lg-6">

                <div class="info-card-wrapper">

                    <?= BuyerInfoWidget::widget([
                        'order' => $model,
                        'view' => 'one-block',
                    ]); ?>

                    <div class="info-card">
                        <div class="info-card-block">
                            <div class="title">Финансы</div>
                            <div class="text">Закуп: <?= PriceTool::format(OrderHelper::orderPurchase($model)); ?></div>
                            <div class="text">Сумма заказа: <?= PriceTool::format(OrderHelper::orderSummary($model)); ?></div>
                            <?php $marge = OrderHelper::marginality($model); ?>
                            <div class="text">Прибыль: <?= $marge > 1 ? '<span class="green">+' . $marge . '</span>' : '<span class="red">' . $marge . '</span>'; ?></div>
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
                        <div class="info-card-block">
                            <div class="title">Статус заказа</div>
                            <div class="text">[<?= $model->is_paid ? '<span class="green">Оплачено</span>' : '<span class="red">Не оплачено</span>'; ?>]</div>
                            <div class="text">[<?= $model->is_close ? '<span class="green">Закрыт</span>' : '<span class="red">Не закрыт</span>'; ?>]</div>
                        </div>

                        <div class="info-card-block">
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
                                <div class="text">Квартира <?= $model->number_appartament; ?></div>
                            <?php endif; ?>
                        </div>

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


                <h4>История заказа</h4>
                <div class="row">
                    <div class="col-sm-12">
                        <?php if ($bonus = \app\modules\bonus\models\entity\UserBonusHistory::findOneByOrder($model)): ?>
                            <?= Html::a('Начислено ' . $bonus->count . ' бонуса', Url::to(['/admin/bonus/bonus-history-backend/update', 'id' => $bonus->id])); ?>
                        <?php endif; ?>

                        <?php if ($sberPayment = AcquiringOrder::findOne(['order_id' => $model->id])): ?>
                            <hr/>
                            <?= Html::a('Эквайринг транзакция: ' . $sberPayment->identifier_id, Url::to(['/admin/acquiring/acquiring-backend/update', 'id' => $sberPayment->id])); ?>
                        <?php endif; ?>

                        <?php if ($check = AcquiringOrderCheck::findOne(['order_id' => $model->id])): ?>
                            <hr/>
                            <?= Html::a('Выдан чек: ' . $check->identifier_id, Url::to(['/admin/acquiring/acquiring-check-backend/update', 'id' => $check->id])); ?>
                        <?php endif; ?>

                        <?php foreach (OrderMailHistory::findAll(['order_id' => $model->id]) as $mail): ?>
                            <hr/>
                            <?= Html::a('[' . date('d.m.Y', $mail->created_at) . ']Отправлено письмо: ' . $mail->event->name, Url::to(['order-mail-history-backend/update', 'id' => $mail->id])); ?> / <?= Html::a('Удалить письмо #' . $mail->id, Url::to(['order-mail-history-backend/delete', 'id' => $mail->id])); ?>
                        <?php endforeach; ?>

                        <?php if ($transfers = ProductTransferHistory::find()->where(['order_id' => $model->id])->all()): ?>
                            <?php foreach ($transfers as $transfer): ?>
                                <hr/>
                                (<strong><?= ArrayHelper::getValue($transfer->getOperations(), $transfer->operation_id); ?></strong>) <?= Html::a($transfer->reason, Url::to(['/admin/catalog/transfer-backend/update', 'id' => $transfer->id])) ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($searches = SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->where(['ip' => $model->ip])->all()): ?>
                    <h4>История поиска</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php foreach ($searches as $search): ?>
                                <div class="row">
                                    <div class="col-sm-6"><?= $search->text; ?></div>
                                    <div class="col-sm-6"><span><?= date('d.m.Y', $search->created_at) == date('d.m.Y') ? '<span class="bold green">Сегодня</span>' : date('d.m.Y', $search->created_at); ?></span></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-12">
                        <?= ProfileTrackingWidget::widget(['order' => $model]); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
