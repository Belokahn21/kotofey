<?php

use app\modules\catalog\models\entity\Product;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\seo\models\tools\Title;
use app\modules\catalog\models\entity\ProductCategory;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $model \app\modules\catalog\models\entity\ProductCategory */
?>
<?php $this->title = Title::show("Разделы"); ?>
    <h1 class="title">Разделы</h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $this->render('_form', [
    'form' => $form,
    'model' => $model,
    'categories' => $categories,
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm:: end(); ?>
    <h2>Разделы товаров</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchForm,
    'emptyText' => 'Разделы отсутствуют',
    'columns' => [
        'id',
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->name, Url::to(['update', 'id' => $model->id]));
            }
        ],
        [
            'attribute' => 'test',
            'label' => 'Количество товаров',
            'value' => function ($model) {
                return Product::find()->where(['category_id' => $model->id])->count();
            },
        ],
        [
            'attribute' => 'image',
            'label' => 'Изображение',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::img('/upload/' . $model->image, ["width" => 40]);
            },
        ],
        [
            'attribute' => 'parent',
            'format' => 'raw',
            'value' => function ($model) {
                $category = ProductCategory::findOne($model->parent);
                if ($category) {
                    return Html::a($category->name, Url::to(['update', 'id' => $model->parent]));
                } else {
                    return "Родитель";
                }
            },
        ],
        'seo_title',
        'seo_description',
        'seo_keywords',
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
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["delete", 'id' => $key]));
                },
            ]
        ],
    ],
]); ?>