<?php

use yii\helpers\ArrayHelper;

/* @var $users \app\models\entity\User[]
 * @var $model \app\modules\order\models\entity\Order
 * @var $deliveries \app\models\entity\Delivery[]
 * @var $payments \app\models\entity\Payment[]
 * @var $status \app\modules\order\models\entity\OrderStatus[]
 * @var $itemsModel \app\modules\order\models\entity\OrdersItems
 */
?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
		<?php if (!$model->isNewRecord): ?>
            <a class="nav-item nav-link" id="nav-detail-info-edit-tab" data-toggle="tab" href="#nav-detail-info-edit" role="tab" aria-controls="nav-detail-info-edit" aria-selected="false">Общая инофрмация</a>
		<?php endif; ?>
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-items-edit-tab" data-toggle="tab" href="#nav-items-edit" role="tab" aria-controls="nav-items-edit" aria-selected="false">Товары в заказе</a>
    </div>
</nav>


<div class="tab-content" id="nav-tab-content-form">
	<?php if (!$model->isNewRecord): ?>
    <div class="tab-pane fade" id="nav-detail-info-edit" role="tabpanel" aria-labelledby="nav-detail-info-edit-tab">
        <div class="d-flex flex-row">
            <div class="w-50">
                <h4>Время и дата доставки</h4>
				<?php try { ?>
                    <p><?= $model->dateDelivery->date; ?> - <?= $model->dateDelivery->time; ?></p>
				<?php } catch (ErrorException $exception) { ?>
                <p>Отстуствуют</p>
                } ?>

                <h4>Адрес доставки</h4>
                <ul>
                    <li><?= $model->user->billing->city; ?></li>
                    <li><?= $model->user->billing->street; ?></li>
                    <li><?= $model->user->billing->home; ?></li>
                    <li><?= $model->user->billing->house; ?></li>
                </ul>
            </div>

            <div class="w-50">
                <ul>
					<?php foreach ($itemsModel as $item): ?>
                        <li class="d-flex flex-row justify-content-between align-items-center">
                            <img class="w-25 m-5" src="/upload/<?= $item->product->image; ?>">

                            <div class="w-75">
                                <p><?= $item->name; ?></p>
                                <p>Внешний код: <?= $item->product->code; ?></p>
                                <p>Зкупочная: <?= $item->product->purchase; ?></p>
                                <p>К продаже: <?= $item->price; ?></p>
                                <p>Кол-во: <?= $item->count; ?></p>
                            </div>
                        </li>
					<?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="d-flex flex-row">
            <div class="w-25 p-1"><?= $form->field($model, 'is_paid')->checkbox(); ?></div>
            <div class="w-25 p-1"><?= $form->field($model, 'is_cancel')->checkbox(); ?></div>
            <div class="w-25 p-1"><?= $form->field($model, 'is_close')->checkbox(); ?></div>
        </div>
        <div class="form-element">
            <div class="d-flex flex-row">
                <div class="w-25 p-1">
					<?= $form->field($model, 'delivery_id')->dropDownList(ArrayHelper::map($deliveries, 'id', 'nameF'), [
						'prompt' => 'Доставка'
					])->label(false); ?>
                </div>

                <div class="w-25 p-1">
					<?= $form->field($model, 'payment_id')->dropDownList(ArrayHelper::map($payments, 'id', 'nameF'), [
						'prompt' => 'Оплата'
					])->label(false); ?>
                </div>

                <div class="w-25 p-1">
					<?= $form->field($model, 'status')->dropDownList(ArrayHelper::map($status, 'id', 'name'), [
						'prompt' => 'Статус'
					])->label(false); ?>
                </div>

                <div class="w-25 p-1">
					<?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map($users, 'id', 'email'), [
						'prompt' => 'Покупатель'
					])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-element">
            <div class="d-flex flex-row">
                <div class="w-50 p-1">
					<?= $form->field($model, 'notes')->textarea(['rows' => 10]); ?>
                </div>
                <div class="w-50 p-1">
					<?= $form->field($model, 'comment')->textarea(['rows' => 10]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-items-edit" role="tabpanel" aria-labelledby="nav-items-edit-tab">
		<?php if ($model->isNewRecord): ?>
			<?= $this->render('include/new_items', [
				'itemsModel' => $itemsModel,
				'form' => $form
			]); ?>
		<?php else: ?>
			<?= $this->render('include/update_items', [
				'itemsModel' => $itemsModel,
				'form' => $form
			]); ?>
		<?php endif; ?>

    </div>
</div>