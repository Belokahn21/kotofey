<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $searchModel \app\models\search\InformersSearchForm */

$this->title = Title::showTitle("Справочники"); ?>
    <section>
        <h1 class="title">Справочники</h1>
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?= $this->render('_forms/_informers', [
			'model' => $model,
			'form' => $form,
		]); ?>
		<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
		<?php ActiveForm::end(); ?>
    </section>
    <h2 class="title">Список справочников</h2>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'emptyText' => 'Справочники отсутствуют',
	'columns' => [
		'id',
		[
			'attribute' => 'is_active',
			'format' => 'raw',
			'filter' => ['Не активен', 'Активен'],
			'value' => function ($model) {
				if ($model->is_active) {
					return Html::tag('span', 'Активен', ['class' => 'green']);
				} else {
					return Html::tag('span', 'Не активен', ['class' => 'red']);
				}
			}
		],
		[
			'attribute' => 'is_show_filter',
			'filter' => ['Не показывать', 'Показывать'],
			'format' => 'raw',
			'value' => function ($model) {
				if ($model->is_show_filter) {
					return Html::tag('span', 'Показывать', ['class' => 'green']);
				} else {
					return Html::tag('span', 'Не показывать', ['class' => 'red']);
				}
			}
		],
		[
			'attribute' => 'name',
			'format' => 'raw',
			'value' => function ($model) {
				return Html::a($model->name, Url::to(['admin/informers', 'id' => $model->id]));
			}
		],
		'sort',
		'slug',
		[
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
				'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
				},
				'update' => function ($url, $model, $key) {
					return Html::a('<i class="far fa-eye"></i>', Url::to(["informers", 'id' => $key]));
				},
				'delete' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-trash-alt"></i>',
						Url::to(["informers", 'id' => $key, 'action' => 'delete']));
				},
			]
		],
	],
]); ?>