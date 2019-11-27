<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $categories \app\models\entity\Category[] */
/* @var $model \app\models\entity\Category */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-seo-tab" data-toggle="tab" href="#nav-seo" role="tab" aria-controls="nav-seo" aria-selected="false">SEO</a>
        <a class="nav-item nav-link" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab" aria-controls="nav-gallery" aria-selected="false">Изображения</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
		<?= $form->field($model, 'name'); ?>
		<?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map($categories, 'id', 'name'), ['prompt' => 'Родительская категория']); ?>
		<?= $form->field($model, 'sort'); ?>
    </div>
    <div class="tab-pane fade" id="nav-seo" role="tabpanel" aria-labelledby="nav-seo-tab">
		<?= $form->field($model, 'seo_keywords'); ?>
		<?= $form->field($model, 'seo_description'); ?>
    </div>
    <div class="tab-pane fade" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab">

		<?php if ($model->image): ?>
			<?= Html::img('/web/upload/' . $model->image, ['width' => 200]); ?>
		<?php endif; ?>
		<?= $form->field($model, 'image')->fileInput(); ?>
    </div>
</div>