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
	<?= $this->render('_forms/_payment', [
		'model' => $model,
		'form' => $form,
	]) ?>
	<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
	<? ActiveForm::end(); ?>
</section>
<h2 class="title">Список оплат</h2>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $model,
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
