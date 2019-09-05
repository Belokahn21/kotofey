<?

use app\models\entity\Category;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\models\entity\Promo */

?>
<? $this->title = Title::showTitle("Промокоды"); ?>
<section>
    <h1 class="title">Промокоды</h1>
    <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="tabs-container">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Основное</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <?= $form->field($model, 'code'); ?>
            <?= $form->field($model, 'discount'); ?>
            <?= $form->field($model, 'count'); ?>
        </div>

    </div>
    <?= Html::submitButton('Добавить'); ?>
    <? ActiveForm::end(); ?>
</section>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Товары отсутствуют',
    'columns' => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'code',
        ],
        [
            'attribute' => 'discount',
        ],
        [
            'attribute' => 'count',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/promo/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/promo/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>