<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $searchModel \app\modules\acquiring\models\search\AcquiringOrderSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = \app\modules\seo\models\tools\Title::show('Управление чеками');

?>
    <div class="title-group">
        <h1>История отправки чеков</h1>
    </div>
<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Чеки отсутствуют',
    'columns' => [
        'id',
        [
            'attribute' => 'order_id',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a('Заказ #' . $model->order_id, Url::to(['/admin/order/order-backend/update', 'id' => $model->order_id]));
            }
        ],
        'identifier_id',
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd.MM.YYYY'],
            'options' => ['width' => '200']
        ],
        [
            'attribute' => 'updated_at',
            'format' => ['date', 'dd.MM.YYYY'],
            'options' => ['width' => '200']
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
//                    return Html::a('<i class="fas fa-trash-alt"></i>', Url::to(["delete", 'id' => $key]));
                },
            ]
        ],
    ],
]);
