<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\modules\seo\models\tools\Title;

/* @var $this \yii\web\View */
/* @var $model mixed */
/* @var $searchModel \app\modules\delivery\models\search\DeliveryServiceSearchForm */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Title::show('Транспортные компании');
?>

    <div class="title-group">
        <h1>Транспортные компании</h1>
        <?= Html::a('Оплаты', Url::to(['/admin/payment/payment-backend/index']), ['class' => 'btn-main']); ?>
        <?= Html::a('Доставки', Url::to(['/admin/delivery/delivery-backend/index']), ['class' => 'btn-main']); ?>
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

    <h2 class="title">Список транспортных компаний</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Транспортные компании отсутствуют',
    'columns' => [
        'id',
        'name',
        'code',
        'media_id',
        [
            'attribute' => 'is_active',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::tag('span', $model->is_active == 1 ? 'Активен' : 'Не активен', ['class' => $model->is_active == 1 ? 'green' : 'red']);
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