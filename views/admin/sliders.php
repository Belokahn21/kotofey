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

/* @var \app\models\entity\Sliders $model */
/* @var \yii\web\View $this */

$this->title = Title::showTitle("Слайдеры"); ?>
    <section>
        <h1 class="title">Слайдер</h1>
        <div class="product-form">
            <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="tabs-container">
                <ul class="tabs">
                    <li class="tab-link current" data-tab="tab-1">Основное</li>
                    <li class="tab-link" data-tab="tab-2">Галерея</li>
                    <li class="tab-link" data-tab="tab-3">Прочее</li>
                </ul>

                <div id="tab-1" class="tab-content current">
                    <?php echo $form->field($model, 'name')->textInput(); ?>
                    <?php echo $form->field($model, 'link')->textInput(); ?>
                </div>
                <div id="tab-2" class="tab-content">
                </div>
                <div id="tab-3" class="tab-content">
                    <?php echo $form->field($model, 'active')->radioList(['Нет', 'Да']); ?>
                    <?php echo $form->field($model, 'sort')->textInput(); ?>
                </div>
            </div>
            <?= Html::submitButton('Добавить'); ?>
            <? ActiveForm::end(); ?>
        </div>
    </section>
    <div class="clearfix"></div>
    <h2>Список слайдеров</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Сладеры отсутствуют',
    'columns' => [
        'id',
        'name',
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
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/provider/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/catalog/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>