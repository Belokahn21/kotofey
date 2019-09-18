<?

use app\models\entity\Product;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\Informers;
use yii\helpers\ArrayHelper;

$this->title = Title::showTitle("Справочники"); ?>
<section>
    <h1 class="title">Справочники</h1>
    <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="tabs-container">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Основное</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <?= $form->field($model, 'informer_id')->dropDownList(ArrayHelper::map(Informers::find()->all(), 'id','name'), ['prompt'=>'Справочник']) ?>
            <?= $form->field($model, 'value')->textInput() ?>
            <?= $form->field($model, 'description')->textarea() ?>
        </div>

    </div>
    <?= Html::submitButton('Добавить'); ?>
    <? ActiveForm::end(); ?>
</section>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Значения отсутствуют',
    'columns' => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'value',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->value, '/admin/informersvalues/' . $model->id . '/');
            }
        ],
        [
            'attribute' => 'informer_id',
            'format' => 'raw',
            'value' => function ($model) {
                return \app\models\entity\Informers::findOne($model->informer_id)->name;
            }
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