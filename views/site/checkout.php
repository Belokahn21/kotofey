<?php

/* @var $this yii\web\View
 * @var $order \app\models\entity\Order
 * @var $billing \app\models\entity\user\Billing
 * @var $user \app\models\entity\User
 * @var $discount_model \app\models\forms\DiscountForm
 * @var $delivery \app\models\entity\Delivery[]
 * @var $payment \app\models\entity\Payment[]
 * @var $delivery_time \app\models\services\DeliveryTimeService
 */

use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\models\entity\Basket;
use app\models\tool\Currency;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\Delivery;

$this->title = Title::showTitle("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/checkout/']];
?>
<h1>Оформление заказа</h1>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="checkout-order-wrap">
            <div class="checkout-order">
				<?php if (Yii::$app->user->isGuest): ?>
					<?= $this->render('checkout/simple/guest/form', [
						'form' => $form,
						'discount_model' => $discount_model,
						'user' => $user,
						'billing' => $billing,
						'order' => $order,
						'delivery' => $delivery,
						'payment' => $payment,
                        'delivery_time' => $delivery_time,
					]); ?>
				<?php else: ?>
					<?= $this->render('checkout/simple/user/form', [
						'form' => $form,
						'discount_model' => $discount_model,
						'billing' => $billing,
						'order' => $order,
						'delivery' => $delivery,
						'payment' => $payment,
						'delivery_time' => $delivery_time,
					]); ?>
				<?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="checkout__summary">
            <div class="checkout__title">Сумма заказа:</div>
            <div class="checkout__control-wrap">
                <div class="checkout__price"><?= Price::format(Basket::getInstance()->cash()); ?> <?= Currency::getInstance()->show(); ?></div>
				<?= Html::submitButton('Оформить', ['class' => 'checkout__submit']) ?>
            </div>
			<?php if (Basket::getInstance()->cash() < Delivery::LIMIT_ORDER_SUMM_TO_ACTIVATE): ?>
                <div class="delivery-alert"><span class="font-weight-bold">Внимание: </span>У вас доставка <?= Delivery::PRICE_DELIVERY; ?><?= Currency::getInstance()->show(); ?>. Сумма заказа меньше <?= Delivery::LIMIT_ORDER_SUMM_TO_ACTIVATE; ?><?= Currency::getInstance()->show(); ?></div>
			<?php endif; ?>
        </div>
        <div class="checkout__title">Корзина:</div>
		<?php if ($basket = Basket::findAll()): ?>
            <ul class="checkout__cart">
				<?php foreach ($basket as $item): ?>
                    <li class="checkout__cart-item">
                        <div class="checkout__cart-item__title">
                            <a href="" class="checkout__cart-item__link"><?= $item->name; ?></a>
                        </div>
                        <div class="checkout__cart-item__count">
                            <div class="checkout__cart-item__action-plus">
                                <i class="fas fa-minus"></i>
                            </div>


                            <div class="checkout__cart-item__integer">
								<?= $item->count; ?>
                            </div>


                            <div class="checkout__cart-item__action-minus">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="checkout__cart-item__summary"><?= Price::format($item->price); ?> <?= Currency::getInstance()->show(); ?></div>
                    </li>
				<?php endforeach; ?>
            </ul>
		<?php endif; ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
