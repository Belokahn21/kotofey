<?

use app\models\tool\seo\Title;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\entity\SiteTypeSettings;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::showTitle("Настройки сайта");

/* @var $model \app\models\entity\SiteSettings */

?>
    <section class="site-settings">
        <h1 class="title">Настройки сайта</h1>
        <div class="site-settings-wrap">
            <div class="site-settings-form">
				<? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
				<? if (!empty($_GET['type'])) {
					$model->type = $_GET['type'];
				} ?>
				<?= $form->field($model, 'type')->dropDownList(ArrayHelper::map(SiteTypeSettings::find()->all(), 'code', 'name'), ['prompt' => 'Тип параметра', 'id' => 'select-type-settings']); ?>
				<?= $form->field($model, 'name'); ?>
				<?= $form->field($model, 'code'); ?>
				<? if ($model->type == 'file'): ?>
					<?= $form->field($model, 'file')->fileInput(); ?>
				<? else: ?>
					<?= $form->field($model, 'value'); ?>
				<? endif; ?>
				<?= Html::submitButton("Прменить", ['class' => 'btn-main']) ?>
				<? ActiveForm::end(); ?>
            </div>
    </section>

    <h2>Список парметров</h2>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'emptyText' => 'Настройки отсутствуют',
	'columns' => [
		'id',
		'code',
		[
			'attribute' => 'name',
			'format' => 'raw',
			'value' => function ($model) {
				return Html::a($model->name, Url::to(['admin/settings', 'id' => $model->id]));
			}
		],
		'value',
		[
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
				'view' => function ($url, $model, $key) {
//					return Html::a('<i class="fas fa-copy"></i>', "/admin/catalog/$key/?action=copy");
				},
				'update' => function ($url, $model, $key) {
					return Html::a('<i class="far fa-eye"></i>', Url::to(['admin/settings', 'id' => $key]));
				},
				'delete' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-trash-alt"></i>',
						Url::to(["admin/settings", 'id' => $key, 'action' => 'delete']));
				},
			]
		],
	],
]); ?>