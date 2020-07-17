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

use app\models\tool\Price;
use app\models\tool\Currency;
use app\models\tool\seo\Title;
use app\modules\basket\models\entity\Basket;
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
            <form class="checkout-form">
                <div class="checkout-form__title">Укажите способ доставки</div>
                <div class="checkout-form-variants">
                    <input class="checkbox-budget" id="budget-1" type="radio" name="delivery_id" checked="">
                    <label class="for-checkbox-budget checkout-form-variants__item" for="budget-1"><span class="checkout-form-variants__card">
                    <div class="checkout-form-variants__label">Доставка</div><img class="checkout-form-variants__icon" src="/upload/images/truck.png"></span></label>
                    <input class="checkbox-budget" id="budget-2" type="radio" name="delivery_id">
                    <label class="for-checkbox-budget checkout-form-variants__item" for="budget-2"><span class="checkout-form-variants__card">
                    <div class="checkout-form-variants__label">Самовывоз</div><img class="checkout-form-variants__icon" src="/upload/images/box.png"></span></label>
                </div>
                <div class="checkout-form__title">Укажите ваши данные
                    <div class="checkout-form__group-row">
                        <label class="checkout-form__label" for="checkout-family">
                            <div>Как вас зовут?*</div>
                            <input class="checkout-form__input" id="checkout-family" name="family" type="text" placeholder="Ваша фамилия">
                        </label>
                        <label class="checkout-form__label" for="checkout-name">
                            <input class="checkout-form__input" id="checkout-name" name="name" type="text" placeholder="Ваше имя">
                        </label>
                    </div>
                    <div class="checkout-form__group-row">
                        <label class="checkout-form__label" for="checkout-phone">
                            <div>Контактный телефон*</div>
                            <input class="checkout-form__input js-mask-ru" id="checkout-phone" name="phone" type="text" placeholder="+7 (___) ___ __-__">
                        </label>
                        <label class="checkout-form__label" for="checkout-email">
                            <div>Электронная почта*</div>
                            <input class="checkout-form__input" id="checkout-email" name="email" type="text" placeholder="Адрес вашей электронной почты">
                        </label>
                    </div>
                </div>
                <div class="checkout-form__title">Укажите способ оплаты</div>
                <div class="checkout-form-variants">
                    <input class="checkbox-budget" id="budget-3" type="radio" name="payment_id">
                    <label class="for-checkbox-budget checkout-form-variants__item" for="budget-3"><span class="checkout-form-variants__card">
                    <div class="checkout-form-variants__label">По терминалу</div><img class="checkout-form-variants__icon" src="/upload/images/debit.png"></span></label>
                    <input class="checkbox-budget" id="budget-4" type="radio" name="payment_id">
                    <label class="for-checkbox-budget checkout-form-variants__item" for="budget-4"><span class="checkout-form-variants__card">
                    <div class="checkout-form-variants__label">Наличные</div><img class="checkout-form-variants__icon" src="/upload/images/wallet.png"></span></label>
                </div>
                <button class="add-basket checkout-form__submit" type="button">Подтвердить заказ</button>
            </form>
        </div>
        <div class="page__right">
            <div class="checkout-summary">
                <div class="checkout-summary__info">
                    <div class="checkout-summary__title">Ваш заказ на сумму:</div>
                    <a class="checkout-summary__show-items" data-toggle="collapse" href="#collapseSummary" role="button" aria-expanded="false" aria-controls="collapseSummary">Посмотреть состав заказа</a>
                </div>
                <div class="checkout-summary__amount"><?= Price::format(Basket::getInstance()->cash()) ?> <?= Currency::getInstance()->show(); ?></div>
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