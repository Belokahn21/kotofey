<?php
/* @var $DiscountModel \app\models\forms\DiscountForm */
?>
<div class="checkout-block">
    <div class="checkout-block__title">
        Бонусы
    </div>
    <div class="row">
        <div class="col-sm-12">
			<?= $form->field($DiscountModel, 'discount')->textInput(['placeholder' => 'Доступно 340 бонусов', 'class' => 'checkout__input'])->label(false); ?>
        </div>
    </div>
</div>