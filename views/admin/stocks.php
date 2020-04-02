<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\entity\Product;
use yii\helpers\Url;

/* @var $model \app\models\entity\Stocks */
/* @var $this \yii\web\View */

?>
<?php $this->title = Title::showTitle("Склады"); ?>
<section>
    <h1 class="title">Склады</h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_forms/_stocks', [
        'model' => $model,
        'form' => $form,
    ]); ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>
<h2 class="title">Список статусов</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Склады отсутствуют',
    'columns' => [
        'id',
        [
            'attribute' => 'active',
            'filter' => ['Не активен', 'Активен'],
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->active) {
                    return Html::tag('span', 'Активен', ['class' => 'green']);
                } else {
                    return Html::tag('span', 'Не активен', ['class' => 'red']);
                }
            }
        ],
        'name',
        'address',
        [
            'label' => 'Количетсво товаров',
            'value' => function ($model) {
                return Product::find()->where(['stock_id' => $model->id])->count();
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["stocks", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["stocks", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>
