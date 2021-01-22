<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $model \app\modules\geo\models\entity\Geo */
/* @var $this \yii\web\View */
/* @var $time_zones \app\modules\geo\models\entity\GeoTimezone[] */

$this->title = Title::show("Гео объекты"); ?>
<h1 class="title">Гео объекты</h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $this->render('_form', [
    'form' => $form,
    'time_zones' => $time_zones,
    'model' => $model,
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
<h2>Список гео объектов</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Гео объекты отсутствуют',
    'columns' => [
        'id',
        'name',
        [
            'attribute' => 'type',
            'value' => function ($model) {
                /* @var $model \app\modules\geo\models\entity\Geo */
                return $model->getTypes()[$model->type];
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd.MM.YYYY'],
//            'options' => ['width' => '200']
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//					return Html::a('<i class="fas fa-copy"></i>', "/admin/geo/$key/?action=copy");
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
<div style="clear: both;"></div>
