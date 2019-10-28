<?
/* @var $this yii\web\View */
/* @var $order \app\models\entity\Order */

/* @var $billing \app\models\entity\user\Billing */

use app\models\tool\seo\Title;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\entity\Basket;
use app\models\tool\Policy;
use app\widgets\promoCart\promoCartWidget;

$this->title = Title::showTitle("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/checkout/']];
?>
<section class="checkout">
    <div class="checkout-form-wrap">
        <?= $this->render('_type-order'); ?>
        <div class="checkout-form fast">
            <div class="left-col">
                <h2>Быстрый заказ</h2>
                <?php $form = ActiveForm::begin(); ?>
                <?php echo $form->field($user, 'phone'); ?>
                <?php echo Html::submitButton('Сделать заказ', ['class' => 'btn-main']); ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="right-col">
                <div class="out-smm">Заказ на сумму: <span><?php echo Price::format(Basket::getInstance()->cash()); ?></span><?php echo (new Currency())->show();?></div>
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
            <div class="left-col">
                <h2 class="checkout__title">Промокод</h2>
                <?= \app\widgets\promoCart\promoCartWidget::widget(); ?>
                <? $form = ActiveForm::begin(); ?>
                <div class="elem-form">
                    <h2 class="checkout__title">Заказ</h2>
                    <div>
                        <div class="left-col" style="padding: 0 1% 0 0;">
                            <?= $form->field($order, 'delivery')->dropDownList(\yii\helpers\ArrayHelper::map($delivery, 'id', 'name'),
                                ['prompt' => "Способ доставки"]); ?>
                        </div>
                        <div class="right-col" style="padding: 0;">
                            <?= $form->field($order, 'payment')->dropDownList(\yii\helpers\ArrayHelper::map($payment, 'id', 'name'),
                                ['prompt' => "Способ оплаты"]); ?>
                        </div>
                    </div>
                    <?= $form->field($order, 'comment')->textarea(); ?>
                    <div class="clearfix"></div>
                </div>
                <div class="elem-form">
                    <h2 class="checkout__title">Адрес доставки</h2>
                    <div>
                        <div class="left-col" style="padding: 0 1% 0 0;">
                            <?= $form->field($billing, 'city')->textInput(); ?>
                        </div>
                        <div class="right-col" style="padding: 0;">
                            <?= $form->field($billing, 'street')->textInput(); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-6">
                            <?= $form->field($billing, 'home')->textInput(); ?>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <?= $form->field($billing, 'house')->textInput(); ?>
                        </div>
                        <div class="col-md-8 col-sm-6">
                            <?= $form->field($user, 'phone'); ?>
                        </div>
                    </div>
                </div>
                <?= Html::submitButton('Заказать', ['class' => 'btn-main', 'value' => 'nopaid', 'name' => 'type']) ?>
                <?= Html::a("Персональные данные", \app\models\tool\Policy::getInstance()->getPath(), ['class' => 'policy-link-checkout']); ?>
                <? ActiveForm::end(); ?>
            </div>
            <div class="right-col">
                <div class="out-smm">Заказ на сумму: <span><?php echo Price::format(Basket::getInstance()->cash()); ?></span><?php echo Currency::getInstance()->show();?></div>
                <ul class="cart-checkout-fast">
                    <?php foreach (Basket::getInstance()->listItems() as $item): ?>
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
    </div>
</section>