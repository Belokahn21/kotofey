<?php

use app\models\entity\Payment;
use app\models\entity\Delivery;
use yii\grid\GridView;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use app\models\entity\User;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\helpers\OrderHelper;
use app\models\tool\statistic\OrderStatistic;

/* @var $model \app\models\entity\Order */

$this->title = Title::showTitle("Список заказов"); ?>
    <section class="new-order-block">
        <?php $form = ActiveForm::begin(); ?>
        <?= $this->render('_forms/_order', [
            'form' => $form,
            'model' => $model,
            'itemModel' => $itemModel,
            'items' => array()
        ]); ?>
        <?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
        <?php ActiveForm::end(); ?>
    </section>
    <h2 class="title">Список заказов</h2>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Закзаы отсутствуют',
    'columns' => [
        'id',
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return $model->getStatus();
            }
        ],
        [
            'attribute' => 'delivery_id',
            'value' => function ($model) {
                if ($model->delivery_id > 0) {
                    return Delivery::findOne($model->delivery_id)->name;
                } else {
                    return "Не указано";
                }
            }
        ],
        [
            'attribute' => 'payment_id',
            'value' => function ($model) {
                if ($model->payment_id > 0) {
                    return Payment::findOne($model->payment_id)->name;
                } else {
                    return "Не указано";
                }
            }
        ],
        [
            'attribute' => 'is_paid',
            'value' => function ($model) {
                return ($model->is_paid == true) ? "Оплачено" : "Не оплачено";
            }
        ],
        [
            'attribute' => 'user_id',
            "format" => 'raw',
            'value' => function ($model) {
                if ($model->user_id) {
                    return Html::a(User::findOne($model->user_id)->display, Url::to(['admin/user', 'id' => $model->user_id]));
                }
            }
        ],
        [
            'attribute' => 'cash',
            'format' => 'raw',
            'value' => function ($model) {
                return OrderHelper::orderSummary($model->id) . ' (<span class="green">+' . OrderStatistic::marginality($model->id) . '</span>)';
            }
        ],
        'promo_code',
        [
            'label' => 'Итого к оплате',
            'format' => 'raw',
            'value' => function ($model) {
                $out_summ = OrderHelper::orderSummary($model->id);
                return $out_summ;
            }
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return date("d.m.Y", $model->created_at);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-file-alt"></i>', Url::to(["/admin/order-report", 'id' => $key]));
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/order", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
//                    if ($key) {
//                        return Html::a('<i class="fas fa-trash-alt"></i>',
//                            Url::to(["admin/order", 'id' => $key, 'action' => 'delete']));
//                    }
                }
            ]
        ],
    ],
]);