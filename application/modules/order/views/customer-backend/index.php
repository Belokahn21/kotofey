<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $model \app\modules\order\models\entity\Customer */
/* @var $properties \app\modules\order\models\entity\CustomerProperties[] */
/* @var $customer_status \app\modules\order\models\entity\CustomerStatus[] */
/* @var $propertiesValues \app\modules\order\models\entity\CustomerPropertiesValues */

$this->title = Title::show("Карточки покупателей"); ?>
    <div class="title-group">
        <h1 class="title">Карточки покупателей</h1>
        <?= Html::a('Свойства', Url::to(['customer-properties-backend/index']), ['class' => 'btn-main']); ?>
        <?= Html::a('Статусы', Url::to(['customer-status-backend/index']), ['class' => 'btn-main']); ?>
    </div>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'properties' => $properties,
    'customer_status' => $customer_status,
    'propertiesValues' => $propertiesValues,
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Карточки покупателей отсутствуют',
    'columns' => [
        'phone',
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
        'sort',
        'name',

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