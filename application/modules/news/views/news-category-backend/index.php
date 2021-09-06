<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\news\models\entity\NewsCategory;

/* @var $model \app\modules\news\models\entity\NewsCategory */
/* @var $this \yii\web\View */

$this->title = Title::show("Рубрики");
?>
<div class="title-group">
    <h1 class="title">Рубрики новостей</h1>
</div>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
<h2>Список рубрик</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Рубрики отсутствуют',
    'columns' => [
        'id',
        'name',
//        [
//            'attribute' => 'is_active',
//            'filter' => ['Не активен', 'Активен'],
//            'format' => 'raw',
//            'value' => function ($model) {
//                if ($model->is_active) {
//                    return Html::tag('span', 'Активен', ['class' => 'green']);
//                } else {
//                    return Html::tag('span', 'Не активен', ['class' => 'red']);
//                }
//            }
//        ],
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
