<?php

/* @var $this yii\web\View
 * @var $model \app\modules\delivery\models\entity\Delivery
 */

use app\modules\delivery\models\helper\DeliveryHelper;
use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::show("Управление доставками");
?>

<div class="title-group">
    <h1>Доставки</h1>
    <?= Html::a('Оплаты', Url::to(['/admin/payment/payment-backend/index']), ['class' => 'btn-main']); ?>
</div>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]) ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
<h2 class="title">Список доставок</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Доставки отсутствуют',
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
                return Html::img(DeliveryHelper::getImageUrl($model));
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
