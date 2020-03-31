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

    <div class="accordion-menu">
		<?php foreach ($informers as $informer): ?>
			<?php
			$values = InformersValues::find()->where(['informer_id' => $informer->id, 'active' => true])->orderBy(['name' => SORT_ASC]);
			if ($productPropertiesValues) {
				$values->andWhere(['id' => ArrayHelper::getColumn($productPropertiesValues, 'value')]);
			}
			$values = $values->all();
			?>
			<?php if ($values): ?>
                <div>
                    <div class="dropdownlink"><?php /*<i class="fa fa-road" aria-hidden="true"></i>*/ ?> <?= $informer->name; ?>
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </div>
                    <div class="submenuItems">
                        <div>
							<?= $form->field($filterModel, 'informer[' . $informer->id . '][]')->checkboxList(ArrayHelper::map($values, 'id', 'name'), [
								'id' => 'id_list_company',
								'class' => 'checkbox_list',
							])->label(false); ?>
                        </div>
                    </div>
                </div>

			<?php endif; ?>
		<?php endforeach; ?>
    </div>
	<?= Html::submitButton('Применить', ['class' => 'btn-main show-catalog-filter run']); ?>
	<?php ActiveForm::end() ?>

</div>
