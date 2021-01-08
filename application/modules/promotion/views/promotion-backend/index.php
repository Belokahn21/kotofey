<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this \yii\web\View
 * @var $model \app\modules\promotion\models\entity\Promotion
 * @var $xstring string
 * @var $subModel \app\modules\promotion\models\entity\PromotionProductMechanics
 * @var $subModels \app\modules\promotion\models\entity\PromotionProductMechanics[]
 * @var $sliderImagesModel \app\modules\content\models\entity\SlidersImages
 */

$this->title = Title::showTitle('Акции магазина');
?>
    <div class="title-group">
        <h1>Акции магазина</h1>
    </div>

<?php Pjax::begin(); ?>


<?php $form = ActiveForm::begin([
    'options' => ['data-pjax' => '']
]) ?>
<?= $this->render('_form', [
    'form' => $form,
    'model' => $model,
    'subModel' => $subModel,
    'xstring' => $xstring,
]); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end() ?>


<?php Pjax::end(); ?>
    <h2>Список акций</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Акции отсутствуют',
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
//                    return Html::a('<i class="fas fa-copy"></i>', "/admin/catalog/$key/?action=copy");
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