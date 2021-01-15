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

/* @var $model \app\modules\menu\models\entity\MenuItem
 * @var $this \yii\web\View
 * @var $listMenu \app\modules\menu\models\entity\Menu[]
 */

$this->title = Title::showTitle("Меню");
?>
    <div class="title-group">
        <h1>Пункты меню</h1>
        <?= Html::a('Список меню', Url::to(['/menu/menu-backend/index']), ['class' => 'btn-main']); ?>
    </div>
<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'listMenu' => $listMenu,
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>
    <h2 class="title">Список меню</h2>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Меню отсутствуют',
    'columns' => [
        'id',
        'name',
        'is_active',
        'menu_id',
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
                    return Html::a('<i class="fas fa-file-alt"></i>', Url::to(["order-report", 'id' => $key]));
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["update", 'id' => $key]));
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
