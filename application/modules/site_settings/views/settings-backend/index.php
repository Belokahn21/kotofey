<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $model \app\modules\site_settings\models\entity\SiteSettings
 * @var $this \yii\web\View
 */

?>
<?php $this->title = Title::show("Настройки сайта"); ?>
<section>
    <h1 class="title">Настройки</h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
    ]); ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>
<h2 class="title">Список настроек</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Настройки отсутствуют',
    'columns' => [
        'id',
        'name',
        'code',
        'value',
        'type',
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
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

