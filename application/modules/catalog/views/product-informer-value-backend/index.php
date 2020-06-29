<?php

use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\Informers;

/* @var $model \app\modules\catalog\models\entity\InformersValues */
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\modules\catalog\models\search\InformersValuesSearchForm */

$this->title = Title::showTitle("Значения справочников"); ?>
    <section>
        <h1 class="title">Значения справочников</h1>
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?= $this->render('_form', [
			'model' => $model,
			'form' => $form,
		]) ?>
		<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
		<?php ActiveForm::end(); ?>
    </section>
    <h2>Список значений</h2>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'emptyText' => 'Значения отсутствуют',
	'columns' => [
		'id',
		[
			'attribute' => 'active',
			'format' => 'raw',
			'filter' => ['Не активен', 'Активен'],
			'value' => function ($model) {
				if ($model->active) {
					return Html::tag('span', 'Активен', ['class' => 'green']);
				} else {
					return Html::tag('span', 'Не активен', ['class' => 'red']);
				}
			}
		],
		[
			'attribute' => 'name',
			'format' => 'raw',
			'value' => function ($model) {
				return Html::a($model->name, Url::to(["update", 'id' => $model->id]));
			}
		],
		'sort',
		'description',
		[
			'attribute' => 'informer_id',
			'format' => 'raw',
			'filter' => ArrayHelper::map(Informers::find()->asArray(true)->all(), 'id', 'name'),
			'value' => function ($model) {
				return Informers::findOne($model->informer_id)->name;
			}
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
					return Html::a('<i class="fas fa-trash-alt"></i>', Url::to(["delete", 'id' => $key]));
				},
			]
		],
	],
]); ?>