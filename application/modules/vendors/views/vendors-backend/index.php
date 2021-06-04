<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var \yii\web\View $this */

$this->title = Title::show("Поставщики"); ?>
    <div class="title-group">
        <h1 class="title">Поставщики</h1>
        <?= Html::a('Группы поставщиков', Url::to(['/admin/vendors/vendors-group-backend/index']), ['class' => 'btn-main']); ?>
    </div>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>

    <div class="clearfix"></div>
    <h2>Список поставщиков</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Поставщики отсутствуют',
    'columns' => [
        'id',
        'name',
        'legal_name',
        [
            'attribute' => 'email',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->email, 'mailto:' . $model->email);
            }
        ],
        [
            'attribute' => 'phone',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->phone, 'tel:' . $model->phone);
            }
        ],
        'discount',
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd.MM.YYYY'],
            'options' => ['width' => '200']
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