<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var \app\modules\content\models\entity\Sliders $model */
/* @var \yii\web\View $this */

$this->title = Title::show("Слайдеры"); ?>
    <section>
        <h1 class="title">Слайдер</h1>
        <div class="product-form">
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
			<?= $this->render('_form', [
				'form' => $form,
				'model' => $model
			]); ?>
			<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
			<?php ActiveForm::end(); ?>
        </div>
    </section>
    <div class="clearfix"></div>
    <h2>Список слайдеров</h2>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'emptyText' => 'Сладеры отсутствуют',
	'columns' => [
		'id',
		'active',
		'name',
		[
			'attribute' => 'created_at',
			'format' => ['date', 'dd.MM.YYYY'],
			'options' => ['width' => '200']
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
				'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
				},
				'update' => function ($url, $model, $key) {
					return Html::a('<i class="far fa-eye"></i>', Url::to(["update", 'id' => $key]));
				},
				'delete' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-trash-alt"></i>',
						Url::to(["delete", 'id' => $key]));
				},
			]
		],
	],
]); ?>