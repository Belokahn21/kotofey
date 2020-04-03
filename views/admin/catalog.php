<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\entity\Category;
use app\models\entity\InformersValues;
use app\models\entity\Stocks;
use app\models\entity\SiteSettings;


/* @var $model \app\models\entity\Product
 * @var $modelDelivery \app\models\entity\ProductOrder
 * @var $properties \app\models\entity\ProductProperties[]
 * @var $searchModel \app\models\search\ProductSearchForm
 */

$this->title = Title::showTitle("Товары"); ?>
    <section>
        <h1 class="title">Товары</h1>
        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => true,
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <?= $this->render('_forms/_catalog', [
            'model' => $model,
            'form' => $form,
            'modelDelivery' => $modelDelivery,
            'properties' => $properties
        ]); ?>
        <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
        <?php ActiveForm::end(); ?>
    </section>
    <div class="clearfix"></div>
    <h2>Список товаров</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Товары отсутствуют',
    'columns' => [
        'id',
        'article',
        [
            'attribute' => 'code',
            'format' => 'raw',
            'value' => function ($model) {
                $checkExistButton = "";

                if ($model->vendor_id == 4) {
                    $checkExistButton = Html::a('<i class="far fa-question-circle"></i>', 'javascript:void(0);', ['class' => 'check-exist-product', 'data-code' => $model->code, 'data-vendor-id' => $model->vendor_id]);
                }

                return $model->code . $checkExistButton;
            }
        ],
        [
            'attribute' => 'prop_sales',
            'filter' => ArrayHelper::map(InformersValues::find()->where(['informer_id' => 10])->all(), 'id', 'name'),
        ],
        [
            'attribute' => 'active',
            'filter' => ['Не активен', 'Активен'],
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->active == 1) {
                    return Html::tag('div', 'Активен', ['style' => 'color: green;']);
                } else {
                    return Html::tag('div', 'Неактивен', ['style' => 'color: red;']);
                }
            }
        ],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->name, '/admin/catalog/' . $model->id . '/');
            }
        ],
        'base_price',
        'purchase',
        [
            'attribute' => 'price',
            'format' => 'raw',
            'value' => function ($model) {
                if (!empty($model->purchase) && !empty($model->price)) {
                    return sprintf("%s (%s%%)", $model->price, ceil(($model->price - $model->purchase) / $model->purchase * 100));
                }
                return $model->price;
            }
        ],
        [
            'attribute' => 'category_id',
            'format' => 'raw',
            'filter' => ArrayHelper::map((new Category())->categoryTree(), 'id', 'name'),
            'value' => function ($model) {
                $category = Category::findOne($model->category_id);
                if ($category) {
                    return Html::a($category->name, '/admin/category/' . $model->category_id . '/', ['target' => '_blank']);
                }
                return "Без категории";
            }
        ],
        'count',
        [
            'attribute' => 'image',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::img('/upload/' . $model->image, ['width' => 70]);
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
                    return Html::a('<i class="fas fa-copy"></i>', "/admin/catalog/$key/?action=copy");
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["admin/catalog", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/catalog/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>