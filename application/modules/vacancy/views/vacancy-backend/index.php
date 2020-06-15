<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\tool\seo\Title;

/* @var $this \yii\web\View */
/* @var $model \app\models\entity\Vacancy */
/* @var $city_list \app\models\entity\Geo[] */

$this->title = Title::showTitle("Вакансии");;

?>
    <h1 class="title">Вакансии</h1>
<?php $form = ActiveForm::begin(); ?>
<?= $this->render('_form', [
    'form' => $form,
    'model' => $model,
    'city_list' => $city_list
]) ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
    <h2>Список вакансий</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Вакансии отсутствуют',
    'columns' => [
        'id',
        'title',
        'slug',
        'description',
        'price',
        [
            'attribute' => 'city_id',
            'filter' => ArrayHelper::map($city_list, 'id', 'name')
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
//					return Html::a('<i class="fas fa-sign-in-alt"></i>', Url::to(["/admin/user/", 'id' => $model->id, 'action' => 'auth']));
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