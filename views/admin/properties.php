<?php

use yii\helpers\ArrayHelper;
use app\models\entity\Informers;
use app\models\entity\TypeProductProperties;
use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $model \app\models\entity\ProductProperties */

$this->title = Title::showTitle("Свойства товаров"); ?>
    <section>
        <ul>
            <?= Html::a('Справочники', '/admin/informers/'); ?>
            <?= Html::a('Значения справочников', '/admin/informersvalues/'); ?>
        </ul>
    </section>
    <section>
        <h1 class="title">Свойства товаров</h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Основное</li>
            </ul>

            <div id="tab-1" class="tab-content current">
                <?= $form->field($model, 'active')->radioList(['Нет', 'Да']) ?>
                <?= $form->field($model, 'need_show')->radioList(['Нет', 'Да']) ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'sort')->textInput() ?>

<?php if (Yii::$app->request->get('type')) {
                    $model->type = Yii::$app->request->get('type');
                } ?>

                <?= $form->field($model, 'type')->dropDownList((new TypeProductProperties())->listType(), ['prompt' => "Тип свойства", 'id'=>'select-type-prop']) ?>
<?php if (Yii::$app->request->get('type') == "1"): ?>
                    <?= $form->field($model, 'informer_id')->dropDownList(ArrayHelper::map(Informers::find()->all(), 'id', 'name'), ['prompt'=>'Справочник']) ?>
<?php endif; ?>
            </div>

        </div>
		<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
    </section>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Товары отсутствуют',
    'columns' => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'active',
            'format' => 'raw',
            'value' => function ($model) {
                return ($model->active == 1 ? "Да" : "Нет");
            }
        ],
        [
            'attribute' => 'need_show',
            'format' => 'raw',
            'value' => function ($model) {
                return ($model->need_show == 1 ? "Да" : "Нет");
            }
        ],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->name, '/admin/properties/' . $model->id . '/');
            }
        ],
        [
            'attribute' => 'sort',
        ],
        [
            'attribute' => 'type',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/properties/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/properties/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>