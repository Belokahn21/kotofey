<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;
use app\modules\reviews\models\helpers\ReviewsHelper;

/* @var $model \app\modules\reviews\models\entity\Reviews */

$this->title = Title::show("Отзывы к товарам");
?>
    <div class="title-group">
        <h1>Отзывы к товарам</h1>
    </div>
<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'form' => $form,
    'model' => $model,
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>
    <h2 class="title">Список отзывов</h2>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Отзывы к товарам отсутствуют',
    'columns' => [
        'id',
        'is_active',
        [
            'attribute' => 'status_id',
            'format' => 'raw',
            'value' => function ($model) {
                return ReviewsHelper::getStatus($model);
            }
        ],
        'rate',
        'text',
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
//                    return Html::a('<i class="fas fa-file-alt"></i>', Url::to(["report", 'id' => $key]));
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["update", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
//                    if ($key) {
//                        return Html::a('<i class="fas fa-trash-alt"></i>',
//                            Url::to(["admin/order", 'id' => $key, 'action' => 'delete']));
//                    }
                }
            ]
        ],
    ],
]);
