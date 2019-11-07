<?

/* @var $this yii\web\View */

/* @var $model \app\models\entity\Delivery */

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::showTitle("Управление доставками");
?>
<section class="delivery">
    <h1 class="title">Доставки</h1>
	<?php $form = ActiveForm::begin(); ?>
	<?= $this->render('_forms/_delivery', [
		'model' => $model,
		'form' => $form,
	]) ?>
	<?= Html::submitButton('Добавить') ?>
	<?php ActiveForm::end(); ?>
</section>
<h2 class="title">Список доставок</h2>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $model,
	'emptyText' => 'Доставки отсутствуют',
	'columns' => [
		[
			'attribute' => 'id',
		],
		[
			'attribute' => 'name',
		],

		[
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
				'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
				},
				'update' => function ($url, $model, $key) {
					return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/delivery/$key"]));
				},
				'delete' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-trash-alt"></i>', Url::to(["/admin/delivery/", 'id' => $key, 'action' => 'delete']));
				},
			]
		],
	],
]); ?>
