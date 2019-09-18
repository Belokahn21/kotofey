<?
/* @var $this yii\web\View */
/* @var $order \app\models\entity\Order */
/* @var $user \app\models\entity\User */

/* @var $billing \app\models\entity\user\Billing */

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\entity\Basket;

$this->title = Title::showTitle("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/checkout/']];
?>
<section class="checkout">
    <div class="checkout-form-wrap">
        <div class="type-order">
            <ul class="type-order-list">
                <li class="type-order-list__item">
                    <div class="type-order-list__item-title">Быстрый заказ</div>
                    <div class="type-order-list__item-reason">
                        <ul class="list-advantages">
                            <li class="advantage-item advantage-false">Нет бонусов</li>
                        </ul>
                    </div>
                </li>
                <li class="type-order-list__item">
                    <div class="type-order-list__item-title">Обычный заказ</div>
                    <div class="type-order-list__item-reason">
                        <ul class="list-advantages">
                            <li class="advantage-item advantage-true">Вам начислят бонусы</li>
                            <li class="advantage-item advantage-true">Можно использовать промокод</li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        <div class="checkout-form fast">
            <div class="left-col">
                <h2>Быстрый заказ</h2>
                <?php $form = ActiveForm::begin(); ?>
                <?php echo $form->field($user, 'email'); ?>
                <?php echo $form->field($user, 'phone'); ?>
                <?php echo $form->field($user, 'new_password'); ?>
                <?php echo Html::submitButton('Сделать заказ', ['class' => 'btn-main']); ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="right-col">
                <div class="out-smm">Заказ на сумму: <span><?php echo Price::format((new Basket())->cash()); ?></span><?php echo (new Currency())->show();?></div>
                <ul class="cart-checkout-fast">
                    <?php foreach ((new Basket())->listItems() as $item): ?>
                        <li class="cart-checkout-fast__item">
                            <div class="cart-checkout-fast__item-image-wrap">
                                <img class="cart-checkout-fast__item-image" src="<?php echo $item->product->image; ?>">
                            </div>
                            <div class="cart-checkout-fast__item-title"><?php echo $item->product->name; ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="checkout-form normal">
            2
        </div>
    </div>
</section>