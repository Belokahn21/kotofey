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
		'id' => 'filter-form-id',
		'method' => 'get'
	]); ?>
	<?php foreach ($informers as $informer): ?>
		<?php if ($values = InformersValues::find()->where(['informer_id' => $informer->id, 'active' => true])->all()): ?>
			<?= $form->field($filterModel, 'informer[' . $informer->id . '][]')->checkboxList(ArrayHelper::map($values, 'id', 'name'), [
				'id' => 'id_list_company',
				'class' => 'checkbox_list',
			])->label($informer->name); ?>
		<?php endif; ?>
	<?php endforeach; ?>
	<?= Html::submitButton('Применить', ['class' => 'btn-main show-catalog-filter run']); ?>
	<?php ActiveForm::end() ?>

</div>
