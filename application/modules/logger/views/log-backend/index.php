<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\seo\models\tools\Title;
use app\modules\logger\models\entity\Logger;

/* @var $this \yii\web\View
 * @var $model \app\modules\logger\models\entity\Logger
 */

$this->title = Title::show('Логи сайта');
?>
    <div class="title-group">
        <h1>Логирование</h1>
        <?= Html::a('Очистить', Url::to(['clear']), ['class' => 'btn-main']); ?>
    </div>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Логи отсутствуют',
    'columns' => [
        'id',
        'message',
        'status',
        [
            'attribute' => 'uniqCode',
            'format' => 'raw',
            'filter' => ArrayHelper::map(Logger::find()->select('uniqCode')->groupBy(['uniqCode'])->all(), 'uniqCode', 'uniqCode')
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
//                    return Html::a('<i class="far fa-eye"></i>', Url::to(["update", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>', Url::to(["delete", 'id' => $key]));
                },
            ]
        ],
    ],
]); ?>