<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $model \app\modules\catalog\models\entity\Properties */
/* @var $propertyGroup \app\modules\catalog\models\entity\PropertyGroup[] */

$this->title = Title::show("Свойства товаров"); ?>
    <section>
        <h1 class="title">Свойства товаров</h1>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $this->render('_form', [
            'model' => $model,
            'form' => $form,
            'propertyGroup' => $propertyGroup,
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
            'attribute' => 'is_active',
            'filter' => ['Неактивные', 'Активные'],
            'format' => 'raw',
            'value' => function ($model) {
                return ($model->is_active == 1 ? "Да" : "Нет");
            }
        ],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->name, Url::to(['update', 'id' => $model->id]));
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
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["delete", 'id' => $key]));
                },
            ]
        ],
    ],
]); ?>