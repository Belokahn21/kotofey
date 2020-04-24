<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $users \app\models\entity\User[]
 * @var $model \app\models\entity\Order
 * @var $deliveries \app\models\entity\Delivery[]
 * @var $payments \app\models\entity\Payment[]
 * @var $status \app\models\entity\OrderStatus[]
 * @var $itemsModel \app\models\entity\OrdersItems
 */

$this->title = "Заказы";
?>
    <h1>Заказы</h1>
<?php $form = ActiveForm::begin() ?>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
            <a class="nav-item nav-link" id="nav-items-edit-tab" data-toggle="tab" href="#nav-items-edit" role="tab" aria-controls="nav-items-edit" aria-selected="false">Товары в заказе</a>
        </div>
    </nav>


    <div class="tab-content" id="nav-tab-content-form">
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
						<?= $form->field($model, 'delivery_id')->dropDownList(ArrayHelper::map($payments, 'id', 'nameF'), [
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
						<?= $form->field($model, 'notes')->textarea(); ?>
                    </div>
                    <div class="w-50 p-1">
						<?= $form->field($model, 'comment')->textarea(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="nav-items-edit" role="tabpanel" aria-labelledby="nav-items-edit-tab">
			<?php for ($i = 0; $i < 6; $i++): ?>
                <div class="row orders-items-item">
                    <div class="col-sm-3">
						<?= $form->field($itemsModel, '[' . $i . ']name')->textInput(['class' => 'load-product-info__name form-control']); ?>
                    </div>
                    <div class="col-sm-3">
						<?= $form->field($itemsModel, '[' . $i . ']count')->textInput(['class' => 'load-product-info__count form-control']); ?>
                    </div>
                    <div class="col-sm-3">
						<?= $form->field($itemsModel, '[' . $i . ']price')->textInput(['class' => 'load-product-info__price form-control']); ?>
                    </div>
                    <div class="col-sm-2">
						<?= $form->field($itemsModel, '[' . $i . ']product_id')->textInput(['class' => 'load-product-info form-control']); ?>
                    </div>
                    <div class="col-sm-1">
						<?= $form->field($itemsModel, '[' . $i . ']need_delete')->checkbox(); ?>
                    </div>
                </div>
			<?php endfor; ?>
        </div>
    </div>

<?php ActiveForm::end() ?>