<?php

use yii\helpers\Url;
use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\entity\Sliders;

/* @var \app\models\entity\SlidersImages $model */
/* @var \yii\web\View $this */

$this->title = Title::showTitle("Изображения слайдеров"); ?>
    <section>
        <h1 class="title">Изображения слайдеров</h1>
        <div class="product-form">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="tabs-container">
                <ul class="tabs">
                    <li class="tab-link current" data-tab="tab-1">Основное</li>
                    <li class="tab-link" data-tab="tab-2">Другие настройки</li>
                </ul>

                <div id="tab-1" class="tab-content current">
                    <?php echo $form->field($model, 'slider_id')->dropDownList(ArrayHelper::map(Sliders::find()->all(),
                        'id', 'name'), ['prompt' => 'Слайдер']); ?>
                    <?php echo $form->field($model, 'text')->textInput() ?>
                    <?php echo $form->field($model, 'description')->textInput() ?>
                    <?php echo $form->field($model, 'image')->fileInput(); ?>
                </div>
                <div id="tab-2" class="tab-content">
                    <?php echo $form->field($model, 'active')->radioList(['Нет', 'Да']) ?>
                    <?php echo $form->field($model, 'sort')->textInput() ?>
                </div>
            </div>
            <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
        </div>
    </section>
    <div class="clearfix"></div>
    <h2>Список изображений</h2>
<?php echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Сладеры отсутствуют',
    'columns' => [
        'id',
        'text',
        'description',
        [
            'attribute' => 'slider_id',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Sliders::findOne($model->slider_id)->name,
                    Url::to(['admin/sliders', 'id' => $model->slider_id]));
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd.MM.YYYY'],
            'options' => ['width' => '200']
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>',
                        Url::to(['admin/sliderimages', 'id' => $model->slider_id]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/sliderimages/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>