<?php

/* @var $this yii\web\View
 * @var $order \app\modules\order\models\entity\Order
 * @var $billing \app\models\entity\user\Billing
 * @var $user \app\models\entity\User
 * @var $discount_model \app\models\forms\DiscountForm
 * @var $delivery app\modules\delivery\models\entity\Delivery[]
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
use app\modules\delivery\models\entity\Delivery;
use app\models\tool\Policy;
use yii\helpers\ArrayHelper;

$this->title = Title::showTitle("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/order/']];
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
                <div class="checkout-block">
                    <div class="checkout-block__title">
                        Покупатель
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
							<?= $form->field($order, 'email')->textInput(['class' => 'checkout__input', 'placeholder' => 'Email'])->label(false); ?>
                        </div>
                        <div class="col-sm-6">

							<?= $form->field($order, 'phone')->textInput(['class' => 'checkout__input maskedinput-js', 'placeholder' => 'Телефон'])->label(false); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
							<?= $form->field($order, 'comment')->textarea(['class' => 'checkout__textarea', 'placeholder' => 'Комментарий к заказу'])->label(false); ?>
                        </div>
                    </div>
                </div>

                <div class="checkout-block">
                    <div class="checkout-block__title">
                        Адрес и время доставки
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
							<?= $form->field($order, 'city')->textInput(['placeholder' => 'Город'])->label(false); ?>
                        </div>
                        <div class="col-sm-3">
							<?= $form->field($order, 'street')->textInput(['placeholder' => 'Улица'])->label(false); ?>
                        </div>
                        <div class="col-sm-3">
							<?= $form->field($order, 'number_home')->textInput(['placeholder' => 'Номер дома'])->label(false); ?>
                        </div>
                        <div class="col-sm-3">
							<?= $form->field($order, 'number_appartament')->textInput(['placeholder' => 'Кватира'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 select-day">
							<?= $form->field($order_date, 'date')->textInput(['class' => 'js-datepicker checkout__input', 'value' => $delivery_time->getAvailableDate(), 'placeholder' => 'Указать день доставки'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="order-time-wrap">
                                <ul class="order-time">
									<?php foreach ($delivery_time->getTimeList() as $key => $time): ?>
                                        <li data-value="с <?= $key; ?>.00 до <?= $time; ?>.00" class="order-time__item">с <?= $key; ?>.00 до <?= $time; ?>.00</li>
									<?php endforeach; ?>
                                </ul>
                            </div>
							<?= $form->field($order_date, 'time')->hiddenInput(['class' => 'order-time-input'])->label(false); ?>
                        </div>
                    </div>
                </div>


                <div class="checkout-block">
                    <div class="checkout-block__title">
                        Доставка и оплата
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
							<?= $form->field($order, 'delivery_id')->dropDownList(ArrayHelper::map($delivery, 'id', 'name'), ['prompt' => 'Вариант доставки'])->label(false); ?>
                        </div>
                        <div class="col-sm-6">
							<?= $form->field($order, 'payment_id')->dropDownList(ArrayHelper::map($payment, 'id', 'name'), ['prompt' => 'Вариант оплаты'])->label(false); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="checkout__summary">
            <div class="checkout__title">Сумма заказа:</div>
            <div class="checkout__control-wrap">
                <div class="checkout__price"><span><?= Price::format(Basket::getInstance()->cash()); ?></span> <?= Currency::getInstance()->show(); ?></div>
				<?= Html::submitButton('Оформить', ['class' => 'checkout__submit']) ?>
            </div>
			<?= Html::a('Политика конфиденциальности', Policy::getInstance()->getPath(), ['class' => 'link-main']) ?>
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

<script type="text/javascript">
	var cartSumm = parseInt('<?= str_replace(' ', '', Price::format(Basket::getInstance()->cash())) ?>');

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
	}
</script>

<?php

$JS = <<<JS
$('#checkout-form-id').on('afterValidateAttribute', function (event, attribute, messages) {
    if(messages.length==0 && attribute.name=='promo_code' && attribute.value.length > 0){
        $('.how-promocode').html('Ваш промокод: <strong>'+attribute.value+'</strong>. Скидка -20%');
        var result = cartSumm - Math.ceil(cartSumm*0.2);
        result = numberWithCommas(result);
        $('.checkout__price span').html('<s style="font-size:16px">'+numberWithCommas(cartSumm)+'</s>'+' <span>'+result+'</span>');
    }else{
        $('.how-promocode').html('');
        $('.checkout__price span').html(numberWithCommas(cartSumm));
    }
});
JS;


Yii::$app->view->registerJs($JS, \yii\web\View::POS_END);
?>
