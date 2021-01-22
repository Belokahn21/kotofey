<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\tool\seo\Title;
use app\modules\vendors\models\entity\Vendor;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductCategory;
use app\models\tool\parser\providers\SibagroTrade;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\widgets\stockOut\StockOutWidget;
use app\modules\catalog\widgets\FillFromVendor\FillFromVendorWidget;

/* @var $this \yii\web\View
 * @var $model \app\modules\catalog\models\entity\Product
 * @var $properties \app\modules\catalog\models\entity\SaveProductProperties[]
 * @var $modelDelivery \app\modules\catalog\models\entity\ProductOrder
 */

$this->title = Title::show('Товары');
?>
    <div class="title-group">
        <h1>Товары</h1>
        <?= Html::a('Убрать акционные товары', Url::to(['/admin/catalog/product-backend/discount-clean']), ['class' => 'btn-main']); ?>
        <?= Html::a('Обновить сибагро', Url::to(['/admin/catalog/update-sibagro/upload']), ['class' => 'btn-main']); ?>
        <?= StockOutWidget::widget(); ?>
    </div>
<?= FillFromVendorWidget::widget(); ?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'properties' => $properties,
    'modelDelivery' => $modelDelivery,
]) ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
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
                if ($model->vendor_id == 4) return Html::a($model->code, SibagroTrade::getProductDetailByCode($model->code), ['target' => '_blank']) . Html::a('<i class="far fa-question-circle"></i>', 'javascript:void(0);', ['class' => 'js-check-exist-product', 'data-code' => $model->code, 'data-vendor-id' => $model->vendor_id]);

                return $model->code;
            }
        ],
        [
            'attribute' => 'status_id',
            'filter' => ['Черновик', 'Активен'],
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->status_id == Product::STATUS_ACTIVE) {
                    return Html::tag('div', 'Активен', ['style' => 'color: green;']);
                } elseif ($model->status_id == Product::STATUS_WAIT) {
                    return Html::tag('div', 'Ожидается', ['style' => 'color: orange;']);
                } else {
                    return Html::tag('div', 'Черновик', ['style' => 'color: red;']);
                }
            }
        ],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->name, Url::to(["update", 'id' => $model->id]));
            }
        ],
        [
            'attribute' => 'vendor_id',
            'filter' => ArrayHelper::map(Vendor::find()->all(), 'id', 'name'),
            'value' => function ($model) {
                return @Vendor::findOne($model->vendor_id)->name;
            }
        ],
        [
            'label' => 'Цены',
            'format' => 'raw',
            'options' => [
                'width' => '200px'
            ],
            'value' => function ($model) {
                $out = "";

                @$out .= "Цена: " . $model->price . sprintf(" (%s%%)", ProductHelper::getMarkup($model)) . "<br>";
                if ($model->discount_price) {
                    @$out .= "Со скидкой: " . $model->discount_price . "<br>";
                }
                @$out .= "Закупочная: " . $model->purchase . "<br>";
                @$out .= "+" . ($model->price - $model->purchase) . "<br>";
                return $out;
            }
        ],
        [
            'attribute' => 'category_id',
            'format' => 'raw',
            'filter' => ArrayHelper::map((new ProductCategory())->categoryTree(), 'id', 'name'),
            'value' => function ($model) {
                $category = ProductCategory::findOne($model->category_id);
                if ($category) {
                    return Html::a($category->name, Url::to(['/admin/catalog/product-category-backend/index', 'id' => $model->category_id]), ['target' => '_blank']);
                }
                return "Без категории";
            }
        ],
        'count',
        [
            'attribute' => 'image',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::img(ProductHelper::getImageUrl($model), ['width' => 70]);
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd.MM.YYYY'],
            'options' => ['width' => '200']
        ],
        [
            'attribute' => 'updated_at',
            'format' => ['date', 'dd.MM.YYYY'],
            'options' => ['width' => '200']
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-copy"></i>', Url::to(["copy", 'id' => $key]));
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