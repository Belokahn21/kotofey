<?php

use app\models\entity\Product;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use app\models\entity\Category;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $model \app\models\entity\Category */
?>
<? $this->title = Title::showTitle("Разделы"); ?>
    <h1 class="title">Разделы</h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $this->render('_forms/_category', [
	'form' => $form,
	'model' => $model,
	'categories' => $categories,
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm:: end(); ?>
    <h2>Разделы товаров</h2>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $model,
	'emptyText' => 'Разделы отсутствуют',
	'columns' => [
		'attribute' => 'id',
		[
			'attribute' => 'name',
			'format' => 'raw',
			'value' => function ($model) {
				return Html::a($model->name, '/admin/category/' . $model->id . '/');
			}
		],
		[
			'attribute' => 'test',
			'label' => 'Количество товаров',
			'value' => function ($model) {
				return Product::find()->where(['category' => $model->id])->count();
			},
		],
		[
			'attribute' => 'image',
			'label' => 'Изображение',
			'format' => 'raw',
			'value' => function ($model) {
				return Html::img('/web/upload/' . $model->image, ["width" => 40]);
			},
		],
		[
			'attribute' => 'parent',
			'format' => 'raw',
			'value' => function ($model) {
				$category = Category::findOne($model->parent);
				if ($category) {
					return Html::a($category->name, "/admin/category/" . $model->parent . "/");
				} else {
					return "Родитель";
				}
			},
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
				'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
				},
				'update' => function ($url, $model, $key) {
					return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/category/$key"]));
				},
				'delete' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-trash-alt"></i>',
						Url::to(["admin/category", 'id' => $key, 'action' => 'delete']));
				},
			]
		],
	],
]); ?>