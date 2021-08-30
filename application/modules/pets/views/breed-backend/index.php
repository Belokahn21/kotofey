<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\pets\models\entity\Animal;

/* @var $this \yii\web\View */
/* @var $model mixed */
/* @var $searchModel \app\modules\pets\models\search\BreedSearchForm */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $animals \app\modules\pets\models\entity\Animal[] */

$this->title = 'Породы';
?>
    <div class="title-group">
        <h1>Породы</h1>
    </div>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
    'animals' => $animals,
]) ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
    <h2>Список пород</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Породы отсутствуют',
    'columns' => [
        'id',
        [
            'attribute' => 'is_active',
            'filter' => ['Не активен', 'Активен'],
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->is_active) {
                    return Html::tag('span', 'Активен', ['class' => 'green']);
                } else {
                    return Html::tag('span', 'Не активен', ['class' => 'red']);
                }
            }
        ],
        'name',
        'size',
        'sort',
        [
            'attribute' => 'animal_id',
            'filter' => ArrayHelper::map(Animal::find()->all(), 'id', 'name'),
            'format' => 'raw',
            'value' => function ($model) {
                $animal = Animal::findOne($model->animal_id);
                if ($animal) return Html::a($animal->name);

                return $model->anmimal_id;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::a('<i class="far fa-copy"></i>', Url::to(["copy", 'id' => $key]));
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["update", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>', Url::to(["delete", 'id' => $key]));
                },
            ]
        ],
    ],
]); ?>