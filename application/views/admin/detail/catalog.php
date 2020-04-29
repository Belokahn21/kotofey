<?php

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

/* @var $model \app\models\entity\Product */
/* @var $modelDelivery \app\models\entity\ProductOrder */
/* @var $properties \app\models\entity\ProductProperties[] */

$this->title = Title::showTitle("Товары"); ?>
<h1 class="title">Просмотр: <?= $model->name; ?></h1>
<?= Html::a("Назад", '/admin/catalog/', ['class' => 'btn-main']) ?>
<?= Html::a("Посмотреть на сайте", $model->detail, ['target' => '_blank', 'class' => 'btn-main']); ?>
<div class="clearfix"></div>
<section>
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $this->render('../_forms/_catalog', [
		'model' => $model,
		'modelDelivery' => $modelDelivery,
		'form' => $form,
		'properties' => $properties
	]); ?>
	<?php if (Yii::$app->request->get('action') == 'copy'): ?>
		<?php echo Html::submitInput('Копировать', ['name' => 'action', 'class' => 'btn-main', 'value' => 'new']); ?>
		<?php echo Html::submitInput('Отмена', ['name' => 'action', 'class' => 'btn-main', 'value' => 'cancel']); ?>
	<?php else: ?>
		<?php echo Html::submitInput('Обновить', ['class' => 'btn-main']); ?>
	<?php endif; ?>
	<?php ActiveForm::end(); ?>
</section>