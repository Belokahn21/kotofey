<?php

/* @var $model \app\models\entity\TodoList */

/* @var $this \yii\web\View */

use app\models\entity\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

?>
<?php if (Yii::$app->request->get('id')): ?>
	<?= $this->render('include/modal/modal-form-edit', [
		'model' => $model
	]); ?>
<?php else: ?>
	<?= $this->render('include/modal/modal-form', [
		'model' => $model
	]); ?>
<?php endif; ?>
<div class="todo-wrap">
    <div class="todo__title">Список заданий <i class="fas fa-plus-square" data-toggle="modal" data-target="#new-task"></i></div>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'emptyText' => 'Задания отсутствуют',
		'columns' => [
			'id',
			[
				'attribute' => 'close',
				'format' => 'raw',
				'value' => function ($model) {
					if ($model->close == 1) {
						return Html::tag('div', 'Активен', ['style' => 'color: green;']);
					} else {
						return Html::tag('div', 'Неактивен', ['style' => 'color: red;']);
					}
				}
			],
			'name',
			'description',
			[
				'attribute' => 'user_id',
				'format' => 'raw',
				'value' => function ($model) {
					return Html::a(User::findOne($model->user_id)->email, Url::to(['admin/user', 'id' => $model->user_id]));
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
//						return Html::a('<i class="fas fa-copy"></i>', "/admin/catalog/$key/?action=copy");
					},
					'update' => function ($url, $model, $key) {
						return Html::a('<i class="far fa-eye"></i>', Url::to(["admin/index", 'id' => $model->id]));
					},
					'delete' => function ($url, $model, $key) {
						return Html::a('<i class="fas fa-trash-alt"></i>',
							Url::to(["/admin/index/", 'id' => $key, 'action' => 'delete', 'target' => 'todo']));
					},
				]
			],
		],
	]); ?>
</div>
