<?

use app\models\tool\seo\Title;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::showTitle("Техническая поддержка"); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Обращения отсутствуют',
    'columns' => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'user_id',
        ],
        [
            'attribute' => 'category_id',
        ],
        [
            'attribute' => 'title',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/catalog/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/catalog/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>
