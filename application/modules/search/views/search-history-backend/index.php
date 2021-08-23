<?php
/* @var $this \yii\web\View */
/* @var $statistic_queries array */

/* @var $model \app\modules\search\models\entity\SearchQuery */

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\seo\models\tools\Title;
use \app\modules\site\models\tools\IP;

$this->title = Title::show('История поиска');
?>
    <div class="title-group">
        <h1>История поиска</h1>
        <?= Html::a("Очистить всё", Url::to(['clean']), ['class' => 'btn-main']); ?>
    </div>

<?php if ($statistic_queries): ?>
    <?php $count = 1; ?>
    <?php foreach ($statistic_queries as $data_block): ?>

        <?php if ($count % 4 == 1) echo "<div class='row p-3'>"; ?>

        <div class="card border-info m-2" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?= $data_block['ForDate']; ?></h5>
                <p class="card-text">Запросов: <?= $data_block['NumPosts']; ?></p>
            </div>
        </div>

        <?php if ($count % 4 == 0) echo "</div>"; ?>


        <?php $count++; ?>
    <?php endforeach; ?>

    <?php if ($count % 4 != 1) echo "</div>"; ?>
<?php endif; ?>

<?php
echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'История поиска отсутствует',
    'columns' => [
        'id',
        [
            'attribute' => 'ip',
            'format' => 'raw',
            'value' => function ($model) {

                if ($ip_info = IP::getIpInfo($model->ip)) {
                    $time_zone = $ip_info['geoplugin_timezone'];
                    $country = $ip_info['geoplugin_countryName'];
                    $city = $ip_info['geoplugin_city'];
                    $region = $ip_info['geoplugin_region'];
                    $country_code = $ip_info['geoplugin_countryCode'];
                    return Html::tag('span', $model->ip . Html::tag('div', $city ?: $time_zone), [
                        'class' => "ip-info-tooltip",
                        'rel' => "tooltip",
                        'data-placement' => "left",
                        'data-html' => "true",
                        'title' => <<<INFO
Timezone: {$time_zone}<br>
Страна: {$country}<br>
Регион: {$region}<br>
Город: {$city}<br>
Код страны: {$country_code}<br>
INFO

                    ]);

                }

                return $model->ip;
            }
        ],
        'text',
        'count',
        'count_find',
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
