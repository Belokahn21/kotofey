<?

use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\entity\Informers;

/* @var $model \app\models\entity\InformersValues */
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Title::showTitle("Справочники"); ?>
    <section>
        <h1 class="title">Значения справочников</h1>
        <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $this->render('_forms/_informers-values', [
            'model' => $model,
            'form' => $form,
        ]) ?>
        <?= Html::submitButton('Добавить'); ?>
        <? ActiveForm::end(); ?>
    </section>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Значения отсутствуют',
    'columns' => [
        'id',
        'active',
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->name, '/admin/informers-values/' . $model->id . '/');
            }
        ],
        'sort',
        'description',
        [
            'attribute' => 'informer_id',
            'format' => 'raw',
            'filter' => ArrayHelper::map(Informers::find()->asArray(true)->all(), 'id', 'name'),
            'value' => function ($model) {
                return Informers::findOne($model->informer_id)->name;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/informers-values/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>',
                        Url::to(["/admin/informers-values/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>