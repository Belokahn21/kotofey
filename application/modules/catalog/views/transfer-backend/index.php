<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\seo\models\tools\Title;
use app\modules\order\models\entity\Order;
use app\modules\catalog\models\entity\Product;

/* @var $this \yii\web\View
 * @var $model \app\modules\catalog\models\entity\ProductTransferHistory
 * @var $orders \app\modules\order\models\entity\Order[]
 * @var $products Product[]
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel \app\modules\catalog\models\search\ProductTransferHistorySearch
 */

$this->title = Title::show('Поступления товаров');
?>
    <div class="title-group">
        <h1>Поступления товаров</h1>
    </div>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'orders' => $orders,
    'products' => $products,
]) ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
    <h2>История поступления товаров</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'История поступления товаров отсуствует',
    'columns' => [
        'id',
        'count',
        'reason',
        [
            'attribute' => 'operation_id',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::tag('div', ArrayHelper::getValue($model->getOperations(), $model->operation_id));
            }
        ],
        [
            'attribute' => 'order_id',
            'filter' => ArrayHelper::map($orders, 'id', 'id'),
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->order_id) {
                    return Html::a('Заказ №' . Order::findOne($model->order_id)->id, Url::to(['/admin/order/order-backend/update', 'id' => $model->order_id]));
                }
            }
        ],
        [
            'attribute' => 'product_id',
            'filter' => ArrayHelper::map($products, 'id', 'name'),
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Product::findOne($model->product_id)->name, Url::to(['/admin/catalog/product-backend/update', 'id' => $model->product_id]));
            }
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