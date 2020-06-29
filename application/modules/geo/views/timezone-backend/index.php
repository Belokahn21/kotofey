<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\Category;
use app\modules\catalog\models\entity\InformersValues;
use app\models\entity\Stocks;
use app\models\entity\SiteSettings;


/* @var $model \app\modules\catalog\models\entity\Product
 */

$this->title = Title::showTitle("Временные зоны"); ?>
    <section>
        <h1 class="title">Временные зоны</h1>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $this->render('_form', [
            'model' => $model,
            'form' => $form,
        ]); ?>
        <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
        <?php ActiveForm::end(); ?>
    </section>
    <h2>Список Временных зон</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Временные зоны отсутствуют',
    'columns' => [
        'id',
        [
            'attribute' => 'is_active',
            'format' => 'raw',
            'value' => function ($model) {
                switch ($model->is_active) {
                    case 0:
                        return Html::tag('span', 'Не активно', ['class' => 'color-red']);
                        break;
                    case 1:
                        return Html::tag('span', 'Активно', ['class' => 'color-green']);
                        break;
                }
            }
        ],
        'name',
        'value',
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::a('<i class="fas fa-copy"></i>', "/admin/catalog/$key/?action=copy");
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(['update', 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["delete", 'id' => $key]));
                },
            ]
        ],
    ],
]); ?>