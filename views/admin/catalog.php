<?

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

/* @var \app\models\entity\Product $model */

$this->title = Title::showTitle("Товары"); ?>
    <section>
        <h1 class="title">Товары</h1>
        <div class="celearfix"></div>
        <?= Html::a("Экспорт товаров в YML", "?export=yml"); ?>
        <div class="celearfix"></div>
        <div class="product-wrap">
            <div class="product-form">
                <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class="tabs-container">
                    <ul class="tabs">
                        <li class="tab-link current" data-tab="tab-1">Основное</li>
                        <li class="tab-link" data-tab="tab-2">SEO</li>
                        <li class="tab-link" data-tab="tab-3">Галлерея</li>
                        <li class="tab-link" data-tab="tab-4">Дополнительно</li>
                        <li class="tab-link" data-tab="tab-5">Свойства</li>
                    </ul>

                    <div id="tab-1" class="tab-content current">
                        <?= $form->field($model, 'name'); ?>
                        <?= $form->field($model, 'description')->textarea(); ?>
                        <div class="product-form__price">
                            <?= $form->field($model, 'price')->textInput(['id' => 'id-price']); ?>
                            <div class="set-price">
                                <a href=""
                                   onclick="document.getElementById('id-price').value=(parseInt(document.getElementById('id-purchase').value)+parseInt((document.getElementById('id-purchase').value*<?= SiteSettings::getValueByCode('saleup') ?>)/100)); return false;">%
                                    наценка</a>
                            </div>
                        </div>
                        <div class="product-form__purchase">
                            <?= $form->field($model, 'purchase')->textInput(['id' => 'id-purchase']); ?>
                        </div>
                        <div class="product-form__count">
                            <?= $form->field($model, 'count'); ?>
                        </div>
                        <div class="clearfix"></div>
                        <?= $form->field($model,
                            'category')->dropDownList(ArrayHelper::map((new Category())->categoryTree(), 'id', 'name'),
                            ['prompt' => 'Раздел']); ?>
                        <div class="clearfix"></div>
                        <hr/>
                    </div>
                    <div id="tab-2" class="tab-content">
                        <?= $form->field($model, 'seo_description')->textarea(); ?>
                        <?= $form->field($model, 'seo_keywords'); ?>
                    </div>
                    <div id="tab-3" class="tab-content">
                        <div class="product-form__simple-image">
                            <img src="">
                            <?= $form->field($model, 'imageFile')->fileInput(); ?>
                        </div>
                        <div class="product-form__more-image">
                            <img src="">
                            <?= $form->field($model, 'imagesFiles[]')->fileInput([
                                'multiple' => true,
                                'accept' => 'image/*'
                            ]); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="tab-4" class="tab-content">
                        <?= $form->field($model, 'code')->textInput(); ?>
                        <?= $form->field($model, 'vitrine')->radioList(["Нет", "Да"]); ?>
                        <?= $form->field($model, 'active')->radioList(["Не активен", "Активен"]); ?>
                        <?= $form->field($model, 'stock_id')->dropDownList(ArrayHelper::map(Stocks::find()->all(), 'id',
                            'name')) ?>
                    </div>
                    <div id="tab-5" class="tab-content">
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            <? /* @var $property \app\models\entity\ProductProperties */ ?>
                            <? foreach ($properties as $property): ?>
                                <? if ($property->type == 1): ?>
                                    <?= $form->field($model,
                                        'properties[' . $property->id . ']')->dropDownList(ArrayHelper::map(InformersValues::find()->where(['informer_id' => $property->informer_id])->all(),
                                        'id', 'value'), ['prompt' => $property->name])->label($property->name); ?>
                                <? else: ?>
                                    <?= $form->field($model,
                                        'properties[' . $property->id . ']')->textInput()->label($property->name); ?>
                                <? endif; ?>
                            <? endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?= Html::submitButton('Добавить'); ?>
                <? ActiveForm::end(); ?>
            </div>

            <div class="product-preview">
                <h2 class="title">Предпросмотр</h2>
                <div class="product-preview__image">
                    <img src="/web/upload/images/main_baner.jpg" title="" alt="">
                </div>
                <div class="product-preview__name">
                    adasd
                </div>
            </div>
        </div>
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
        'code',
        [
            'attribute' => 'active',
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
        'price',
        'purchase',
        [
            'attribute' => 'category',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(Category::findOne($model->category)->name, '/admin/category/' . $model->category . '/',
                    ['target' => '_blank']);
            }
        ],
        'count',
        [
            'attribute' => 'image',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::img($model->image, ['width' => 70]);
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
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/catalog/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/catalog/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>