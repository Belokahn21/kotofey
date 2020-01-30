<?php

/* @var $this yii\web\View
 * @var $order \app\models\entity\Order
 * @var $billing \app\models\entity\user\Billing
 * @var $user \app\models\entity\User
 * @var $discount_model \app\models\forms\DiscountForm
 * @var $delivery \app\models\entity\Delivery[]
 * @var $payment \app\models\entity\Payment[]
 * @var $order_date \app\models\entity\OrderDate
 * @var $delivery_time \app\models\services\DeliveryTimeService
 * @var $billing_list \app\models\entity\user\Billing[]
 */

use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\models\entity\Basket;
use app\models\tool\Currency;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\Delivery;
use app\models\tool\Policy;

$this->title = Title::showTitle("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/checkout/']];
?>
    <h1>Оформление заказа</h1>
<?php $form = ActiveForm::begin([
	'options' => [
		'id' => 'checkout-form-id'
	]
]); ?>
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
							'order_date' => $order_date,
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
							'order_date' => $order_date,
							'billing_list' => $billing_list,
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
					<?= Html::a('Политика конфиденциальности', Policy::getInstance()->getPath()) ?>
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
                                <div class="basket-page-item__form product-detail-calc-form">
                                    <span class="calc-min" data-product="<?= $item->product->id; ?>"><i class="fas fa-minus"></i></span>
                                    <input class="basket-page-item__form-input calc-count" type="text" name="count" placeholder="1" value="<?= $item->count; ?>">
                                    <span class="calc-plus" data-product="<?= $item->product->id; ?>"><i class="fas fa-plus"></i></span>
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

<?= $this->render('checkout/simple/fast-auth-modal'); ?>