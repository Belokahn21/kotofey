<?

use app\models\entity\OrderStatus;
use app\models\tool\Price;
use app\models\entity\Payment;
use app\models\entity\Delivery;
use yii\grid\GridView;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use app\models\entity\User;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\tool\Currency;
use app\models\entity\Promo;

/* @var $model \app\models\forms\OrderForm */

$this->title = Title::showTitle("Список заказов"); ?>
    <section class="new-order-block">
		<? $form = ActiveForm::begin(); ?>
        <div class="left-col">
            <h1 class="title">Новый заказ</h1> <span class="order-summ">Сумма заказа: <span
                        class="order-summ-count"><?= rand(); ?></span><?= (new Currency())->show(); ?></span>
            <h3 class="title">Информация о заказе</h3>
            <div class="new-order-info">
				<?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(OrderStatus::find()->all(), 'id',
					'name'), ['prompt' => 'Статус заказа']); ?>
				<?= $form->field($model, 'payment')->dropDownList(ArrayHelper::map(Payment::find()->all(), 'id',
					'name'), ['prompt' => 'Способ оплаты']); ?>
				<?= $form->field($model, 'delivery')->dropDownList(ArrayHelper::map(Delivery::find()->all(), 'id',
					'name'), ['prompt' => 'Способ доставки']); ?>
            </div>
			<?= $form->field($model, 'paid')->radioList(array("Не оплачено", "Оплачено")); ?>
			<?= $form->field($model, 'comment')->textarea(); ?>
            <h3 class="title">Покупатель</h3>
			<?= $form->field($model, 'user')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'name'),
				['prompt' => 'Покупатель']); ?>
        </div>
        <div class="right-col">
            <h3 class="title">Товары в заказе</h3>
			<?= $form->field($model, 'product_id[]')->widget('\app\widgets\SelectProductDropdown')->label(false) ?>
        </div>
        <div class="clearfix"></div>
		<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
		<? ActiveForm::end(); ?>
    </section>
    <h2 class="title">Список заказов</h2>
<?php echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $model,
	'emptyText' => 'Закзаы отсутствуют',
	'columns' => [
		[
			'attribute' => 'id',
		],
		[
			'attribute' => 'status',
			'value' => function ($model) {
				return $model->getStatus();
			}
		],
		[
			'attribute' => 'delivery',
			'value' => function ($model) {
				if ($model->delivery > 0) {
					return Delivery::findOne($model->delivery)->name;
				} else {
					return "Не указано";
				}
			}
		],
		[
			'attribute' => 'payment',
			'value' => function ($model) {
				if ($model->payment > 0) {
					return Payment::findOne($model->payment)->name;
				} else {
					return "Не указано";
				}
			}
		],
		[
			'attribute' => 'paid',
			'value' => function ($model) {
				return ($model->paid == true) ? "Оплачено" : "Не оплачено";
			}
		],
		[
			'attribute' => 'user',
			"format" => 'raw',
			'value' => function ($model) {
				return Html::a(User::findOne($model->user)->email, '/admin/user/' . $model->user . '/');
			}
		],
		[
			'attribute' => 'cash',
			'format' => 'raw',
			'value' => function ($model) {
				if ($model->promo_code !== null) {
					$promo = Promo::findByCode($model->promo_code);
					return Price::format($model->cash) . (new Currency())->show();
				} else {
					return Price::format($model->cash) . "" . (new Currency())->show();
				}
			}
		],
		[
			'attribute' => 'created_at',
			'value' => function ($model) {
				return date("d.m.Y", $model->created_at);
			}
		],
		[
			'attribute' => 'promo_code',
			'value' => function ($model) {
				if ($model->promo_code) {
					return $model->promo_code . "(" . Promo::findByCode($model->promo_code)->discount . "%)";
				} else {
					return "Отстуствует";
				}
			}
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
//				'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
//				},
//				'update' => function ($url, $model, $key) {
//					return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/order/$key"]));
//				},
//				'delete' => function ($url, $model, $key) {
//					if ($key) {

//						return Html::a('<i class="fas fa-trash-alt"></i>',
//							Url::to(["/admin/order/", 'id' => $key, 'action' => 'delete']));
//					}
//				}
			]
		],
	],
]);