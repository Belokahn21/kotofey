<?php
/* @var $this \yii\web\View */

/* @var $model \app\modules\search\models\entity\SearchQuery */

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\seo\models\tools\Title;

$this->title = Title::show('История поиска');
?>
    <div class="title-group">
        <h1>История поиска</h1>
        <?= Html::a("Очистить всё", Url::to(['clean']), ['class' => 'btn-main']); ?>
    </div>

<?php if ($statistic_queries): ?>
<!--    --><?php //\app\modules\site\models\tools\Debug::p($statistic_queries); ?>
    <?php foreach ($statistic_queries as $data_block): ?>
        <div class="card border-info mb-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?= $data_block['ForDate']; ?></h5>
                <p class="card-text">Запросов: <?= $data_block['NumPosts']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php
echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'История поиска отсутствует',
    'columns' => [
        'id',
        'ip',
        'text',
        'count',
        [
            'attribute' => 'created_at',
            'format' => ['date', 'dd.MM.YYYY'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::a('<i class="fas fa-file-alt"></i>', Url::to(["report", 'id' => $key]));
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["update", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
//                    if ($key) {
//                        return Html::a('<i class="fas fa-trash-alt"></i>',
//                            Url::to(["admin/order", 'id' => $key, 'action' => 'delete']));
//                    }
                }
            ]
        ],
    ],
]);
