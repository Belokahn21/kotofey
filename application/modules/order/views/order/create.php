<?php

/* @var $this yii\web\View
 * @var $order \app\modules\order\models\entity\Order
 * @var $billing \app\modules\user\models\entity\Billing
 * @var $user \app\modules\user\models\entity\User
 * @var $delivery app\modules\delivery\models\entity\Delivery[]
 * @var $payment \app\modules\payment\models\entity\Payment[]
 * @var $order_date \app\modules\order\models\entity\OrderDate
 * @var $delivery_time \app\modules\order\models\service\DeliveryTimeService
 * @var $billing_list \app\modules\user\models\entity\Billing[]
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\tool\Price;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\tool\Currency;
use app\models\tool\seo\Title;
use app\modules\basket\models\entity\Basket;
use app\modules\payment\models\entity\Payment;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site_settings\models\entity\SiteSettings;
use app\modules\basket\widgets\addBasket\AddBasketWidget;

$this->title = Title::showTitle("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/order/']];
?>
<div class="page">
    <ul class="breadcrumbs">
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="javascript:void(0);">Главная</a></li>
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="javascript:void(0);">Корзина</a></li>
        <li class="breadcrumbs__item active"><a class="breadcrumbs__link" href="javascript:void(0);">Оформление заказа</a></li>
    </ul>
    <h1 class="page__title">Оформление заказа</h1>
    <div class="page__group-row">
        <div class="page__left">
			<?php $form = ActiveForm::begin([
				'options' => [
					'class' => 'checkout-form'
				]
			]); ?>
            <div class="checkout-form__title">Укажите способ доставки</div>
            <div class="checkout-form-variants">
                <input class="checkbox-budget" id="budget-1" type="radio" name="delivery_id" checked="">
                <label class="for-checkbox-budget checkout-form-variants__item" for="budget-1">
                    <span class="checkout-form-variants__card">
                    <div class="checkout-form-variants__label">Доставка</div>
                        <img class="checkout-form-variants__icon" src="/upload/images/truck.png">
                    </span>
                </label>
                <input class="checkbox-budget" id="budget-2" type="radio" name="delivery_id">
                <label class="for-checkbox-budget checkout-form-variants__item" for="budget-2">
                    <span class="checkout-form-variants__card">
                    <div class="checkout-form-variants__label">Самовывоз</div>
                        <img class="checkout-form-variants__icon" src="/upload/images/box.png"></span>
                </label>
            </div>
            <div class="checkout-form__title">Укажите ваши данные
                <div class="checkout-form__group-row">
                    <label class="checkout-form__label" for="checkout-phone">
                        <div>Ваш номер телефона*</div>
						<?= $form->field($order, 'phone')->textInput(['class' => 'js-mask-ru checkout-form__input', 'id' => 'checkout-phone', 'placeholder' => 'Ваш номер телефона'])->label(false) ?>
                    </label>
                    <label class="checkout-form__label" for="checkout-email">
                        <div>Ваш электронный адрес*</div>
						<?= $form->field($order, 'email')->textInput(['class' => 'checkout-form__input', 'id' => 'checkout-phone', 'placeholder' => 'Ваш электронный адрес'])->label(false) ?>
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
                        <div>Дом*</div>
						<?= $form->field($order, 'number_home')->textInput(['class' => 'checkout-form__input', 'id' => 'checkout-number_home', 'placeholder' => 'Номер дома'])->label(false); ?>
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
			<?php if ($payment): ?>
                <div class="checkout-form__title">Укажите способ оплаты</div>

                <div class="checkout-form-variants">
					<?= $form->field($order, 'payment_id')->radioList(ArrayHelper::map($payment, 'id', 'name'), [
						'item' => function ($index, $label, $name, $checked, $value) {
							$element = Payment::findOne($value);

							$html = <<<RADIO
                            <input class="checkbox-budget" id="budget-$index" type="radio" name="$name">
                            <label class="for-checkbox-budget checkout-form-variants__item" for="budget-$index">
                            <span class="checkout-form-variants__card">
                            <div class="checkout-form-variants__label">$label</div>
                                <img class="checkout-form-variants__icon" src="/upload/$element->image">
                            </span>
                            </label>
RADIO;
							return $html;
						}
					]) ?>


                </div>
			<?php endif; ?>
			<?= Html::submitButton('Подтвердить заказ', ['class' => 'add-basket checkout-form__submit']); ?>
			<?php ActiveForm::end(); ?>
        </div>
        <div class="page__right">
            <div class="checkout-summary">
                <a class="clear-basket" href="<?= Url::to(['/clear/']); ?>" data-toggle="tooltip" data-placement="top" title="Очистить корзину"><i class="fas fa-trash-alt"></i></a>
                <div class="checkout-summary__info">
                    <div class="checkout-summary__title">Ваш заказ на сумму:</div>
                    <a class="checkout-summary__show-items" data-toggle="collapse" href="#collapseSummary" role="button" aria-expanded="false" aria-controls="collapseSummary">Посмотреть состав заказа</a>
                </div>
                <div class="checkout-summary__amount">
                    <div class="js-product-calc-full-summary"><?= Price::format(Basket::getInstance()->cash()) ?></div>
                    <div class="checkout-summary__currency"><?= Currency::getInstance()->show(); ?></div>
                </div>
            </div>
			<?php if ($basket = Basket::findAll()): ?>
                <div class="collapse" id="collapseSummary">
                    <ul class="light-checkout-list">
						<?php foreach ($basket as $item): ?>
                            <li class="light-checkout-list__item">
                                <img alt="<?= $item->product->name; ?>" title="<?= $item->product->name; ?>" class="light-checkout-list__image" src="<?= ProductHelper::getImageUrl($item->product) ?>">
                                <div class="light-checkout-list__info">
                                    <div class="light-checkout-list__title"><a class="light-checkout-list__link" href="<?= $item->product->detail; ?>"><?= $item->product->name; ?></a></div>
                                    <div class="light-checkout-list__article">Артикул: <?= $item->product->article; ?></div>
                                </div>
								<?= AddBasketWidget::widget([
									'product_id' => $item->product->id,
									'price' => $item->product->price,
									'showButton' => false,
									'showInfo' => false,
									'showOneClick' => false,
								]); ?>
                            </li>
						<?php endforeach; ?>
                    </ul>
                </div>
			<?php endif; ?>
            <div class="checkout-reglament">
                <div class="checkout-reglament__title">Обратите внимание!</div>
                <div class="checkout-reglament__text">
                    <p>После оформления заказа, с вами свяжется менеджер для подтверждения заявки и уточнит сроки доставки (Обычно 1 час). </p>
                    <!--                    <p>Доставка платная. Рассчитайте стоимость в нашем онлайн-калькуляторе. Введите расстояние (в км) от нас — г. Барнаул, ул. Взлетная 1 до того места, куда требуется доставить товар.</p>-->
                    <p>Доставка бесплатная. Если ваш адрес дальше Барнаула советуем вас воспользоваться калькулятором доставки.</p>
                    <p>Остались вопросы — <a href="mailto:<?= SiteSettings::findByCode('email')->value; ?>"><?= SiteSettings::findByCode('email')->value; ?></a> или <a href="tel:<?= SiteSettings::findByCode('phone_1')->value; ?>" class="js-phone-mask"><?= SiteSettings::findByCode('phone_1')->value; ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>