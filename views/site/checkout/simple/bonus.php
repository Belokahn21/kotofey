<?php

use app\models\entity\Discount;
use app\models\helpers\DiscountHelper;
use app\models\entity\Basket;

/* @var $DiscountModel \app\models\forms\DiscountForm */
?>
<div class="checkout-block">
    <div class="checkout-block__title">
        Бонусы
    </div>
    <div class="row">
        <div class="col-sm-12">
			<?php if (Yii::$app->user->isGuest): ?>
				<?= $this->render('fast-auth-modal'); ?>
                Чтобы воспользоваться бонусами выполните <a href="javascript:void(0);" data-target="#fast-auth-id" data-toggle="modal">авторизацию</a> на сайте
			<?php else: ?>
				<?= $form->field($DiscountModel, 'discount')->textInput(['placeholder' => sprintf("С этой покупки вы получите %s бонусов", DiscountHelper::calcBonus(Basket::getInstance()->cash())), 'class' => 'checkout__input'])->label(false); ?>
                <a href="javascript:void(0);" class="count__bouns">У вас <?= Discount::findByUserId(Yii::$app->user->id)->count; ?> бонусов</a>
			<?php endif; ?>
        </div>
    </div>
</div>