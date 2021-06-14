<?php

use app\modules\news\models\entity\NewsCategory;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $model \app\modules\news\models\entity\News */

$this->title = Title::show("Новости");
?>


<section>
    <h1 class="title">Новости</h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'form' => $form,
        'model' => $model,
    ]); ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
    <?php ActiveForm:: end(); ?>
</section>
<div class="clearfix"></div>
<h2>Список новостей</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Новости отсутствуют',
    'columns' => [
        'id',
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->title, Url::to(['update', 'id' => $model->id]));
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd.MM.YYYY'],
        ],
        [
            'attribute' => 'updated_at',
            'format' => ['date', 'dd.MM.YYYY'],
        ],
        [
            'attribute' => 'category',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(NewsCategory::findOne($model->category)->name, Url::to(['admin/newssections', 'id' => $model->category]), ['target' => '_blank']);
            }
        ],
        [
            'attribute' => 'seo_optimized',
            'label' => 'Сео оптимизация',
            'format' => 'raw',
            'value' => function ($model) {

                $fullComplete = 3;
                $countStepsTrue = 0;
                $reasons = [];

                /* @var @model Pages */
                if (count(explode(",", $model->seo_keywords)) < 8) {
                    $reasons[] = "Количество ключей меньше 8 штук";
                } else {
                    $countStepsTrue++;
                }

                if (strlen($model->seo_keywords) < 120) {
                    $reasons[] = "Количество символов SEO описания меньше 120 символа";
                } else {
                    $countStepsTrue++;
                }


                if ($countStepsTrue >= $fullComplete) {
                    return '<i class="fas fa-check-circle" style="color: green;"></i>';
                }

                if ($countStepsTrue < $fullComplete) {
                    return '<i class="fas fa-exclamation-triangle" style="color: orange;" title="' . implode("\n", $reasons) . '"></i>';
                }
            }
        ],
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
                },
            ]
        ],
    ],
]); ?>
