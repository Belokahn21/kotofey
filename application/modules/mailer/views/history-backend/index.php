<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\seo\models\tools\Title;
use app\modules\mailer\models\entity\MailHistory;
use app\modules\mailer\models\entity\MailTemplates;

/* @var $this \yii\web\View
 */

$this->title = Title::show('История отправок писем');
?>
    <div class="title-group">
        <h1>История отправок писем</h1>
    </div>

    <h2>Список отправок писем</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'История отсутствуют',
    'columns' => [
        'id',
        'email',
        [
            'format' => 'raw',
            'value' => function ($model) {
                return Html::tag('div', MailHistory::find()->where(['email' => $model->email])->count());
            },
        ],
        [
            'attribute' => 'mail_template_id',
            'filter' => ArrayHelper::map(MailTemplates::find()->all(), 'id', 'name')
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