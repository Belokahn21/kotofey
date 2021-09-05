<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $models \app\modules\media\models\entity\Media[] */

$this->title = \app\modules\seo\models\tools\Title::show('Медиа');
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Медиа отсутствуют',
    'columns' => [
        'id',
        'name',
        'path',
        'location',
        [
            'format' => 'raw',
            'value' => function ($model) {
                return Html::img($model->cdnData['secure_url'], ['width' => 70]);
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd.MM.YYYY'],
            'options' => ['width' => '200']
        ],
        [
            'attribute' => 'updated_at',
            'format' => ['date', 'dd.MM.YYYY'],
            'options' => ['width' => '200']
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
