<?

/* @var $this yii\web\View */

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::showTitle("Управление оплатами");
?>
<section class="payment">
    <h1 class="title">Оплаты</h1>
    <? $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'active')->checkbox() ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'description')->textarea(); ?>
    <?= Html::submitButton('Добавить') ?>
    <? ActiveForm::end(); ?>
</section>
<h2 class="title">Список оплат</h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Оплаты отсутствуют',
    'columns' => [
        [
            'attribute' => 'id',
        ],
        [
            'attribute' => 'name',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
//                    return Html::img('/images/eye.png', ['class' => 'grid-view-img feedback-view']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/payment/$key"]));
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash-alt"></i>', Url::to(["/admin/payment/", 'id' => $key, 'action' => 'delete']));
                },
            ]
        ],
    ],
]); ?>
