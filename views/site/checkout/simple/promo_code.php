<div class="checkout-block">
    <div class="checkout-block__title">
        Промокод
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($order, 'promo_code', ['enableAjaxValidation' => true])->textInput(['placeholder' => 'Промокод'])->label(false); ?>
            <div class="how-promocode green"></div>
        </div>
    </div>
</div>
