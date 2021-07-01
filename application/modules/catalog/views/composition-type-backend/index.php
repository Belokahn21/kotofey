<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;

/* @var $this \yii\web\View */
/* @var $model mixed */
/* @var $searchModel \app\modules\catalog\models\search\CompositionSearchForm */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Title::show('Типы элементов состава');
?>
    <div class="title-group">
        <h1>Типы элементов состава</h1>
        <?= Html::a('Элемент состава', Url::to(['composition-backend/index']), ['target' => '_blank', 'class' => 'btn-main']) ?>
    </div>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]) ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
    <h2>Список типов состава</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Типы элементов состава отсутствуют',
    'columns' => [
        'id',
        'name',
        [
            'attribute' => 'is_active',
            'filter' => ['Не активен', 'Активен'],
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->is_active) {
                    return Html::tag('span', 'Активен', ['class' => 'green']);
                } else {
                    return Html::tag('span', 'Не активен', ['class' => 'red']);
                }
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd.MM.YYYY'],
        ],
        [
            'attribute' => 'updated_at',
            'format' => ['date', 'dd.MM.YYYY'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::a('<i class="far fa-copy"></i>', Url::to(["copy", 'id' => $key]));
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