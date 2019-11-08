<?

use app\models\entity\Product;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\Informers;
use yii\helpers\ArrayHelper;

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
    'filterModel' => $model,
    'emptyText' => 'Значения отсутствуют',
    'columns' => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'value',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->value, '/admin/informersvalues/' . $model->id . '/');
            }
        ],
        [
            'attribute' => 'informer_id',
            'format' => 'raw',
            'value' => function ($model) {
                return \app\models\entity\Informers::findOne($model->informer_id)->name;
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