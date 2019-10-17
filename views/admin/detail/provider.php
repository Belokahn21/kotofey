<?

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
    <div class="product-form">
		<? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Основное</li>
                <li class="tab-link" data-tab="tab-2">Галерея</li>
                <li class="tab-link" data-tab="tab-3">Прочее</li>
            </ul>

            <div id="tab-1" class="tab-content current">
				<?php echo $form->field($model, 'name')->textInput(); ?>
				<?php echo $form->field($model, 'description')->textarea(); ?>
				<?php echo $form->field($model, 'notes')->textarea(); ?>
				<?php echo $form->field($model, 'link')->textInput(); ?>
            </div>
            <div id="tab-2" class="tab-content">
				<?php echo $form->field($model, 'image')->fileInput(); ?>
            </div>
            <div id="tab-3" class="tab-content">
				<?php echo $form->field($model, 'active')->radioList(['Нет', 'Да']); ?>
				<?php echo $form->field($model, 'sort')->textInput(); ?>
            </div>
        </div>
		<?= Html::submitButton('Обновить'); ?>
		<? ActiveForm::end(); ?>
    </div>
</section>