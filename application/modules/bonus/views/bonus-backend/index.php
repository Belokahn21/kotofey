<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\seo\models\tools\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\widgets\GroupBuy\GroupBuyWidget;
use yii\helpers\ArrayHelper;
use app\modules\order\models\entity\OrderStatus;

/* @var $model \app\modules\bonus\models\entity\UserBonusHistory
 * @var $this \yii\web\View
 * @var $availablePhones array
 */

$this->title = Title::show("Бонус аккаунты");
?>
    <div class="title-group">
        <h1>Бонус аккаунты</h1>
    </div>
<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'model' => $model,
    'availablePhones' => $availablePhones,
    'form' => $form,
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>
    <h2 class="title">Бонус аккаунты</h2>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Бонус аккаунты не существуют',
    'columns' => [
        'id',
        'phone',
        'count',
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
