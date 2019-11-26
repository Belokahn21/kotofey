<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\entity\UserSex;
use app\models\entity\Discount;

/* @var $model \app\models\entity\User */
/* @var $groups \app\models\rbac\AuthItem[] */

$this->title = Title::showTitle("Пользователи"); ?>
    <section>
        <h1 class="title">Пользователи</h1>
		<? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?= $this->render('_forms/_user', [
			'model' => $model,
			'form' => $form,
			'groups' => $groups
		]); ?>
		<?= Html::submitButton('Добавить'); ?>
		<? ActiveForm::end(); ?>
    </section>
    <h1>Список пользователей</h1>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $model,
	'emptyText' => 'Пользователи отсутствуют',
	'columns' => [
		'id',
		'email',
		[
			'attribute' => 'sex',
			'value' => function ($model) {
				if (!$sex = UserSex::findOne($model->sex)) {
					$sex = new UserSex();
					$sex->name = 'не указан';
				}
				return $sex->name;
			}
		],
		[
			'attribute' => 'first_name',
		],
		[
			'attribute' => 'name',
		],
		[
			'attribute' => 'last_name',
		],
		[
			'label' => 'Бонусы',
			'format' => 'raw',
			'value' => function ($model) {
				$discount = Discount::findByUserId($model->id);
				if ($discount) {
					return $discount->count;
				} else {
				    return 0;
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
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
				'view' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-sign-in-alt"></i>',
						Url::to(["/admin/user/", 'id' => $model->id, 'action' => 'auth']));
				},
				'update' => function ($url, $model, $key) {
					return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/user/$key"]));
				},
				'delete' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-trash-alt"></i>',
						Url::to(["/admin/user/", 'id' => $key, 'action' => 'delete']));
				},
			]
		],
	],
]); ?>