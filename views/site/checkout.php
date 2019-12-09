<?php

/* @var $this yii\web\View
 * @var $order \app\models\entity\Order
 * @var $billing \app\models\entity\user\Billing
 * @var $user \app\models\entity\User
 * @var $discount_model \app\models\forms\DiscountForm
 * @var $delivery \app\models\entity\Delivery[]
 * @var $payment \app\models\entity\Payment[]
 */

use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\models\entity\Basket;
use app\models\tool\Currency;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Title::showTitle("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/checkout/']];
?>
<h1>Оформление заказа</h1>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-sm-6">
        <ul class="select-type-order">
            <li class="type-order__item active" data-checkout="fast">Быстрый заказ
                <i class="far fa-question-circle" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></i>
            </li>
            <li class="type-order__item" data-checkout="simple">Обычный заказ
                <i class="far fa-question-circle" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></i>
            </li>
        </ul>

        <div class="checkout-order-wrap">
            <div class="checkout-order hide" data-type="fast">
				<?php if (Yii::$app->user->isGuest): ?>
					<?= $this->render('checkout/fast/guest/form'); ?>
				<?php else: ?>
					<?= $this->render('checkout/fast/user/form'); ?>
				<?php endif; ?>
            </div>
            <div class="checkout-order hide" data-type="simple">
				<?php if (Yii::$app->user->isGuest): ?>
					<?= $this->render('checkout/simple/guest/form', [
						'form' => $form,
						'discount_model' => $discount_model,
						'user' => $user,
						'billing' => $billing,
						'order' => $order,
						'delivery' => $delivery,
						'payment' => $payment,
					]); ?>
				<?php else: ?>
					<?= $this->render('checkout/simple/user/form', [
						'form' => $form,
						'discount_model' => $discount_model,
						'billing' => $billing,
						'order' => $order,
						'delivery' => $delivery,
						'payment' => $payment,
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
        </div>
        <div class="checkout__title">Корзина:</div>
		<?php if ($basket = Basket::findAll()): ?>
            <ul class="checkout__cart">
				<?php foreach (Basket::findAll() as $item): ?>
                    <li class="checkout__cart-item">
                        <div class="checkout__cart-item__title">
                            <a href="" class="checkout__cart-item__link"><?= $item->getName(); ?></a>
                        </div>
                        <div class="checkout__cart-item__count">
                            <div class="checkout__cart-item__action-plus">
                                <i class="fas fa-minus"></i>
                            </div>


                            <div class="checkout__cart-item__integer">
								<?= $item->getCount(); ?>
                            </div>


                            <div class="checkout__cart-item__action-minus">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <div class="checkout__cart-item__summary"><?= Price::format($item->getPrice()); ?> <?= Currency::getInstance()->show(); ?></div>
                    </li>
				<?php endforeach; ?>
            </ul>
		<?php endif; ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
