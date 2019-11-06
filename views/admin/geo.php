<?

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $model \app\models\entity\Geo */
/* @var $this \yii\web\View */

$this->title = Title::showTitle("Гео объекты"); ?>
<section>
    <h1 class="title">Гео объекты</h1>
    <div class="celearfix"></div>
    <div class="product-form">
		<? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?= $this->render('_forms/_geo', ['form' => $form, 'model' => $model]); ?>
		<?= Html::submitButton('Добавить'); ?>
		<? ActiveForm::end(); ?>
    </div>
</section>
<div class="clearfix"></div>
<h2>Список гео объектов</h2>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $model,
	'emptyText' => 'Гео объекты отсутствуют',
	'columns' => [
		'id',
		'name',
		[
			'attribute' => 'created_at',
			'format' => ['date', 'dd.MM.YYYY'],
			'options' => ['width' => '200']
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
				'view' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-copy"></i>', "/admin/geo/$key/?action=copy");
				},
				'update' => function ($url, $model, $key) {
					return Html::a('<i class="far fa-eye"></i>', Url::to(["/admin/geo/$key"]));
				},
				'delete' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-trash-alt"></i>',
						Url::to(["/admin/geo/", 'id' => $key, 'action' => 'delete']));
				},
			]
		],
	],
]); ?>
<div style="clear: both;"></div>
