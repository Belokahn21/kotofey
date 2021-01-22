<?php
/* @var $this \yii\web\View
 *
 */

use app\models\tool\seo\Title;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$this->title = Title::show("Промокоды");
?>
    <div class="title-group">
        <h1>Промокоды</h1>
        <?= Html::a('Очистить истоию промокодов', Url::to(['/promocode/promocode-backend/clean']), ['class' => 'btn-main']); ?>
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
    <h2>Список промокодов</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Промокоды отсутствуют',
    'columns' => [
        'id',
        'code',
        'discount',
        'count',
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::a('<i class="fas fa-copy"></i>', "/admin/catalog/$key/?action=copy");
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["update", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["delete", 'id' => $key]));
                },
            ]
        ],
    ],
]); ?>