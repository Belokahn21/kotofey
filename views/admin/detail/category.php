<?

use app\models\entity\Product;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::showTitle("Раздел: " . $model->name); ?>
<section>
    <h1 class="title">Раздел: <?= $model->name; ?></h1>
	<?= Html::a("Назад", '/admin/category/', ['class' => 'btn-back']) ?>
	<? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $this->render('../_forms/_category', [
		'form' => $form,
		'model' => $model,
		'categories' => $categories,
	]); ?>
	<?= Html::submitButton('Обновить'); ?>
	<? ActiveForm:: end(); ?>
</section>