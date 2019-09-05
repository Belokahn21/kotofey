<?

use app\models\entity\Product;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Url;

?>
<? $this->title = Title::showTitle("Разделы"); ?>
    <h1 class="title">Разделы</h1>
    <section>
        <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Основное</li>
                <li class="tab-link" data-tab="tab-2">SEO</li>
                <li class="tab-link" data-tab="tab-3">Галлерея</li>
            </ul>

            <div id="tab-1" class="tab-content current">
                <?= $form->field($model, 'name'); ?>
                <?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map($categories, 'id', 'name'), ['prompt' => 'Родительская категория']); ?>
                <?= $form->field($model, 'sort'); ?>
            </div>
            <div id="tab-2" class="tab-content">
                <?= $form->field($model, 'seo_keywords'); ?>
                <?= $form->field($model, 'seo_description'); ?>
            </div>
            <div id="tab-3" class="tab-content">
                <?= $form->field($model, 'imageFile')->fileInput(); ?>
            </div>

        </div>
        <?= Html::submitButton('Добавить'); ?>
        <? ActiveForm:: end(); ?>
    </section>
    <h2>Разделы товаров</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Разделы отсутствуют',
    'columns' => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->name, '/admin/category/' . $model->id . '/');
            }
        ],
        [
            'attribute' => 'test',
            'label' => 'Количество товаров',
            'value' => function ($model) {
                return Product::find()->where(['category' => $model->id])->count();
            },
        ],
        [
            'attribute' => 'image',
            'label' => 'Изображение',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::img($model->image, ["width" => 40]);
            },
        ],
        [
            'attribute' => 'parent',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a(\app\models\entity\Category::findOne($model->parent)->name,
                    "/admin/category/" . $model->parent . "/");
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/category/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/catalog/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>