<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\widgets\group_buy\GroupBuyWidget;
use yii\helpers\ArrayHelper;
use app\modules\order\models\entity\OrderStatus;

/* @var $model \app\modules\bonus\models\entity\UserBonusHistory
 * @var $this \yii\web\View
 * @var $orders \app\modules\order\models\entity\Order[]
 * @var $bonusAccount \app\modules\bonus\models\entity\UserBonus[]
 */

$this->title = Title::showTitle("История операций с бонусами");
?>
    <div class="title-group">
        <h1>История операций с бонусами</h1>
    </div>
<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'orders' => $orders,
    'bonusAccount' => $bonusAccount,
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>
    <h2 class="title">История операций с бонусами</h2>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'История операций пуста',
    'columns' => [
        'id',
        'count',
        'bonus_account_id',
        'order_id',
        'reason',
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
//                    return Html::a('<i class="fas fa-file-alt"></i>', Url::to(["order-report", 'id' => $key]));
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["update", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>', Url::to(["delete", 'id' => $key]));

                }
            ]
        ],
    ],
]);
