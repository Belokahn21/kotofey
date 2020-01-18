<?php

use yii\helpers\ArrayHelper;
use app\models\entity\User;
use app\models\entity\OrderStatus;
use app\models\entity\Payment;
use app\models\entity\Delivery;
use yii\helpers\Url;
use app\models\entity\Product;

/* @var $model \app\models\entity\Order */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-client-tab" data-toggle="tab" href="#nav-client" role="tab" aria-controls="nav-client" aria-selected="false">Покупатель</a>
		<?php if ($items): ?>
            <a class="nav-item nav-link" id="nav-items-tab" data-toggle="tab" href="#nav-items" role="tab" aria-controls="nav-items" aria-selected="false">Товары в заказе</a>
		<?php endif; ?>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
		<?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(OrderStatus::find()->all(), 'id', 'name'), ['prompt' => 'Статус заказа']); ?>
		<?= $form->field($model, 'payment_id')->dropDownList(ArrayHelper::map(Payment::find()->all(), 'id', 'name'), ['prompt' => 'Способ оплаты']); ?>
		<?= $form->field($model, 'delivery_id')->dropDownList(ArrayHelper::map(Delivery::find()->all(), 'id', 'name'), ['prompt' => 'Способ доставки']); ?>
		<?= $form->field($model, 'is_paid')->radioList(array("Не оплачено", "Оплачено")); ?>
        <div class="row">
            <div class="col-sm-6">
				<?= $form->field($model, 'notes')->textarea(); ?>
            </div>
            <div class="col-sm-6">
				<?= $form->field($model, 'comment')->textarea(); ?>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-client" role="tabpanel" aria-labelledby="nav-client-tab">
		<?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'email'), ['prompt' => 'Покупатель']); ?>
    </div>
	<?php if ($items): ?>
        <div class="tab-pane fade" id="nav-items" role="tabpanel" aria-labelledby="nav-items-tab">
            <ul class="order-items">
				<?php foreach ($items as $item): ?>
                    <li class="order-items__item">
						<?php if ($item->product instanceof Product): ?>
                            <a class="order-items__link" href="">
								<?php if ($item->product instanceof Product): ?>
                                    <img class="order-items__image" src="/web/upload/<?= $item->product->image; ?>">
								<?php else: ?>
                                    <img class="order-items__image" src="/web/upload/images/not-image.png">
								<?php endif; ?>
                            </a>
                            <ul class="product-attrs">
                                <li class="product-attrs__item">
                                    <div class="product-attrs__item-key">Артикул</div>
                                    <div class="product-attrs__item-value"><?= $item->product->article; ?></div>
                                </li>
                                <li class="product-attrs__item">
                                    <div class="product-attrs__item-key">Внешний код</div>
                                    <div class="product-attrs__item-value"><?= $item->product->code ? $item->product->code : 'Не указан'; ?></div>
                                </li>
                                <li class="product-attrs__item">
                                    <div class="product-attrs__item-key">Закупочная цена</div>
                                    <div class="product-attrs__item-value"><?= $item->product->purchase; ?></div>
                                </li>
                                <li class="product-attrs__item">
                                    <div class="product-attrs__item-key">Цена к продаже</div>
                                    <div class="product-attrs__item-value"><?= $item->price; ?></div>
                                </li>
                                <li class="product-attrs__item">
                                    <div class="product-attrs__item-key">Количество</div>
                                    <div class="product-attrs__item-value"><?= $item->count; ?></div>
                                </li>
                            </ul>
						<?php endif; ?>

                        <div class="order-items__title">
							<?php if ($item->product instanceof Product): ?>
                                <a href="<?= Url::to(['admin/catalog', 'id' => $item->product->id]) ?>"><?= ($item->product instanceof \app\models\entity\Product) ? $item->product->name : $item->name; ?></a>
							<?php else: ?>
                                <a href="javascript:void(0);"><?= $item->name; ?></a>
							<?php endif; ?>
                        </div>
                    </li>
				<?php endforeach; ?>
            </ul>
        </div>
	<?php endif; ?>
</div>