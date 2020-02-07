<?php

use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this \yii\web\View */
/* @var $model \app\models\entity\ShortLinks */

$this->title = Title::showTitle("Короткие ссылки");
?>
<h1>Короткие ссылки</h1>
<?php $form = ActiveForm::begin(); ?>
<?= $this->render('_forms/_shortly', [
	'form' => $form,
	'model' => $model
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>

<h2>Список ссылок</h2>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'emptyText' => 'Ссылки отсутствуют',
	'columns' => [
		'id',
		'is_active',
		'visits',
		'short_code',
		'name',
		'link',
		[
			'value' => function ($model) {
				return Html::a('https://kotofey.store/catalog/' . $model->short_code . '/', 'https://kotofey.store/catalog/' . $model->short_code . '/');
			}
		],
		[
			'attribute' => 'created_at',
			'format' => ['date', 'dd.MM.YYYY'],
			'options' => ['width' => '200']
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
				'view' => function ($url, $model, $key) {
//					return Html::a('<i class="fas fa-copy"></i>', Url::to(['admin/shortly', 'action' => 'copy', 'id' => $key]));
				},
				'update' => function ($url, $model, $key) {
					return Html::a('<i class="far fa-eye"></i>', Url::to(["admin/shortly", 'id' => $key]));
				},
				'delete' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-trash-alt"></i>',
						Url::to(["admin/shortly", 'id' => $key, 'action' => 'delete']));
				},
			]
		],
	],
]); ?>
