<?php

use app\models\entity\InformersValues;
use app\models\forms\CatalogFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $filterModel CatalogFilter
 * @var $informers InformersValues[]
 */

?>
<button class="show-catalog-filter filter-mobile switcher">Показать фильтр</button>
<div class="filter">
	<?php $form = ActiveForm::begin([
		'options' => [/*'data-pjax' => true*/],
		'id' => 'filter-form-id',
		'method' => 'get'
	]); ?>
    <div style="display: flex; flex-direction: row;">
<!--		--><?php //echo $form->field($filterModel, 'price_from'); ?>
<!--		--><?php //echo $form->field($filterModel, 'price_to'); ?>
    </div>
    <div style="display: flex; flex-direction: row;">
<!--		--><?php //echo $form->field($filterModel, 'weight_from'); ?>
<!--		--><?php //echo $form->field($filterModel, 'weight_to'); ?>
    </div>


	<?php foreach ($informers as $informer): ?>
		<?= $form->field($filterModel, 'informer[' . $informer->id . '][]')->checkboxList(ArrayHelper::map(InformersValues::find()->where(['informer_id' => $informer->id, 'active' => true])->all(), 'id', 'name'), [
			'id' => 'id_list_company',
			'class' => 'checkbox_list',
		])->label($informer->name); ?>
	<?php endforeach; ?>


	<?= Html::submitButton('Применить', ['class' => 'btn-main show-catalog-filter run']); ?>
	<?php ActiveForm::end() ?>

</div>
