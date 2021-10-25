<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;
use app\modules\site\widgets\AdminMenu\AdminMenuWidget;

$this->title = Title::show("Маркетплейсы");
?>

<?= AdminMenuWidget::widget([
    'title' => 'Маркетплейсы',
//    'links' => [
//        ['title' => 'Выгрузка Email', 'url' => Url::to(['order-backend/export'])],
//        ['title' => 'Карточки клиентов', 'url' => Url::to(['customer-backend/index'])],
//        ['title' => 'Группированные продажи', 'url' => Url::to(['order-backend/group'])],
//    ]
]); ?>

<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>
    <h2 class="title">Список маркетплейсов</h2>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Маркетплейсы отсутствуют',
    'columns' => [
        'id',
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
        'name',
        'sort',
        [
            'attribute' => 'created_at',
        ],
        [
            'attribute' => 'updated_at',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::a('<i class="fas fa-file-alt"></i>', Url::to(["report", 'id' => $key]));
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["update", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>', Url::to(["admin/order", 'id' => $key, 'action' => 'delete']));
                }
            ]
        ],
    ],
]);
