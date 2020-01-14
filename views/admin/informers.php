<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

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
		[
			'attribute' => 'id',
		],
		[
			'attribute' => 'name',
			'format' => 'raw',
			'value' => function ($model) {
				return Html::a($model->name, Url::to(['admin/informers', 'id' => $model->id]));
			}
		],
		[
			'attribute' => 'sort',
		],
		[
			'attribute' => 'slug',
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
				'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
				},
				'update' => function ($url, $model, $key) {
					return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/informers/$key"]));
				},
				'delete' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-trash-alt"></i>',
						Url::to(["/admin/informers/", 'id' => $key, 'action' => 'delete']));
				},
			]
		],
	],
]); ?>