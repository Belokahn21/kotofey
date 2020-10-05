<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\tool\seo\Title;
use yii\grid\GridView;

/* @var $this \yii\web\View
 * @var $model \app\modules\promotion\models\entity\PromotionMechanics
 * @var $searchModel \app\modules\promotion\models\search\PromotionMechanicsSearch
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = Title::showTitle('Механики акций магазина');
?>
    <div class="title-group">
        <h1>Механики акций магазина</h1>
    </div>
<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'form' => $form,
    'model' => $model,
]); ?>
<?php ActiveForm::end() ?>
<h2>Список механик</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Акционные механики отсутствуют',
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