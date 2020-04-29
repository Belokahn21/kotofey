<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\entity\Category;
use app\models\entity\InformersValues;
use app\models\entity\Stocks;
use app\models\entity\SiteSettings;

/* @var \app\models\entity\Providers $model */
/* @var \yii\web\View $this */

$this->title = Title::showTitle("Поставщик:" . $model->name); ?>
<section>
    <h1 class="title">Поставщик: <?php echo $model->name; ?></h1>
	<?= Html::a('Назад', ['admin/vendor'], ['class' => 'btn-main']) ?>
    <div class="product-form">
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?= $this->render('../_forms/_vendor', [
			'model' => $model,
			'form' => $form
		]); ?>
		<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
		<?php ActiveForm::end(); ?>
    </div>
</section>