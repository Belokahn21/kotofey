<?php

/* @var $this yii\web\View
 * @var $model \app\modules\payment\models\entity\Payment
 */

use app\modules\payment\models\helper\PaymentHelper;
use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::show("Управление оплатами");
?>
<div class="title-group">
    <h1>Оплаты</h1>
    <?= Html::a('Доставки', Url::to(['/admin/delivery/delivery-backend/index']), ['class' => 'btn-main']); ?>
</div>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]) ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
<h2 class="title">Список оплат</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Оплаты отсутствуют',
    'columns' => [
        'id',
        'name',
        [
            'attribute' => 'active',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::tag('span', $model->active == 1 ? 'Активен' : 'Не активен', ['class' => $model->active == 1 ? 'green' : 'red']);
            }
        ],
        [
            'attribute' => 'image',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::img(PaymentHelper::getImageUrl($model));
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
