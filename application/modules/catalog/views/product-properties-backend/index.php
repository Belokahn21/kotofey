<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $model \app\modules\catalog\models\entity\SaveProductProperties */

$this->title = Title::showTitle("Свойства товаров"); ?>
    <section>
        <h1 class="title">Свойства товаров</h1>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $this->render('_form', [
            'model' => $model,
            'form' => $form,
        ]); ?>
        <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
        <?php ActiveForm::end(); ?>
    </section>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Свойства отсутствуют',
    'columns' => [
        'id',
        [
            'attribute' => 'active',
            'format' => 'raw',
            'value' => function ($model) {
                return ($model->active == 1 ? "Да" : "Нет");
            }
        ],
        [
            'attribute' => 'need_show',
            'format' => 'raw',
            'value' => function ($model) {
                return ($model->need_show == 1 ? "Да" : "Нет");
            }
        ],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->name, Url::to(['update', 'id' => $model->id]));
            }
        ],
        'sort',
        'type',
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