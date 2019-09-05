<?

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<? $this->title = Title::showTitle("Склады"); ?>
<section>
    <h1 class="title">Склады</h1>
    <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="tabs-container">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Основное</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <?= $form->field($model, 'name'); ?>
            <?= $form->field($model, 'address'); ?>
            <hr/>
            <div>
                <h1>Время работы</h1>
                <div style="display: flex">
                    <div style="display:flex;">
                        <?= $form->field($model, 'hour_start')->dropDownList(range(0, 23)); ?>
                        <?= $form->field($model, 'minute_start')->dropDownList(range(0, 59)); ?>
                    </div>
                    <div style="display:flex; margin: 0 0 0 10%;">
                        <?= $form->field($model, 'hour_end')->dropDownList(range(0, 23)); ?>
                        <?= $form->field($model, 'minute_end')->dropDownList(range(0, 59)); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?= Html::submitButton('Добавить'); ?>
    <? ActiveForm::end(); ?>
</section>
<h2 class="title">Список статусов</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Склады отсутствуют',
    'columns' => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'name',
        ],
        [
            'attribute' => 'address',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/stocks/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>', Url::to(["/admin/stocks/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>
