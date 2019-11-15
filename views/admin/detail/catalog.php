<?

use app\models\entity\InformersValues;
use app\models\entity\SiteSettings;
use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\entity\Category;
use yii\helpers\Json;
use app\models\tool\Currency;
use app\models\entity\ProductPropertiesValues;
use app\models\entity\Stocks;

/* @var @model \app\models\entity\Product $model */
/* @var $properties \app\models\entity\ProductProperties[] */

$this->title = Title::showTitle("Товары"); ?>
<h1 class="title">Просмотр: <?= $model->name; ?></h1>
<?= Html::a("Назад", '/admin/catalog/', ['class' => 'btn-back']) ?>
<?= Html::a("Посмотреть на сайте", $model->detail, ['target' => '_blank', 'class' => 'btn-back']); ?>
<div class="clearfix"></div>
<section>
	<? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $this->render('../_forms/_catalog', [
		'model' => $model,
		'form' => $form,
		'properties' => $properties
	]); ?>
	<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
	<? ActiveForm::end(); ?>
</section>