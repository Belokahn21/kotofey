<?php

use app\models\entity\Delivery;
use app\models\entity\Payment;
use app\models\entity\Promo;
use app\models\entity\User;
use app\models\tool\Currency;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Title::showTitle("Разрешения"); ?>
    <section>
        <h1 class="title">Разрешения</h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Основное</li>
            </ul>

            <div id="tab-1" class="tab-content current">
                <?= $form->field($model, 'name'); ?>
                <?= $form->field($model, 'description'); ?>
<?php //= $form->field($model, 'parent')->dropDownList(); ?>
                <div class="clearfix"></div>
                <hr/>
            </div>
        </div>
        <?= Html::submitButton('Добавить'); ?>
<?php ActiveForm::end(); ?>
    </section>

    <h2 class="title">Список разрешений</h2>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Закзаы отсутствуют',
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
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/order/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    if ($key) {
//
                        return Html::a('<i class="fas fa-trash-alt"></i>',
                            Url::to(["/admin/order/", 'id' => $key, 'action' => 'delete']));
                    }
                }
            ]
        ],
    ],
]);