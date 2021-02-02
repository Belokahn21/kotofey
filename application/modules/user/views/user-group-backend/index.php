<?php

/* @var $this yii\web\View */

/* @var $model \app\modules\rbac\models\entity\AuthItem */

use app\modules\rbac\models\entity\AuthItemChild;
use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\rbac\models\entity\AuthItem;
use yii\helpers\ArrayHelper;

$this->title = Title::show("Управление группами");
?>
    <section class="group-form">
        <div class="group-form-wrap">
            <h1 class="title">Группы</h1>
            <?php $form = ActiveForm::begin(); ?>
            <?= $this->render('_form', [
                'model' => $model,
                'permissions' => $permissions,
                'form' => $form
            ]); ?>
            <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </section>
    <h2 class="title">Список групп</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Товары отсутствуют',
    'columns' => [
        'name',
        'description',
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