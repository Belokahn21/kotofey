<?php

use app\modules\delivery\models\entity\Delivery;
use app\modules\payment\models\entity\Payment;
use app\models\entity\Promo;
use app\modules\user\models\entity\User;
use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Title::showTitle("Разрешения"); ?>
    <h1 class="title">Разрешения</h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $this->render('_form', [
    'form' => $form,
    'model' => $model
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>

    <h2 class="title">Список разрешений</h2>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Разрешения отсутствуют',
    'columns' => [
        'name',
        'description',
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
                }
            ]
        ],
    ],
]);