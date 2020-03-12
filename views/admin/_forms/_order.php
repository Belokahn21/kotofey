<?php

use yii\helpers\ArrayHelper;
use app\models\entity\User;
use app\models\entity\OrderStatus;
use app\models\entity\Payment;
use app\models\entity\Delivery;
use yii\helpers\Url;
use app\models\entity\Product;

/* @var $model \app\models\entity\Order */
/* @var $items \app\models\entity\OrdersItems[] */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-client-tab" data-toggle="tab" href="#nav-client" role="tab" aria-controls="nav-client" aria-selected="false">Покупатель</a>
		<?php if ($items): ?>
            <a class="nav-item nav-link" id="nav-items-tab" data-toggle="tab" href="#nav-items" role="tab" aria-controls="nav-items" aria-selected="false">Товары в заказе</a>
		<?php endif; ?>
        <a class="nav-item nav-link" id="nav-items-edit-tab" data-toggle="tab" href="#nav-items-edit" role="tab" aria-controls="nav-items-edit" aria-selected="false">Товары в заказе(ред.)</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
		<?= $form->field($model, 'is_cancel')->checkbox(); ?>
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
		<?php if ($model->billing): ?>
            <h6 style="margin: 10px 0; border-bottom: 1px #e3e3e3 solid; padding: 5px 0;" class="w-25">Адрес доставки</h6>
            <div class="row w-25">
				<?php foreach (['city', 'street', 'home', 'house'] as $attr): ?>
                    <div class="col-sm-6"><?= $model->billing->getAttributeLabel($attr); ?></div>
                    <div class="col-sm-6"><?= $model->billing->{$attr}; ?></div>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>

		<?php if ($model->dateDelivery): ?>
            <hr/>
            <div class="row w-25">
                <div class="col-sm-6">Дата доставки</div>
                <div class="col-sm-6"><?= $model->dateDelivery->date; ?></div>
            </div>
            <div class="row">
                <div class="col-sm-6">Время доставки</div>
                <div class="col-sm-6"><?= $model->dateDelivery->time; ?></div>
            </div>
		<?php endif; ?>
    </div>
	<?php if ($items): ?>
        <div class="tab-pane fade" id="nav-items" role="tabpanel" aria-labelledby="nav-items-tab">
            <ul class="order-items">
				<?php foreach ($items as $item): ?>
                    <li class="order-items__item">
						<?php if ($item->product instanceof Product): ?>
                            <a class="order-items__link" href="">
								<?php if ($item->product instanceof Product): ?>
                                    <img class="order-items__image" src="/upload/<?= $item->product->image; ?>">
								<?php else: ?>
                                    <img class="order-items__image" src="/upload/images/not-image.png">
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

    <div class="tab-pane fade" id="nav-items-edit" role="tabpanel" aria-labelledby="nav-items-edit-tab">
		<?php if ($items): ?>
			<?php $k = 10; ?>
			<?php foreach ($items as $i => $item): ?>
                <div class="row orders-items-item">
                    <div class="col-sm-3">
						<?= $form->field($item, '[' . $i . ']name')->textInput(['class' => 'load-product-info__name form-control']); ?>
                    </div>
                    <div class="col-sm-3">
						<?= $form->field($item, '[' . $i . ']count')->textInput(['class' => 'load-product-info__count form-control']); ?>
                    </div>
                    <div class="col-sm-3">
						<?= $form->field($item, '[' . $i . ']price')->textInput(['class' => 'load-product-info__price form-control']); ?>
                    </div>
                    <div class="col-sm-2">
						<?= $form->field($item, '[' . $i . ']product_id')->textInput(['class' => 'load-product-info form-control']); ?>
                    </div>
                    <div class="col-sm-1">
						<?= $form->field($item, '[' . $i . ']need_delete')->checkbox(); ?>
                    </div>
                </div>
				<?php $k = $i; ?>

			<?php endforeach; ?>
			<?php for ($j = $k+1; $j < $k + 3; $j++): ?>
                <div class="row orders-items-item">
                    <div class="col-sm-3">
						<?= $form->field($itemModel, '[' . $j . ']name')->textInput(['class' => 'load-product-info__name form-control']); ?>
                    </div>
                    <div class="col-sm-3">
						<?= $form->field($itemModel, '[' . $j . ']count')->textInput(['class' => 'load-product-info__count form-control']); ?>
                    </div>
                    <div class="col-sm-3">
						<?= $form->field($itemModel, '[' . $j . ']price')->textInput(['class' => 'load-product-info__price form-control']); ?>
                    </div>
                    <div class="col-sm-2">
						<?= $form->field($itemModel, '[' . $j . ']product_id')->textInput(['class' => 'load-product-info form-control']); ?>
                    </div>
                </div>
			<?php endfor; ?>
		<?php else: ?>
			<?php for ($i = 0; $i < 4; $i++): ?>
                <div class="row orders-items-item">
                    <div class="col-sm-3">
						<?= $form->field($itemModel, '[' . $i . ']name')->textInput(['class' => 'load-product-info__name form-control']); ?>
                    </div>
                    <div class="col-sm-3">
						<?= $form->field($itemModel, '[' . $i . ']count')->textInput(['class' => 'load-product-info__count form-control']); ?>
                    </div>
                    <div class="col-sm-3">
						<?= $form->field($itemModel, '[' . $i . ']price')->textInput(['class' => 'load-product-info__price form-control']); ?>
                    </div>
                    <div class="col-sm-2">
						<?= $form->field($itemModel, '[' . $i . ']product_id')->textInput(['class' => 'load-product-info form-control']); ?>
                    </div>
                </div>
			<?php endfor; ?>
		<?php endif; ?>
    </div>

</div>
