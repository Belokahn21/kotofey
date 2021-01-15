<?php

/* @var $this yii\web\View
 * @var $order Order
 * @var $basket \app\modules\order\models\entity\OrdersItems[]
 * @var $billing \app\modules\user\models\entity\Billing
 * @var $user \app\modules\user\models\entity\User
 * @var $deliveries app\modules\delivery\models\entity\Delivery[]
 * @var $payments \app\modules\payment\models\entity\Payment[]
 * @var $order_date \app\modules\order\models\entity\OrderDate
 * @var $delivery_time \app\modules\order\models\service\DeliveryTimeService
 * @var $billing_list \app\modules\user\models\entity\Billing[]
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\tool\Price;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\models\tool\Currency;
use app\widgets\Breadcrumbs;
use app\models\tool\seo\Title;
use app\modules\order\models\entity\Order;
use app\modules\basket\models\entity\Basket;
use app\modules\payment\models\entity\Payment;
use app\modules\delivery\models\entity\Delivery;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\bonus\widgets\BonusFiled\BonusFieldWidget;
use app\modules\promocode\widgets\promocode_field\PromocodeFieldWidget;

$this->title = Title::showTitle("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/order/']];
?>
<div class="page">
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <h1 class="page__title">Оформление заказа</h1>
    <div class="page__group-row">
        <div class="page__left">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'checkout-form'
                ]
            ]); ?>
            <?php if ($deliveries): ?>
                <div class="checkout-form__title">Укажите способ доставки</div>
                <div class="checkout-form-variants">
                    <?= $form->field($order, 'delivery_id')->radioList(ArrayHelper::map($deliveries, 'id', 'name'), [
                        'item' => function ($index, $label, $name, $checked, $value) {
                            $payment = Delivery::findOne($value);

                            return <<<LIST
                        <input class="checkbox-budget" id="budget-9090$index" value="$value" type="radio" name="$name">
                        <label class="for-checkbox-budget checkout-form-variants__item" for="budget-9090$index">
                            <span class="checkout-form-variants__card">
                            <div class="checkout-form-variants__label">$label</div>
                                <img class="checkout-form-variants__icon" src="/upload/$payment->image">
                            </span>
                        </label>
LIST;
                        }
                    ]) ?>
                </div>
            <?php endif; ?>
            <div class="checkout-form__title">Промокод и бонусы
                <div class="checkout-form__group-row">
                    <label class="checkout-form__label" for="checkout-phone">
                        <div>Промокод</div>
                        <?= $form->field($order, 'promocode')->widget(PromocodeFieldWidget::className())->label(false) ?>
                    </label>

                    <label class="checkout-form__label" for="checkout-phone">
                        <div>Бонусы</div>
                        <?= $form->field($order, 'bonus')->widget(BonusFieldWidget::className())->label(false) ?>
                    </label>
                </div>
            </div>
            <div class="checkout-form__title">Укажите ваши данные
                <div class="checkout-form__group-row">
                    <label class="checkout-form__label" for="checkout-phone">
                        <div>Ваш номер телефона*</div>
                        <?= $form->field($order, 'phone')->textInput(['class' => 'js-mask-ru checkout-form__input', 'id' => 'checkout-phone', 'placeholder' => 'Ваш номер телефона', 'value' => Yii::$app->user->isGuest ? null : substr(Yii::$app->user->identity->phone, 1, strlen(Yii::$app->user->identity->phone))])->label(false) ?>
                    </label>
                    <label class="checkout-form__label" for="checkout-email">
                        <div>Ваш электронный адрес*</div>
                        <?= $form->field($order, 'email')->textInput(['class' => 'checkout-form__input', 'id' => 'checkout-email', 'placeholder' => 'Ваш электронный адрес', 'value' => Yii::$app->user->isGuest ? null : Yii::$app->user->identity->email])->label(false) ?>
                    </label>
                </div>
                <div class="checkout-form__group-row">
                    <label class="checkout-form__label" for="checkout-city">
                        <div>Город*</div>
                        <?= $form->field($order, 'city')->textInput(['class' => 'checkout-form__input', 'id' => 'checkout-city', 'value' => 'Барнаул', 'placeholder' => 'Город'])->label(false); ?>
                    </label>
                    <label class="checkout-form__label" for="checkout-street">
                        <div>Улица*</div>
                        <?= $form->field($order, 'street')->textInput(['class' => 'checkout-form__input', 'id' => 'checkout-street', 'placeholder' => 'Улица'])->label(false); ?>
                    </label>
                </div>
                <div class="checkout-form__group-row">
                    <label class="checkout-form__label" for="checkout-number_home">
                        <div>Номер дома*</div>
                        <?= $form->field($order, 'number_home')->textInput(['class' => 'checkout-form__input', 'id' => 'checkout-number_home', 'placeholder' => 'Номер дома'])->label(false); ?>
                    </label>
                    <label class="checkout-form__label" for="checkout-entrance">
                        <div>Подьезд*</div>
                        <?= $form->field($order, 'entrance')->textInput(['class' => 'checkout-form__input', 'id' => 'checkout-entrance', 'placeholder' => 'Подьезд'])->label(false); ?>
                    </label>
                </div>
                <div class="checkout-form__group-row">
                    <label class="checkout-form__label" for="checkout-floor_house">
                        <div>Этаж*</div>
                        <?= $form->field($order, 'floor_house')->textInput(['class' => 'checkout-form__input', 'id' => 'checkout-floor_house', 'placeholder' => 'Этаж'])->label(false); ?>
                    </label>
                    <label class="checkout-form__label" for="checkout-number_appartament">
                        <div>Квартира*</div>
                        <?= $form->field($order, 'number_appartament')->textInput(['class' => 'checkout-form__input', 'id' => 'checkout-number_appartament', 'placeholder' => 'Номер квартиры'])->label(false); ?>
                    </label>
                </div>
                <label class="checkout-form__label" for="checkout-comment">
                    <div>Ваши пожелания*</div>
                    <?= $form->field($order, 'comment')->textarea(['class' => 'checkout-form__textarea', 'id' => 'checkout-comment', 'placeholder' => 'Комментарий к заказу'])->label(false); ?>
                </label>
            </div>


            <div class="checkout-form-variants">
                <?= $form->field($order, 'payment_id')->radioList(ArrayHelper::map($payments, 'id', 'name'), [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $payment = Payment::findOne($value);

                        return <<<LIST
                        <input class="checkbox-budget" id="budget-31$index" value="$value" type="radio" name="$name">
                        <label class="for-checkbox-budget checkout-form-variants__item" for="budget-31$index">
                            <span class="checkout-form-variants__card">
                            <div class="checkout-form-variants__label">$label</div>
                                <img class="checkout-form-variants__icon" src="/upload/$payment->image">
                            </span>
                        </label>
LIST;
                    }
                ]) ?>
            </div>

            <?= Html::submitButton('Подтвердить заказ', ['class' => 'add-basket checkout-form__submit', 'onclick' => "ym(55089223,'reachGoal','create_order'); return true;"]); ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="page__right">
            <div class="checkout-summary">
                <a class="clear-basket" href="<?= Url::to(['/clear/']); ?>" data-toggle="tooltip" data-placement="top"
                   title="Очистить корзину"><i class="fas fa-trash-alt"></i></a>
                <div class="checkout-summary__info">
                    <div class="checkout-summary__title">Ваш заказ на сумму:</div>
                    <a class="checkout-summary__show-items" data-toggle="collapse" href="#collapseSummary" role="button" aria-expanded="true" aria-controls="collapseSummary">
                        <span class="text-expanded">Скрыть состав заказа</span>
                        <span class="text-collapsed">Показать состав заказа</span>
                    </a>
                </div>
                <div class="checkout-summary__amount">
                    <div class="js-product-calc-full-summary"><?= Price::format(Basket::getInstance()->cash(true)) ?></div>
                    <div class="checkout-summary__currency"><?= Currency::getInstance()->show(); ?></div>
                </div>
            </div>
            <?php if ($basket = Basket::findAll()): ?>
                <div class="collapse show" id="collapseSummary">
                    <ul class="light-checkout-list">
                        <?php foreach ($basket as $item): ?>
                            <li class="light-checkout-list__item">
                                <a class="clear-basket js-remove-basket-item" href="#" data-toggle="tooltip" rel="tooltip" data-product-id="<?= $item->product->id; ?>" data-placement="right" title="Удалить товар из корзины">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <img alt="<?= $item->product->name; ?>" title="<?= $item->product->name; ?>" class="light-checkout-list__image" src="<?= ProductHelper::getImageUrl($item->product) ?>">
                                <div class="light-checkout-list__info">
                                    <div class="light-checkout-list__title">
                                        <a class="light-checkout-list__link" href="<?= $item->product->detail; ?>"><?= $item->product->name; ?></a>
                                    </div>
                                    <div class="light-checkout-list__article">Артикул: <?= $item->product->article; ?></div>
                                </div>
                                <?= AddBasketWidget::widget([
                                    'product_id' => $item->product->id,
                                    'price' => $item->product ? ProductHelper::getResultPrice($item->product) : $item->price,
                                    'discount' => $item->discount_price,
                                    'showButton' => false,
                                    'showInfo' => false,
                                    'showOneClick' => false,
                                    'showPrice' => true
                                ]); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="checkout-reglament">
                <div class="checkout-reglament__title">Обратите внимание!</div>
                <div class="checkout-reglament__text">
                    <p>После оформления заказа, с вами свяжется менеджер для подтверждения заявки и уточнит сроки доставки (Обычно 1 час).</p>
                    <p>Доставка бесплатная при заказе на сумму от 500 рублей. Если ваш адрес дальше Барнаула советуем вам уточнить стоимость доставки у наших операторов.</p>
                    <p>Остались вопросы — <a href="mailto:<?= SiteSettings::findByCode('email')->value; ?>"><?= SiteSettings::findByCode('email')->value; ?></a> или <a href="tel:<?= SiteSettings::findByCode('phone_1')->value; ?>" class="js-phone-mask"><?= SiteSettings::findByCode('phone_1')->value; ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>